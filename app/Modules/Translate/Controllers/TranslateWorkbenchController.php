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
        try {
            $modules = $this->registry->modules();
        } catch (\Throwable $e) {
            $modules = [];
        }

        $locales = Locale::query()
            ->orderByDesc('sort')
            ->get(['language', 'language_code'])
            ->filter(fn ($row) => $row->language_code !== 'en')
            ->values()
            ->map(fn ($row) => [
                'code' => $row->language_code,
                'label' => $row->language ?: $row->language_code,
            ]);

        $selectedModule = (string) request()->get('module', '');

        return view($this->viewPath . '.workbench', [
            'modules' => $modules,
            'locales' => $locales,
            'selectedModule' => $selectedModule,
        ]);
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
        $table = $modelClass::make()->getTable();
        $query = $modelClass::query()->with('translations');
        if ($keyword !== '') {
            if (is_numeric($keyword)) {
                $query->where($table . '.id', (int) $keyword);
            } else {
                $query->where(function ($builder) use ($keyword, $table, $modelClass) {
                    foreach (['sign', 'name'] as $column) {
                        if (\Illuminate\Support\Facades\Schema::hasColumn($table, $column)) {
                            $builder->orWhere($table . '.' . $column, 'like', '%' . $keyword . '%');
                        }
                    }
                    try {
                        $builder->orWhereTranslationLike('name', '%' . $keyword . '%');
                    } catch (\Throwable $e) {
                        // ignore
                    }
                    try {
                        $builder->orWhereTranslationLike('title', '%' . $keyword . '%');
                    } catch (\Throwable $e) {
                        // ignore
                    }
                });
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

        $segmentCount = 0;
        $translatedCount = 0;
        // 强制：只要原文带任何 HTML 标签，一律走富文本提取翻译
        $isRichContent = $this->richText->isRich($type, $text) || $isRich;

        try {
            if ($isRichContent) {
                $pack = $this->richText->extract($text);
                $segmentCount = (int) ($pack['count'] ?? count($pack['segments']));
                if ($segmentCount === 0) {
                    // 没抽到文案：退回整段纯文本翻译（去掉标签后翻再不行就保留结构）
                    $plain = trim(html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                    if ($plain !== '') {
                        $result = $this->translator->translate($plain, $target);
                        $segmentCount = 1;
                        $translatedCount = 1;
                    } else {
                        $result = $text;
                    }
                } else {
                    $translated = [];
                    foreach ($pack['segments'] as $i => $segment) {
                        try {
                            // 段与段之间稍作间隔，降低富文本多段连打导致的 429
                            if ($i > 0) {
                                usleep(400000);
                            }
                            $one = $this->translator->translate($segment, $target);
                            $translated[] = $one;
                            if (mb_strtolower(trim($one)) !== mb_strtolower(trim($segment))) {
                                $translatedCount++;
                            }
                        } catch (\Throwable $e) {
                            // Keep original segment so HTML structure still restores correctly
                            $translated[] = $segment;
                        }
                    }
                    $result = $this->richText->restore($pack['template'], $translated);
                }
            } else {
                $result = $this->translator->translate($text, $target);
                $segmentCount = 1;
                $translatedCount = 1;
            }
        } catch (\Throwable $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }

        $sameAsSource = trim($result) !== '' && mb_strtolower(trim($result)) === mb_strtolower(trim($text));
        if ($isRichContent && $segmentCount > 0 && $translatedCount === 0) {
            $sameAsSource = true;
        }

        return $this->data([
            'text' => $result,
            'is_rich' => $isRichContent,
            'target' => $target,
            'same_as_source' => $sameAsSource,
            'segment_count' => $segmentCount,
            'translated_count' => $translatedCount,
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
