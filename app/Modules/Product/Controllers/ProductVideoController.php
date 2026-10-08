<?php

namespace App\Modules\Product\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductVideo;
use App\Modules\Product\Models\ProductVideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductVideoController extends BaseController
{
    public function __construct(ProductVideo $productVideo)
    {
        $this->modelName = 'ProductVideo';
        $this->model = $productVideo;
        $this->viewPath = 'Product.Views.productVideo';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $request = request();
        $name = (string)$request->get('name', '');
        $active = $request->get('active');
        $isRecommend = $request->get('is_recommend');
        $categoryId = $request->get('product_video_category_id');

        $query = ProductVideo::query()->with(['translations', 'category.translations']);

        if ($name !== '') {
            $query->whereTranslationLike('name', '%' . $name . '%');
        }
        if ($active !== null && $active !== '') {
            $query->where('active', (int)$active);
        }
        if ($isRecommend !== null && $isRecommend !== '') {
            $query->where('is_recommend', (int)$isRecommend);
        }
        if ($categoryId !== null && $categoryId !== '') {
            $query->where('product_video_category_id', (int)$categoryId);
        }

        $videos = $query->orderByDesc('sort')->orderByDesc('id')->paginate(15)->appends($request->query());

        return view($this->viewPath . '.index', [
            'videos' => $videos,
            'categories' => ProductVideoCategory::query()->with('translations')->orderByDesc('sort')->orderByDesc('id')->get(),
            'name' => $name,
            'active' => $active,
            'isRecommend' => $isRecommend,
            'categoryId' => $categoryId,
        ]);
    }

    public function create()
    {
        $selectedProductIds = array_map('intval', (array)old('products', []));

        return view($this->viewPath . '.create', [
            'categories' => ProductVideoCategory::query()->with('translations')->orderByDesc('sort')->orderByDesc('id')->get(),
            'products' => $this->productsForRelation($selectedProductIds),
        ]);
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'path' => ['nullable', 'string', 'max:255'],
            'video_url' => ['nullable', 'string', 'max:1000'],
            'url_key' => ['nullable', 'string', 'max:255'],
            'product_video_category_id' => ['nullable', 'integer'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'is_recommend' => ['nullable', 'integer', 'in:0,1'],
            'active' => ['nullable', 'integer', 'in:0,1'],
            'products' => ['array'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $payload = $request->only(['path', 'video_url', 'url_key', 'product_video_category_id', 'sort', 'is_recommend', 'active']);
        $payload['sort'] = (int)($payload['sort'] ?? 0);
        $payload['is_recommend'] = (int)($payload['is_recommend'] ?? 0);
        $payload['active'] = (int)($payload['active'] ?? 1);
        if (empty($payload['product_video_category_id'])) {
            $payload['product_video_category_id'] = null;
        }
        $locale = config('app.locale');
        $name = (string)($request->input("translate.{$locale}.name") ?: 'video');
        $payload['url_key'] = $this->resolveVideoUrlKey($payload['url_key'] ?? '', $name, true);

        $translate = (array)$request->get('translate', []);
        $model = ProductVideo::create(array_merge($payload, $translate));
        $model->products()->sync(array_values(array_filter(array_map('intval', (array)$request->get('products', [])))));
        $model->refresh();
        $model->syncUrlRecord();
        $model->load('url');

        return redirect()->route('admin.productVideo.index')->with('success', __('创建成功'));
    }

    public function edit($id)
    {
        $model = ProductVideo::query()->with(['translations', 'products'])->findOrFail($id);
        $selectedProductIds = array_map('intval', (array)old('products', $model->products->pluck('id')->all()));

        return view($this->viewPath . '.edit', [
            'model' => $model,
            'categories' => ProductVideoCategory::query()->with('translations')->orderByDesc('sort')->orderByDesc('id')->get(),
            'products' => $this->productsForRelation($selectedProductIds),
            'selectedProductIds' => $selectedProductIds,
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'path' => ['nullable', 'string', 'max:255'],
            'video_url' => ['nullable', 'string', 'max:1000'],
            'url_key' => ['nullable', 'string', 'max:255'],
            'product_video_category_id' => ['nullable', 'integer'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'is_recommend' => ['nullable', 'integer', 'in:0,1'],
            'active' => ['nullable', 'integer', 'in:0,1'],
            'products' => ['array'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = ProductVideo::query()->findOrFail($id);
        $payload = $request->only(['path', 'video_url', 'url_key', 'product_video_category_id', 'sort', 'is_recommend', 'active']);
        $payload['sort'] = (int)($payload['sort'] ?? 0);
        $payload['is_recommend'] = (int)($payload['is_recommend'] ?? 0);
        $payload['active'] = (int)($payload['active'] ?? 1);
        if (empty($payload['product_video_category_id'])) {
            $payload['product_video_category_id'] = null;
        }
        $locale = config('app.locale');
        $name = (string)($request->input("translate.{$locale}.name") ?: ($model->name ?: 'video'));
        $rawKey = trim((string)($payload['url_key'] ?? ''));
        if ($rawKey === '') {
            $payload['url_key'] = $model->url_key ?: $this->resolveVideoUrlKey('', $name, true);
        } else {
            $payload['url_key'] = $this->resolveVideoUrlKey($rawKey, $name, false);
        }

        $translate = (array)$request->get('translate', []);
        $model->update(array_merge($payload, $translate));
        $model->products()->sync(array_values(array_filter(array_map('intval', (array)$request->get('products', [])))));
        $model->refresh();
        $model->syncUrlRecord();
        $model->load('url');

        return redirect()->route('admin.productVideo.index')->with('success', __('更新成功'));
    }

    public function destroy($id)
    {
        $model = ProductVideo::query()->findOrFail($id);
        $model->delete();
        return redirect()->route('admin.productVideo.index')->with('success', __('删除成功'));
    }

    /** AJAX：产品搜索（关联产品） */
    public function searchProducts(Request $request)
    {
        $keyword = trim((string)$request->get('keyword', ''));
        $selected = array_values(array_unique(array_filter(array_map('intval', (array)$request->get('selected_ids', [])))));

        $query = Product::query()
            ->with(['translations'])
            ->active()
            ->where('is_temp', 0);

        if ($keyword !== '') {
            if (ctype_digit($keyword)) {
                $query->where('id', (int)$keyword);
            } else {
                $query->whereTranslationLike('name', '%' . $keyword . '%');
            }
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

    /**
     * @param array<int> $selectedIds
     */
    protected function productsForRelation(array $selectedIds = [])
    {
        $selectedIds = array_values(array_unique(array_filter(array_map('intval', $selectedIds))));

        $products = Product::query()
            ->with('translations')
            ->active()
            ->where('is_temp', 0)
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->limit(800)
            ->get();

        if (!empty($selectedIds)) {
            $existingIds = $products->pluck('id')->map(static fn ($id) => (int)$id)->all();
            $missingIds = array_values(array_diff($selectedIds, $existingIds));
            if (!empty($missingIds)) {
                $extra = Product::query()
                    ->with('translations')
                    ->whereIn('id', $missingIds)
                    ->orderByDesc('id')
                    ->get();
                $products = $extra->concat($products);
            }
        }

        return $products;
    }

    /**
     * Ensure url_key uses config('url.product_video') prefix (video/).
     */
    protected function resolveVideoUrlKey($raw, string $name, bool $isCreate): string
    {
        $prefix = trim((string)config('url.product_video', 'video/'), '/');
        if ($prefix === '') {
            $prefix = 'video';
        }
        $prefix .= '/';

        $key = trim((string)$raw);
        $key = str_replace('\\', '/', $key);
        $key = trim($key, '/');
        $key = preg_replace('#^(video|product-video|product_video)/#i', '', $key);
        $key = trim((string)$key, '/');

        if ($key === '') {
            $key = Str::slug(trim($name), '-', 'en');
        } else {
            if (str_contains($key, '/')) {
                $parts = array_values(array_filter(explode('/', $key), static fn ($p) => $p !== ''));
                $key = implode('-', $parts);
            }
            $key = Str::slug($key, '-', 'en');
        }

        if ($key === '') {
            $key = 'video-' . ($isCreate ? time() : 'item');
        }

        return $prefix . $key;
    }
}
