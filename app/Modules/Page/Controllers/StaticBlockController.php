<?php

namespace App\Modules\Page\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Page\Models\Page;
use App\Modules\Page\Models\StaticBlock;
use App\Modules\Product\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class StaticBlockController extends BaseController
{
    public function __construct(StaticBlock $staticBlock)
    {
        $this->modelName = 'StaticBlock';
        $this->model = $staticBlock;
        $this->viewPath = 'Page.Views.staticBlock';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $request = request();
        $title = (string)$request->get('title', '');
        $sign = trim((string)$request->get('sign', ''));
        $active = $request->get('active');
        $pageId = (int)$request->get('page_id', 0);
        $pageKey = trim((string)$request->get('page_key', ''));

        $with = ['translations', 'pages:id,url_key'];
        if (Schema::hasTable('static_block_page_keys')) {
            $with[] = 'pageKeys';
        }
        $query = StaticBlock::query()->with($with);

        if ($title !== '') {
            $query->whereTranslationLike('title', '%' . $title . '%');
        }
        if ($sign !== '') {
            $query->where('sign', 'like', '%' . $sign . '%');
        }
        if ($active !== null && $active !== '') {
            $query->where('active', (int)$active);
        }
        if ($pageId > 0) {
            $query->whereHas('pages', function ($q) use ($pageId) {
                $q->where('pages.id', $pageId);
            });
        }
        if ($pageKey !== '' && Schema::hasTable('static_block_page_keys')) {
            $query->whereHas('pageKeys', function ($q) use ($pageKey) {
                $q->where('page_key', $pageKey);
            });
        }

        $items = $query
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        $virtualPages = $this->virtualPageOptions();
        $categoryPages = $this->categoryPageOptions();
        $allPages = $this->realPageOptions();
        $assocOptions = $this->associationOptions($allPages, $virtualPages, $categoryPages);

        return view($this->viewPath . '.index', compact(
            'items',
            'title',
            'sign',
            'active',
            'pageId',
            'pageKey',
            'allPages',
            'virtualPages',
            'categoryPages',
            'assocOptions'
        ));
    }

    public function create()
    {
        $virtualPages = $this->virtualPageOptions();
        $categoryPages = $this->categoryPageOptions();
        $allPages = $this->realPageOptions();
        $selectedPageIds = old('page_ids', []);
        $selectedPageKeys = old('page_keys', []);
        return view($this->viewPath . '.create', compact(
            'allPages',
            'virtualPages',
            'categoryPages',
            'selectedPageIds',
            'selectedPageKeys'
        ));
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'sign' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z0-9_\-]+$/', 'unique:static_blocks,sign'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
            'remark' => ['nullable', 'string', 'max:255'],
            'page_ids' => ['nullable', 'array'],
            'page_ids.*' => ['integer'],
            'page_keys' => ['nullable', 'array'],
            'page_keys.*' => ['string', 'max:100'],
            'translate' => ['array'],
            'translate.*.title' => ['nullable', 'string', 'max:255'],
            'translate.*.content' => ['nullable', 'string'],
        ], [
            'sign.regex' => __('标识仅允许字母、数字、下划线和中划线'),
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $payload = [
            'sign' => trim((string)$request->get('sign')),
            'sort' => (int)$request->get('sort', 0),
            'active' => (int)$request->get('active', 1),
            'remark' => trim((string)$request->get('remark', '')) ?: null,
        ];

        $translate = (array)$request->get('translate', []);
        $model = StaticBlock::create(array_merge($payload, $translate));
        $this->syncPages($model, $request->get('page_ids', []));
        $this->syncPageKeys($model, $request->get('page_keys', []));

        return redirect()->route('admin.staticBlock.index')->with('success', __('保存成功'));
    }

    public function edit($id)
    {
        $with = ['translations', 'pages'];
        if (Schema::hasTable('static_block_page_keys')) {
            $with[] = 'pageKeys';
        }
        $model = StaticBlock::query()->with($with)->findOrFail($id);
        $virtualPages = $this->virtualPageOptions();
        $categoryPages = $this->categoryPageOptions();
        $allPages = $this->realPageOptions();
        $selectedPageIds = old('page_ids', $model->pages->pluck('id')->all());
        $selectedPageKeys = old(
            'page_keys',
            Schema::hasTable('static_block_page_keys')
                ? $model->pageKeys->pluck('page_key')->all()
                : []
        );

        return view($this->viewPath . '.edit', compact(
            'model',
            'allPages',
            'virtualPages',
            'categoryPages',
            'selectedPageIds',
            'selectedPageKeys'
        ));
    }

    public function update($id, Request $request)
    {
        $model = StaticBlock::query()->findOrFail($id);

        $validator = $this->getValidationFactory()->make($request->all(), [
            'sign' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9_\-]+$/',
                Rule::unique('static_blocks', 'sign')->ignore($model->id),
            ],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
            'remark' => ['nullable', 'string', 'max:255'],
            'page_ids' => ['nullable', 'array'],
            'page_ids.*' => ['integer'],
            'page_keys' => ['nullable', 'array'],
            'page_keys.*' => ['string', 'max:100'],
            'translate' => ['array'],
            'translate.*.title' => ['nullable', 'string', 'max:255'],
            'translate.*.content' => ['nullable', 'string'],
        ], [
            'sign.regex' => __('标识仅允许字母、数字、下划线和中划线'),
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $payload = [
            'sign' => trim((string)$request->get('sign')),
            'sort' => (int)$request->get('sort', 0),
            'active' => (int)$request->get('active', 1),
            'remark' => trim((string)$request->get('remark', '')) ?: null,
        ];

        $translate = (array)$request->get('translate', []);
        $model->update(array_merge($payload, $translate));
        $this->syncPages($model, $request->get('page_ids', []));
        $this->syncPageKeys($model, $request->get('page_keys', []));

        return redirect()->route('admin.staticBlock.index')->with('success', __('保存成功'));
    }

    public function destroy($id)
    {
        $model = StaticBlock::query()->findOrFail($id);
        $model->pages()->detach();
        if (Schema::hasTable('static_block_page_keys')) {
            $model->pageKeys()->delete();
        }
        $model->delete();

        return redirect()->route('admin.staticBlock.index')->with('success', __('删除成功'));
    }

    protected function syncPages(StaticBlock $model, $pageIds): void
    {
        if (!is_array($pageIds)) {
            $pageIds = [];
        }
        $pageIds = array_values(array_unique(array_filter(array_map('intval', $pageIds), function ($id) {
            return $id > 0;
        })));
        $model->pages()->sync($pageIds);
    }

    protected function syncPageKeys(StaticBlock $model, $pageKeys): void
    {
        if (!Schema::hasTable('static_block_page_keys')) {
            return;
        }
        if (!is_array($pageKeys)) {
            $pageKeys = [];
        }

        $allowed = array_keys((array)config('static_block_pages', []));
        foreach ($this->categoryPageOptions() as $category) {
            $allowed[] = $category['key'];
        }
        $allowed = array_values(array_unique($allowed));

        $keys = [];
        foreach ($pageKeys as $key) {
            $key = trim((string)$key, '/');
            if ($key === '' || !in_array($key, $allowed, true)) {
                continue;
            }
            $keys[$key] = $key;
        }
        $keys = array_values($keys);

        $model->pageKeys()->delete();
        foreach ($keys as $key) {
            $model->pageKeys()->create(['page_key' => $key]);
        }
    }

    /**
     * Real CMS pages shown in association checkboxes.
     */
    protected function realPageOptions()
    {
        return Page::query()
            ->where('is_temp', 0)
            ->with('translations')
            ->orderByDesc('active')
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get();
    }

    /**
     * Virtual pages that are not already present as real page url_key rows.
     *
     * @return array<int, array{key:string,name:string}>
     */
    protected function virtualPageOptions(): array
    {
        $defined = (array)config('static_block_pages', []);
        if ($defined === []) {
            return [];
        }

        $existingKeys = Page::query()
            ->where('is_temp', 0)
            ->pluck('url_key')
            ->map(function ($key) {
                return trim((string)$key, '/');
            })
            ->filter()
            ->unique()
            ->all();

        $options = [];
        foreach ($defined as $key => $name) {
            $key = trim((string)$key, '/');
            if ($key === '' || in_array($key, $existingKeys, true)) {
                continue;
            }
            $options[] = [
                'key' => $key,
                'name' => (string)$name,
            ];
        }

        return $options;
    }

    /**
     * First-level product categories as association options.
     * Key format: pcat:{id} — matches this category and its children on front.
     *
     * @return array<int, array{key:string,name:string}>
     */
    protected function categoryPageOptions(): array
    {
        try {
            $categories = ProductCategory::query()
                ->with('translations')
                ->where(function ($q) {
                    $q->whereNull('parent_id')->orWhere('parent_id', 0);
                })
                ->orderByDesc('sort')
                ->orderBy('id')
                ->get();
        } catch (\Throwable $e) {
            return [];
        }

        $options = [];
        foreach ($categories as $category) {
            $id = (int)$category->id;
            if ($id <= 0) {
                continue;
            }
            $name = trim((string)($category->name ?: $category->url_key ?: ('Category #' . $id)));
            $options[] = [
                'key' => 'pcat:' . $id,
                'name' => $name,
            ];
        }

        return $options;
    }

    /**
     * @param mixed $allPages
     * @param array<int, array{key:string,name:string}> $virtualPages
     * @param array<int, array{key:string,name:string}> $categoryPages
     * @return array<int, array{type:string,value:string,label:string}>
     */
    protected function associationOptions($allPages, array $virtualPages, array $categoryPages = []): array
    {
        $options = [];
        foreach ($allPages as $page) {
            $options[] = [
                'type' => 'page',
                'value' => (string)$page->id,
                'label' => trim((string)(($page->name ?: $page->url_key) . ' (' . $page->url_key . ')')),
            ];
        }
        foreach ($virtualPages as $virtual) {
            $options[] = [
                'type' => 'key',
                'value' => (string)$virtual['key'],
                'label' => trim((string)($virtual['name'] . ' (' . $virtual['key'] . ') [虚拟]')),
            ];
        }
        foreach ($categoryPages as $category) {
            $options[] = [
                'type' => 'key',
                'value' => (string)$category['key'],
                'label' => trim((string)($category['name'] . ' [产品分类]')),
            ];
        }
        return $options;
    }
}
