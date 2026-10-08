<?php

namespace App\Modules\Product\Controllers;

use App\Modules\Admin\Models\AdminLog;
use App\Modules\Common\Collections\CommonCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductFaq;
use App\Modules\User\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductFaqController extends BaseController
{
    public function __construct(ProductFaq $model)
    {
        $this->modelName = 'ProductFaq';
        $this->model = $model;
        $this->viewPath = 'Product.Views.productFaq';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $request = request();
        $subject = trim((string)$request->get('subject', ''));
        $query = ProductFaq::query()->with(['translations', 'products.translations', 'categories.translations']);

        if ($subject !== '') {
            $query->whereTranslationLike('subject', '%' . $subject . '%');
        }

        $faqs = $query
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        $categoryTree = $this->buildCategoryCheckboxTree();
        $flatCategories = $this->flattenCategoryOptions($categoryTree);

        return view($this->viewPath . '.index', compact('faqs', 'subject', 'categoryTree', 'flatCategories'));
    }

    public function create()
    {
        $selectedProductIds = array_map('intval', (array)old('product_ids', []));
        $selectedCategoryIds = array_map('intval', (array)old('category_ids', []));
        $selectedProducts = $this->loadProductsByIds($selectedProductIds);
        $selectedCategories = $this->loadCategoriesByIds($selectedCategoryIds);
        $categoryTree = $this->buildCategoryCheckboxTree();
        $flatCategories = $this->flattenCategoryOptions($categoryTree);

        return view($this->viewPath . '.create', compact(
            'selectedProductIds',
            'selectedCategoryIds',
            'selectedProducts',
            'selectedCategories',
            'categoryTree',
            'flatCategories'
        ));
    }

    public function store(Request $request)
    {
        $locale = $this->defaultLocale();
        $validator = $this->getValidationFactory()->make($request->all(), [
            'sort' => ['nullable', 'integer'],
            'active' => ['nullable'],
            'translate.' . $locale . '.subject' => ['required', 'string', 'max:255'],
            'translate.' . $locale . '.content' => ['required', 'string'],
            'translate' => ['array'],
            'translate.*.subject' => ['nullable', 'string', 'max:255'],
            'translate.*.content' => ['nullable', 'string'],
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['integer'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['integer'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $translate = (array)$request->get('translate', []);
                $model = ProductFaq::create(array_merge($translate, [
                    'sort' => (int)$request->get('sort', 0),
                    'active' => $request->has('active') ? 1 : 0,
                ]));

                $this->syncRelationDiff($model->products(), $this->normalizeIds($request->get('product_ids', [])));
                $this->syncRelationDiff($model->categories(), $this->normalizeIds($request->get('category_ids', [])));

                AdminLog::log([
                    'name' => date('Y-m-d H:i:s') . ' 用户' . ($request->user()->email ?? '') . '新增产品问答(' . $model->id . ')',
                    'modelName' => $this->modelName,
                    'content' => json_encode($request->all()),
                ]);
            });
        } catch (\Throwable $e) {
            Log::error($this->modelName . ':store ' . $e->getMessage());
            return back()->withErrors(['error' => '保存失败'])->withInput();
        }

        return redirect()->route('admin.productFaq.index')->with('success', __('创建成功'));
    }

    public function edit($id)
    {
        $model = ProductFaq::query()
            ->with(['translations', 'products.translations', 'categories.translations'])
            ->findOrFail($id);

        $selectedProductIds = array_map('intval', (array)old('product_ids', $model->products->pluck('id')->all()));
        $selectedCategoryIds = array_map('intval', (array)old('category_ids', $model->categories->pluck('id')->all()));
        $selectedProducts = $this->loadProductsByIds($selectedProductIds);
        $selectedCategories = $this->loadCategoriesByIds($selectedCategoryIds);
        $categoryTree = $this->buildCategoryCheckboxTree();
        $flatCategories = $this->flattenCategoryOptions($categoryTree);

        return view($this->viewPath . '.edit', compact(
            'model',
            'selectedProductIds',
            'selectedCategoryIds',
            'selectedProducts',
            'selectedCategories',
            'categoryTree',
            'flatCategories'
        ));
    }

    public function update($id, Request $request)
    {
        $locale = $this->defaultLocale();
        $validator = $this->getValidationFactory()->make($request->all(), [
            'sort' => ['nullable', 'integer'],
            'active' => ['nullable'],
            'translate.' . $locale . '.subject' => ['required', 'string', 'max:255'],
            'translate.' . $locale . '.content' => ['required', 'string'],
            'translate' => ['array'],
            'translate.*.subject' => ['nullable', 'string', 'max:255'],
            'translate.*.content' => ['nullable', 'string'],
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['integer'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['integer'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = ProductFaq::query()->findOrFail($id);

        try {
            DB::transaction(function () use ($request, $model) {
                $translate = (array)$request->get('translate', []);
                $model->fill(array_merge($translate, [
                    'sort' => (int)$request->get('sort', 0),
                    'active' => $request->has('active') ? 1 : 0,
                ]));
                $model->save();

                $this->syncRelationDiff($model->products(), $this->normalizeIds($request->get('product_ids', [])));
                $this->syncRelationDiff($model->categories(), $this->normalizeIds($request->get('category_ids', [])));

                AdminLog::log([
                    'name' => date('Y-m-d H:i:s') . ' 用户' . ($request->user()->email ?? '') . '编辑产品问答(' . $model->id . ')',
                    'modelName' => $this->modelName,
                    'content' => json_encode($request->all()),
                ]);
            });
        } catch (\Throwable $e) {
            Log::error($this->modelName . ':update ' . $e->getMessage());
            return back()->withErrors(['error' => '保存失败'])->withInput();
        }

        return redirect()->route('admin.productFaq.index')->with('success', __('更新成功'));
    }

    public function updateSort(Request $request, $id)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'sort' => ['required', 'integer', 'min:0'],
        ]);
        if (!$validator->passes()) {
            return response()->json(['code' => 1, 'msg' => $validator->errors()->first()]);
        }

        $model = ProductFaq::query()->findOrFail($id);
        $model->sort = (int)$request->input('sort', 0);
        $model->save();

        return response()->json(['code' => 0, 'msg' => __('排序已更新'), 'data' => ['sort' => (int)$model->sort]]);
    }

    public function destroy($id)
    {
        $model = ProductFaq::query()->findOrFail($id);
        try {
            DB::transaction(function () use ($model) {
                $model->products()->detach();
                $model->categories()->detach();
                $model->delete();
            });
        } catch (\Throwable $e) {
            Log::error($this->modelName . ':destroy ' . $e->getMessage());
            return back()->with('error', __('删除失败'));
        }

        return redirect()->route('admin.productFaq.index')->with('success', __('删除成功'));
    }

    public function batchDestroy(Request $request)
    {
        $ids = collect((array)$request->input('ids', []))
            ->map(fn ($v) => (int)$v)
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->all();

        if ($ids === []) {
            return response()->json(['code' => 1, 'msg' => __('请先选择要删除的数据')]);
        }

        try {
            DB::transaction(function () use ($ids) {
                $models = ProductFaq::query()->whereIn('id', $ids)->get();
                foreach ($models as $model) {
                    $model->products()->detach();
                    $model->categories()->detach();
                    $model->delete();
                }
            });
        } catch (\Throwable $e) {
            Log::error($this->modelName . ':batchDestroy ' . $e->getMessage());
            return response()->json(['code' => 1, 'msg' => __('批量删除失败')]);
        }

        return response()->json(['code' => 0, 'msg' => __('批量删除成功'), 'data' => ['count' => count($ids)]]);
    }

    /**
     * 同步 Faqs 管理数据到产品问答（已同步过的按 source_faq_id 更新文案，不重复插入）。
     */
    public function syncFromFaqs(Request $request)
    {
        $locale = $this->defaultLocale();
        $locales = (array)config('translatable.locales', [$locale]);
        $created = 0;
        $updated = 0;

        try {
            DB::transaction(function () use ($locales, &$created, &$updated) {
                $faqs = Faq::query()->with(['translations'])->orderBy('id')->get();
                foreach ($faqs as $faq) {
                    $payload = [
                        'sort' => (int)($faq->sort ?? 0),
                        'active' => 1,
                        'source_faq_id' => $faq->id,
                    ];
                    foreach ($locales as $loc) {
                        $tr = $faq->translate($loc, false);
                        $payload[$loc] = [
                            'subject' => $tr ? (string)($tr->subject ?? '') : '',
                            'content' => $tr ? (string)($tr->content ?? '') : '',
                        ];
                    }

                    $existing = ProductFaq::query()->where('source_faq_id', $faq->id)->first();
                    if ($existing) {
                        $existing->fill($payload);
                        $existing->save();
                        $updated++;
                    } else {
                        ProductFaq::create($payload);
                        $created++;
                    }
                }
            });
        } catch (\Throwable $e) {
            Log::error($this->modelName . ':syncFromFaqs ' . $e->getMessage());
            return back()->with('error', __('同步失败：') . $e->getMessage());
        }

        return back()->with('success', __('同步完成：新增 :c 条，更新 :u 条', ['c' => $created, 'u' => $updated]));
    }

    public function export(Request $request)
    {
        $ids = $request->post('ids');
        $locale = (string)($request->post('locale') ?: $this->defaultLocale());

        $data = [[
            'id',
            'subject',
            'content',
            'sort',
            'active',
            'product_ids',
            'category_ids',
        ]];

        $query = ProductFaq::query()->with(['translations', 'products', 'categories']);
        if (is_array($ids) && count($ids)) {
            $query->whereIn('id', array_map('intval', $ids));
        }
        $rows = $query->orderByDesc('sort')->orderByDesc('id')->get();

        foreach ($rows as $row) {
            $tr = $row->translate($locale, false) ?: $row->translate($this->defaultLocale(), false);
            $data[] = [
                $row->id,
                $tr ? (string)($tr->subject ?? '') : (string)$row->subject,
                $tr ? strip_tags((string)($tr->content ?? '')) : strip_tags((string)$row->content),
                (int)$row->sort,
                (int)$row->active,
                $row->products->pluck('id')->implode(','),
                $row->categories->pluck('id')->implode(','),
            ];
        }

        return new CommonCollection($data);
    }

    /**
     * 导入：按 id 更新；无 id 或找不到则新增。列：id, subject, content, sort, active, product_ids, category_ids
     */
    public function import(Request $request)
    {
        $locale = $this->defaultLocale();
        $rows = $request->post('rows');
        if (!is_array($rows) || empty($rows)) {
            return response()->json(['code' => 1, 'msg' => __('没有可导入的数据')], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $created = 0;
        $updated = 0;

        try {
            DB::transaction(function () use ($rows, $locale, &$created, &$updated) {
                foreach ($rows as $row) {
                    if (!is_array($row)) {
                        continue;
                    }
                    // skip header-like rows
                    $idRaw = $row['id'] ?? ($row[0] ?? null);
                    $subject = trim((string)($row['subject'] ?? ($row[1] ?? '')));
                    if ($subject === '' || strtolower($subject) === 'subject') {
                        continue;
                    }
                    $content = (string)($row['content'] ?? ($row[2] ?? ''));
                    $sort = (int)($row['sort'] ?? ($row[3] ?? 0));
                    $active = (int)($row['active'] ?? ($row[4] ?? 1));
                    $productIds = $this->parseIdList($row['product_ids'] ?? ($row[5] ?? ''));
                    $categoryIds = $this->parseIdList($row['category_ids'] ?? ($row[6] ?? ''));

                    $payload = [
                        'sort' => $sort,
                        'active' => $active ? 1 : 0,
                        $locale => [
                            'subject' => $subject,
                            'content' => $content,
                        ],
                    ];

                    $id = (int)$idRaw;
                    $model = $id > 0 ? ProductFaq::query()->find($id) : null;
                    if ($model) {
                        $model->fill($payload);
                        $model->save();
                        $updated++;
                    } else {
                        $model = ProductFaq::create($payload);
                        $created++;
                    }

                    $this->syncRelationDiff($model->products(), $productIds);
                    $this->syncRelationDiff($model->categories(), $categoryIds);
                }
            });
        } catch (\Throwable $e) {
            Log::error($this->modelName . ':import ' . $e->getMessage());
            return response()->json(['code' => 1, 'msg' => __('导入失败')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'code' => 0,
            'msg' => __('导入完成：新增 :c 条，更新 :u 条', ['c' => $created, 'u' => $updated]),
        ]);
    }

    /** AJAX：列表页弹框保存分类/产品关联（diff 增删更新） */
    public function syncRelations($id, Request $request)
    {
        $model = ProductFaq::query()->with(['products.translations', 'categories.translations'])->findOrFail($id);
        $type = (string)$request->get('type', '');

        try {
            DB::transaction(function () use ($request, $model, $type) {
                if ($type === 'categories' || $type === 'all') {
                    $this->syncRelationDiff(
                        $model->categories(),
                        $this->normalizeIds($request->get('category_ids', []))
                    );
                }
                if ($type === 'products' || $type === 'all') {
                    $this->syncRelationDiff(
                        $model->products(),
                        $this->normalizeIds($request->get('product_ids', []))
                    );
                }
            });

            $model->load(['products.translations', 'categories.translations']);
        } catch (\Throwable $e) {
            Log::error($this->modelName . ':syncRelations ' . $e->getMessage());
            return response()->json(['code' => 1, 'msg' => __('保存关联失败')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'code' => 0,
            'msg' => __('关联已保存'),
            'data' => [
                'id' => $model->id,
                'category_ids' => $model->categories->pluck('id')->map(fn ($v) => (int)$v)->values()->all(),
                'categories' => $model->categories->map(fn ($c) => [
                    'id' => (int)$c->id,
                    'name' => (string)$c->name,
                ])->values()->all(),
                'product_ids' => $model->products->pluck('id')->map(fn ($v) => (int)$v)->values()->all(),
                'products' => $model->products->map(fn ($p) => [
                    'id' => (int)$p->id,
                    'name' => (string)$p->name,
                ])->values()->all(),
            ],
        ]);
    }

    /** AJAX：产品搜索（弹框多选） */
    public function searchProducts(Request $request)
    {
        $keyword = trim((string)$request->get('keyword', ''));
        $categoryId = (int)$request->get('category_id', 0);
        $selected = $this->normalizeIds($request->get('selected_ids', []));

        $query = Product::query()
            ->with(['translations'])
            ->active()
            ->where('is_temp', 0);

        if ($categoryId > 0) {
            $productIds = [];
            $this->collectCategoryProductIds($categoryId, $productIds);
            $productIds = array_values(array_unique(array_filter(array_map('intval', $productIds))));
            if (empty($productIds)) {
                return response()->json(['code' => 0, 'data' => []]);
            }
            $query->whereIn('id', $productIds);
        }

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('id', (int)$keyword)
                    ->orWhereTranslationLike('name', '%' . $keyword . '%');
            });
        }

        $products = $query->orderByDesc('sort')->orderByDesc('id')->limit(200)->get();

        $data = $products->map(function ($p) use ($selected) {
            return [
                'id' => $p->id,
                'name' => (string)$p->name,
                'checked' => in_array((int)$p->id, $selected, true),
            ];
        })->values();

        return response()->json(['code' => 0, 'data' => $data]);
    }

    /** AJAX：分类树（弹框多选，已关联默认选中） */
    public function categoryTree(Request $request)
    {
        $selected = $this->normalizeIds($request->get('selected_ids', []));
        $tree = $this->buildCategoryCheckboxTree();

        return response()->json([
            'code' => 0,
            'data' => [
                'tree' => $tree,
                'selected_ids' => $selected,
            ],
        ]);
    }

    /**
     * 对比数据库已有关联与提交 ID：删除差集、新增差集、更新保留项 pivot sort。
     */
    protected function syncRelationDiff($relation, array $newIds): void
    {
        $newIds = $this->normalizeIds($newIds);
        $existing = array_values(array_unique(array_map(
            'intval',
            $relation->allRelatedIds()->all()
        )));

        $toDetach = array_values(array_diff($existing, $newIds));
        $toAttach = array_values(array_diff($newIds, $existing));
        $toKeep = array_values(array_intersect($existing, $newIds));

        if (!empty($toDetach)) {
            $relation->detach($toDetach);
        }

        $sortMap = [];
        $sort = max(count($newIds), 1) * 10;
        foreach ($newIds as $id) {
            $sortMap[$id] = ['sort' => $sort];
            $sort -= 10;
        }

        if (!empty($toAttach)) {
            $attach = [];
            foreach ($toAttach as $id) {
                $attach[$id] = $sortMap[$id] ?? ['sort' => 0];
            }
            $relation->attach($attach);
        }

        if (!empty($toKeep)) {
            $update = [];
            foreach ($toKeep as $id) {
                $update[$id] = $sortMap[$id] ?? ['sort' => 0];
            }
            $relation->syncWithoutDetaching($update);
        }
    }

    protected function normalizeIds($ids): array
    {
        if (!is_array($ids)) {
            if (is_string($ids) && $ids !== '') {
                $ids = preg_split('/\s*,\s*/', $ids) ?: [];
            } else {
                $ids = [];
            }
        }

        return array_values(array_unique(array_filter(array_map('intval', $ids), static fn ($id) => $id > 0)));
    }

    protected function parseIdList($value): array
    {
        if (is_array($value)) {
            return $this->normalizeIds($value);
        }
        return $this->normalizeIds((string)$value);
    }

    protected function defaultLocale(): string
    {
        $locale = (string)config('app.locale');
        return $locale !== '' ? $locale : 'en';
    }

    protected function loadProductsByIds(array $ids)
    {
        $ids = $this->normalizeIds($ids);
        if (empty($ids)) {
            return collect();
        }
        return Product::query()->with(['translations'])->whereIn('id', $ids)->get()->sortBy(function ($p) use ($ids) {
            return array_search((int)$p->id, $ids, true);
        })->values();
    }

    protected function loadCategoriesByIds(array $ids)
    {
        $ids = $this->normalizeIds($ids);
        if (empty($ids)) {
            return collect();
        }
        return ProductCategory::query()->with(['translations'])->whereIn('id', $ids)->get()->sortBy(function ($c) use ($ids) {
            return array_search((int)$c->id, $ids, true);
        })->values();
    }

    protected function buildCategoryCheckboxTree(): array
    {
        $all = ProductCategory::query()
            ->with(['translations'])
            ->orderBy('parent_id')
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get();

        $byParent = [];
        foreach ($all as $cat) {
            $byParent[(int)$cat->parent_id][] = $cat;
        }

        $walk = function (int $parentId, int $depth) use (&$walk, &$byParent): array {
            $nodes = [];
            foreach ($byParent[$parentId] ?? [] as $cat) {
                $nodes[] = [
                    'id' => (int)$cat->id,
                    'name' => (string)$cat->name,
                    'depth' => $depth,
                    'children' => $walk((int)$cat->id, $depth + 1),
                ];
            }
            return $nodes;
        };

        return $walk(0, 0);
    }

    protected function flattenCategoryOptions(array $tree, string $prefix = ''): array
    {
        $out = [];
        foreach ($tree as $node) {
            $label = $prefix . ($node['name'] ?? '');
            $out[] = [
                'id' => (int)$node['id'],
                'label' => $label,
            ];
            if (!empty($node['children'])) {
                $out = array_merge($out, $this->flattenCategoryOptions($node['children'], $prefix . '-- '));
            }
        }
        return $out;
    }

    protected function collectCategoryProductIds(int $categoryId, array &$productIds): void
    {
        $direct = DB::table('product_product_category')
            ->where('product_category_id', $categoryId)
            ->pluck('product_id')
            ->all();
        $productIds = array_merge($productIds, $direct);

        $children = DB::table('product_categories')
            ->where('parent_id', $categoryId)
            ->pluck('id')
            ->all();
        foreach ($children as $childId) {
            $this->collectCategoryProductIds((int)$childId, $productIds);
        }
    }
}
