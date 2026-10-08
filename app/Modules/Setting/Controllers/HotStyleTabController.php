<?php

namespace App\Modules\Setting\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Setting\Models\HotStyleTab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class HotStyleTabController extends BaseController
{
    public function __construct(HotStyleTab $hotStyleTab)
    {
        $this->modelName = 'HotStyleTab';
        $this->model = $hotStyleTab;
        $this->viewPath = 'Setting.Views.hotStyleTab';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $request = request();
        $label = (string)$request->get('label', '');
        $active = $request->get('active');

        $query = HotStyleTab::query()->with(['translations', 'category.translations'])->withCount('products');

        if ($label !== '') {
            $query->whereTranslationLike('label', '%' . $label . '%');
        }
        if ($active !== null && $active !== '') {
            $query->where('active', (int)$active);
        }

        $items = $query
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        $productSources = HotStyleTab::PRODUCT_SOURCES;
        $sourceTypes = HotStyleTab::SOURCE_TYPES;

        return view($this->viewPath . '.index', compact('items', 'label', 'active', 'productSources', 'sourceTypes'));
    }

    public function create()
    {
        $productSources = HotStyleTab::PRODUCT_SOURCES;
        $sourceTypes = HotStyleTab::SOURCE_TYPES;
        $categories = $this->categoryOptions();
        $selectedProductIds = old('product_ids', []);
        if (!is_array($selectedProductIds)) {
            $selectedProductIds = [];
        }
        $categoryProducts = collect();
        $oldCategoryId = (int)old('product_category_id', 0);
        if ($oldCategoryId > 0) {
            $categoryProducts = $this->productsOfCategory($oldCategoryId);
        }

        return view($this->viewPath . '.create', compact(
            'productSources', 'sourceTypes', 'categories', 'selectedProductIds', 'categoryProducts'
        ));
    }

    public function store(Request $request)
    {
        $payload = $this->validatedPayload($request);
        if ($payload instanceof \Illuminate\Http\RedirectResponse) {
            return $payload;
        }

        $translate = (array)$request->get('translate', []);
        $productIds = $this->normalizeProductIds($request);

        DB::beginTransaction();
        try {
            $model = HotStyleTab::create(array_merge($payload, $translate));
            $this->syncProducts($model, $productIds);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route('admin.hotStyleTab.index')->with('success', 'Created');
    }

    public function edit($id)
    {
        $model = HotStyleTab::query()->with(['translations', 'products'])->findOrFail($id);
        $productSources = HotStyleTab::PRODUCT_SOURCES;
        $sourceTypes = HotStyleTab::SOURCE_TYPES;
        $categories = $this->categoryOptions();
        $selectedProductIds = old('product_ids', $model->products->pluck('id')->all());
        if (!is_array($selectedProductIds)) {
            $selectedProductIds = [];
        }
        $categoryId = (int)old('product_category_id', $model->product_category_id);
        $categoryProducts = $categoryId > 0 ? $this->productsOfCategory($categoryId) : collect();

        return view($this->viewPath . '.edit', compact(
            'model', 'productSources', 'sourceTypes', 'categories', 'selectedProductIds', 'categoryProducts'
        ));
    }

    public function update($id, Request $request)
    {
        $model = HotStyleTab::query()->findOrFail($id);
        $payload = $this->validatedPayload($request, $id);
        if ($payload instanceof \Illuminate\Http\RedirectResponse) {
            return $payload;
        }

        $translate = (array)$request->get('translate', []);
        $productIds = $this->normalizeProductIds($request);

        DB::beginTransaction();
        try {
            $model->update(array_merge($payload, $translate));
            $this->syncProducts($model, $productIds);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route('admin.hotStyleTab.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        $model = HotStyleTab::query()->findOrFail($id);
        $model->products()->detach();
        $model->delete();
        return redirect()->route('admin.hotStyleTab.index')->with('success', 'Deleted');
    }

    /**
     * AJAX: products under a category (includes children categories).
     */
    public function productsByCategory(Request $request)
    {
        $categoryId = (int)$request->get('category_id', 0);
        $selected = $request->get('selected', []);
        if (!is_array($selected)) {
            $selected = array_filter(explode(',', (string)$selected));
        }
        $selected = array_map('intval', $selected);

        $products = $categoryId > 0 ? $this->productsOfCategory($categoryId) : collect();

        return response()->json([
            'code' => 0,
            'data' => $products->map(function ($p) use ($selected) {
                return [
                    'id' => $p->id,
                    'name' => (string)($p->name ?? ('#' . $p->id)),
                    'checked' => in_array((int)$p->id, $selected, true),
                ];
            })->values(),
        ]);
    }

    protected function validatedPayload(Request $request, $ignoreId = null)
    {
        $sourceType = (string)$request->get('source_type', 'flag');
        $rules = [
            'tab_key' => [
                'required',
                'string',
                'max:64',
                'regex:/^[a-z0-9_\-]+$/i',
                Rule::unique('hot_style_tabs', 'tab_key')->ignore($ignoreId),
            ],
            'source_type' => ['required', 'string', Rule::in(array_keys(HotStyleTab::SOURCE_TYPES))],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
            'translate' => ['array'],
            'translate.*.label' => ['nullable', 'string', 'max:255'],
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['integer'],
        ];

        if ($sourceType === 'category') {
            $rules['product_category_id'] = ['required', 'integer', Rule::exists('product_categories', 'id')];
            $rules['product_source'] = ['nullable', 'string'];
            $rules['product_ids'] = ['required', 'array', 'min:1'];
        } else {
            $rules['product_source'] = ['required', 'string', Rule::in(array_keys(HotStyleTab::PRODUCT_SOURCES))];
            $rules['product_category_id'] = ['nullable'];
        }

        $validator = $this->getValidationFactory()->make($request->all(), $rules, [
            'product_ids.required' => __('请至少选择一个产品'),
            'product_category_id.required' => __('请选择产品分类'),
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $payload = [
            'tab_key' => strtolower(trim((string)$request->get('tab_key'))),
            'source_type' => $sourceType,
            'sort' => (int)$request->get('sort', 0),
            'active' => (int)$request->get('active', 1),
        ];

        if ($sourceType === 'category') {
            $payload['product_category_id'] = (int)$request->get('product_category_id');
            $payload['product_source'] = null;
        } else {
            $payload['product_source'] = (string)$request->get('product_source');
            $payload['product_category_id'] = null;
        }

        return $payload;
    }

    protected function normalizeProductIds(Request $request): array
    {
        if ((string)$request->get('source_type', 'flag') !== 'category') {
            return [];
        }
        $ids = $request->get('product_ids', []);
        if (!is_array($ids)) {
            $ids = [];
        }
        return array_values(array_unique(array_filter(array_map('intval', $ids))));
    }

    protected function syncProducts(HotStyleTab $model, array $productIds): void
    {
        if (!$model->isCategoryMode()) {
            $model->products()->detach();
            return;
        }

        $sync = [];
        $sort = count($productIds) * 10;
        foreach ($productIds as $pid) {
            $sync[$pid] = ['sort' => $sort];
            $sort -= 10;
        }
        $model->products()->sync($sync);
    }

    protected function categoryOptions()
    {
        return ProductCategory::query()
            ->with(['translations'])
            ->orderBy('parent_id')
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get();
    }

    protected function productsOfCategory(int $categoryId)
    {
        $productIds = [];
        $this->collectCategoryProductIds($categoryId, $productIds);
        $productIds = array_values(array_unique(array_filter(array_map('intval', $productIds))));
        if (empty($productIds)) {
            return collect();
        }

        return Product::query()
            ->with(['translations'])
            ->active()
            ->whereIn('id', $productIds)
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->limit(500)
            ->get();
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
