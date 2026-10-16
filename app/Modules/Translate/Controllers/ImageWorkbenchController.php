<?php

namespace App\Modules\Translate\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\Locale;
use App\Services\Translate\ImageUrlRewriteService;
use App\Services\Translate\TranslateRegistryService;
use App\Services\Translate\TranslationPersistenceService;
use Illuminate\Http\Request;

class ImageWorkbenchController extends BaseController
{
    protected TranslateRegistryService $registry;
    protected TranslationPersistenceService $persistence;
    protected ImageUrlRewriteService $rewriter;

    public function __construct(
        TranslateRegistryService $registry,
        TranslationPersistenceService $persistence,
        ImageUrlRewriteService $rewriter
    ) {
        $this->registry = $registry;
        $this->persistence = $persistence;
        $this->rewriter = $rewriter;
        $this->viewPath = 'Translate.Views';
    }

    public function index()
    {
        try {
            $modules = $this->registry->modules();
        } catch (\Throwable $e) {
            $modules = [];
        }

        $selectedModule = (string) request()->get('module', '');

        return view($this->viewPath . '.image-workbench', [
            'modules' => $modules,
            'selectedModule' => $selectedModule,
            'defaultDomain' => ImageUrlRewriteService::DEFAULT_DOMAIN,
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
                $query->where(function ($builder) use ($keyword, $table) {
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

    /**
     * 预览：对记录下全部语言翻译字段做域名剥离。
     */
    public function preview(Request $request)
    {
        $module = (string) $request->get('module', '');
        $id = (int) $request->get('id', 0);
        $fields = array_values(array_filter((array) $request->get('fields', [])));
        $domain = trim((string) $request->get('domain', ImageUrlRewriteService::DEFAULT_DOMAIN));
        if ($domain === '') {
            $domain = ImageUrlRewriteService::DEFAULT_DOMAIN;
        }

        $modelClass = $this->registry->modelClass($module);
        if (!$modelClass || $id <= 0 || empty($fields)) {
            return $this->badRequest('Invalid parameters');
        }

        $model = $modelClass::with('translations')->find($id);
        if (!$model) {
            return $this->badRequest('Record not found');
        }

        $host = $this->rewriter->extractHost($domain);
        if ($host === '') {
            return $this->badRequest('Invalid domain');
        }

        $fieldMeta = collect($this->registry->fields($module))->keyBy('name');
        $allowed = $fieldMeta->keys()->all();
        $fields = array_values(array_intersect($fields, $allowed));
        if (empty($fields)) {
            return $this->badRequest('No valid fields');
        }

        $localeLabels = Locale::query()
            ->get(['language', 'language_code'])
            ->mapWithKeys(fn ($row) => [
                (string) $row->language_code => (string) ($row->language ?: $row->language_code),
            ])
            ->all();

        $totalReplacements = 0;
        $localePayload = [];

        $translations = $model->translations;
        if ($translations->isEmpty()) {
            return $this->data([
                'id' => $id,
                'label' => $this->registry->displayNameForRecord($model),
                'domain' => $domain,
                'host' => $host,
                'locales' => [],
                'total_replacements' => 0,
            ]);
        }

        foreach ($translations as $translation) {
            $locale = (string) ($translation->locale ?? '');
            if ($locale === '') {
                continue;
            }
            $fieldsOut = [];
            foreach ($fields as $field) {
                $meta = $fieldMeta->get($field, []);
                $before = $this->encodeValue($translation->{$field} ?? '');
                $pack = $this->rewriter->rewrite($before, $domain);
                $after = $pack['text'];
                $count = (int) $pack['count'];
                $totalReplacements += $count;
                $fieldsOut[$field] = [
                    'label' => $meta['label'] ?? $field,
                    'type' => $meta['type'] ?? 'text',
                    'before' => $before,
                    'after' => $after,
                    'changed' => $before !== $after,
                    'count' => $count,
                    'replacements' => $pack['replacements'],
                ];
            }
            $localePayload[] = [
                'locale' => $locale,
                'label' => $localeLabels[$locale] ?? $locale,
                'fields' => $fieldsOut,
            ];
        }

        usort($localePayload, function ($a, $b) {
            if ($a['locale'] === 'en') {
                return -1;
            }
            if ($b['locale'] === 'en') {
                return 1;
            }

            return strcmp($a['locale'], $b['locale']);
        });

        return $this->data([
            'id' => $id,
            'label' => $this->registry->displayNameForRecord($model),
            'domain' => $domain,
            'host' => $host,
            'locales' => $localePayload,
            'total_replacements' => $totalReplacements,
        ]);
    }

    /**
     * 回写：按语言写回翻译表字段。
     */
    public function save(Request $request)
    {
        $module = (string) $request->get('module', '');
        $id = (int) $request->get('id', 0);
        $locales = (array) $request->get('locales', []);
        $modelClass = $this->registry->modelClass($module);
        if (!$modelClass || $id <= 0 || empty($locales)) {
            return $this->badRequest('Invalid parameters');
        }

        $model = $modelClass::find($id);
        if (!$model) {
            return $this->badRequest('Record not found');
        }

        $fieldMeta = collect($this->registry->fields($module))->keyBy('name');
        $allowed = $fieldMeta->keys()->all();
        $saved = [];

        try {
            foreach ($locales as $locale => $fields) {
                $locale = trim((string) $locale);
                if ($locale === '' || !is_array($fields) || empty($fields)) {
                    continue;
                }
                $filtered = [];
                $fieldTypes = [];
                foreach ($fields as $field => $value) {
                    if (!in_array($field, $allowed, true)) {
                        continue;
                    }
                    // null 必须存为空串，避免 json_encode(null) 把字面量 "null" 写入翻译表
                    if ($value === null) {
                        $filtered[$field] = '';
                    } else {
                        $filtered[$field] = is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE);
                    }
                    $fieldTypes[$field] = (string) ($fieldMeta->get($field)['type'] ?? 'text');
                }
                if (empty($filtered)) {
                    continue;
                }
                $this->persistence->saveLocaleFields($model, $locale, $filtered, $fieldTypes);
                $saved[] = $locale;
            }
            $this->forgetFrontCachesAfterSave();
        } catch (\Throwable $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }

        if (empty($saved)) {
            return $this->badRequest('No valid locale fields');
        }

        return $this->data([
            'id' => $id,
            'locales' => $saved,
        ]);
    }

    protected function encodeValue($value): string
    {
        if (is_array($value)) {
            return (string) json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        if ($value === null) {
            return '';
        }

        return (string) $value;
    }

    protected function forgetFrontCachesAfterSave(): void
    {
        try {
            \Illuminate\Support\Facades\Cache::flush();
        } catch (\Throwable $e) {
            // ignore
        }
        try {
            if (class_exists(\App\Services\FrontPageCatalogService::class)) {
                app(\App\Services\FrontPageCatalogService::class)->forgetPageCaches(['']);
            }
        } catch (\Throwable $e) {
            // ignore
        }
        try {
            \Illuminate\Support\Facades\Artisan::call('view:clear');
        } catch (\Throwable $e) {
            // ignore
        }
    }
}
