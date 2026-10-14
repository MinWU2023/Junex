<?php

namespace App\Modules\Translate\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\Locale;
use App\Services\Translate\FreeTranslateService;
use App\Services\Translate\RichTextTranslateHelper;
use App\Services\Translate\TranslateRegistryService;
use App\Services\Translate\TranslationPersistenceService;
use Illuminate\Http\Request;

class TranslateWorkbenchController extends BaseController
{
    protected TranslateRegistryService $registry;
    protected TranslationPersistenceService $persistence;
    protected FreeTranslateService $translator;
    protected RichTextTranslateHelper $richText;

    public function __construct(
        TranslateRegistryService $registry,
        TranslationPersistenceService $persistence,
        FreeTranslateService $translator,
        RichTextTranslateHelper $richText
    ) {
        $this->registry = $registry;
        $this->persistence = $persistence;
        $this->translator = $translator;
        $this->richText = $richText;
        $this->viewPath = 'Translate.Views';
    }

    public function index()
    {
        return view($this->viewPath . '.workbench');
    }

    public function modules()
    {
        return $this->data($this->registry->modules());
    }

    public function fields(Request $request)
    {
        $module = (string) $request->get('module', '');
        if (!$this->registry->findModule($module)) {
            return $this->badRequest('Invalid module');
        }

        return $this->data($this->registry->fields($module));
    }

    public function locales()
    {
        $locales = Locale::query()
            ->orderByDesc('sort')
            ->get(['language', 'language_code'])
            ->filter(fn ($row) => $row->language_code !== 'en')
            ->values()
            ->map(fn ($row) => [
                'code' => $row->language_code,
                'label' => $row->language ?: $row->language_code,
            ]);

        return $this->data($locales);
    }

    public function records(Request $request)
    {
        $module = (string) $request->get('module', '');
        $modelClass = $this->registry->modelClass($module);
        if (!$modelClass) {
            return $this->badRequest('Invalid module');
        }

        $limit = min(max((int) $request->get('limit', 50), 1), 200);
        $keyword = trim((string) $request->get('keyword', ''));
        $query = $modelClass::query()->with('translations');
        if ($keyword !== '') {
            if (is_numeric($keyword)) {
                $query->where('id', (int) $keyword);
            } else {
                try {
                    $query->whereTranslationLike('name', '%' . $keyword . '%');
                } catch (\Throwable $e) {
                    if (\Illuminate\Support\Facades\Schema::hasColumn($modelClass::make()->getTable(), 'name')) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    }
                }
            }
        }
        $paginator = $query->orderByDesc('id')->paginate($limit);
        $items = collect($paginator->items())->map(function ($model) {
            return [
                'id' => $model->getKey(),
                'label' => $this->registry->displayNameForRecord($model),
            ];
        });

        return $this->data([
            'items' => $items,
            'total' => $paginator->total(),
            'page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
        ]);
    }

    public function source(Request $request)
    {
        $module = (string) $request->get('module', '');
        $id = (int) $request->get('id', 0);
        $fields = array_values(array_filter((array) $request->get('fields', [])));
        $modelClass = $this->registry->modelClass($module);
        if (!$modelClass || $id <= 0 || empty($fields)) {
            return $this->badRequest('Invalid parameters');
        }

        $model = $modelClass::with('translations')->find($id);
        if (!$model) {
            return $this->badRequest('Record not found');
        }

        $targetLocale = (string) $request->get('locale', '');
        $fieldMeta = collect($this->registry->fields($module))->keyBy('name');
        $source = $this->persistence->getEnglishSource($model, $fields);
        $existing = $targetLocale !== '' && $targetLocale !== 'en'
            ? $this->persistence->getLocaleTranslation($model, $targetLocale, $fields)
            : [];
        $payload = [];
        foreach ($source as $field => $value) {
            $meta = $fieldMeta->get($field, []);
            $payload[$field] = [
                'value' => $value,
                'existing' => $existing[$field] ?? '',
                'type' => $meta['type'] ?? 'text',
                'label' => $meta['label'] ?? $field,
                'is_rich' => $this->richText->isRich($meta['type'] ?? 'text', $value),
            ];
        }

        return $this->data([
            'id' => $id,
            'label' => $this->registry->displayNameForRecord($model),
            'locale' => $targetLocale,
            'fields' => $payload,
        ]);
    }

    public function allIds(Request $request)
    {
        $module = (string) $request->get('module', '');
        $modelClass = $this->registry->modelClass($module);
        if (!$modelClass) {
            return $this->badRequest('Invalid module');
        }

        $ids = $modelClass::query()->orderByDesc('id')->pluck('id');

        return $this->data($ids);
    }

    public function translateText(Request $request)
    {
        $text = (string) $request->get('text', '');
        $target = (string) $request->get('locale', '');
        $type = (string) $request->get('type', 'text');
        $isRich = filter_var($request->get('is_rich', false), FILTER_VALIDATE_BOOLEAN);
        if ($target === '' || $target === 'en') {
            return $this->badRequest('Invalid locale');
        }

        try {
            if ($isRich || $this->richText->isRich($type, $text)) {
                $pack = $this->richText->extract($text);
                $translated = [];
                foreach ($pack['segments'] as $segment) {
                    $translated[] = $this->translator->translate($segment, $target);
                }
                $result = $this->richText->restore($pack['template'], $translated);
            } else {
                $result = $this->translator->translate($text, $target);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }

        return $this->data([
            'text' => $result,
            'is_rich' => $this->richText->isRich($type, $text),
        ]);
    }

    public function save(Request $request)
    {
        $module = (string) $request->get('module', '');
        $id = (int) $request->get('id', 0);
        $locale = (string) $request->get('locale', '');
        $fields = (array) $request->get('fields', []);
        $modelClass = $this->registry->modelClass($module);
        if (!$modelClass || $id <= 0 || $locale === '' || $locale === 'en' || empty($fields)) {
            return $this->badRequest('Invalid parameters');
        }

        $model = $modelClass::find($id);
        if (!$model) {
            return $this->badRequest('Record not found');
        }

        $allowed = collect($this->registry->fields($module))->pluck('name')->all();
        $filtered = [];
        foreach ($fields as $field => $value) {
            if (in_array($field, $allowed, true)) {
                $filtered[$field] = is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE);
            }
        }
        if (empty($filtered)) {
            return $this->badRequest('No valid fields');
        }

        try {
            $this->persistence->saveTranslation($model, $locale, $filtered);
        } catch (\Throwable $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }

        return $this->data([
            'id' => $id,
            'locale' => $locale,
            'fields' => array_keys($filtered),
        ]);
    }

}
