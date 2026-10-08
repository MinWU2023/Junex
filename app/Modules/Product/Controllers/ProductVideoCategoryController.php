<?php

namespace App\Modules\Product\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Models\ProductVideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductVideoCategoryController extends BaseController
{
    public function __construct(ProductVideoCategory $model)
    {
        $this->modelName = 'ProductVideoCategory';
        $this->model = $model;
        $this->viewPath = 'Product.Views.productVideoCategory';
        $this->orderBy = 'sort';
    }

    public function index()
    {
        $items = ProductVideoCategory::query()->with(['translations'])->orderByDesc('sort')->orderByDesc('id')->paginate(15);
        return view($this->viewPath . '.index', compact('items'));
    }

    public function create()
    {
        return view($this->viewPath . '.create');
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'path' => ['nullable', 'string', 'max:255'],
            'url_key' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
        ]);
        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $payload = $request->only(['path', 'url_key', 'sort', 'active']);
        $payload['sort'] = (int)($payload['sort'] ?? 0);
        $payload['active'] = (int)($payload['active'] ?? 1);
        $locale = config('app.locale');
        $name = (string)($request->input("translate.{$locale}.name") ?: 'video-category');
        $payload['url_key'] = $this->resolveCategoryUrlKey($payload['url_key'] ?? '', $name, true);

        $translate = (array)$request->get('translate', []);
        $model = ProductVideoCategory::create(array_merge($payload, $translate));
        $model->refresh();
        $model->syncUrlRecord();
        $model->load('url');

        return redirect()->route('admin.productVideoCategory.index')->with('success', __('创建成功'));
    }

    public function edit($id)
    {
        $model = ProductVideoCategory::query()->with('translations')->findOrFail($id);
        return view($this->viewPath . '.edit', compact('model'));
    }

    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), [
            'path' => ['nullable', 'string', 'max:255'],
            'url_key' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'active' => ['nullable', 'integer', 'in:0,1'],
        ]);
        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = ProductVideoCategory::query()->findOrFail($id);
        $payload = $request->only(['path', 'url_key', 'sort', 'active']);
        $payload['sort'] = (int)($payload['sort'] ?? 0);
        $payload['active'] = (int)($payload['active'] ?? 1);
        $locale = config('app.locale');
        $name = (string)($request->input("translate.{$locale}.name") ?: ($model->name ?: 'video-category'));
        $rawKey = trim((string)($payload['url_key'] ?? ''));
        if ($rawKey === '') {
            $payload['url_key'] = $model->url_key ?: $this->resolveCategoryUrlKey('', $name, true);
        } else {
            $payload['url_key'] = $this->resolveCategoryUrlKey($rawKey, $name, false);
        }

        $translate = (array)$request->get('translate', []);
        $model->update(array_merge($payload, $translate));
        $model->refresh();
        $model->syncUrlRecord();
        $model->load('url');

        return redirect()->route('admin.productVideoCategory.index')->with('success', __('更新成功'));
    }

    public function destroy($id)
    {
        $model = ProductVideoCategory::query()->withCount('videos')->findOrFail($id);
        if ($model->videos_count > 0) {
            return redirect()
                ->route('admin.productVideoCategory.index')
                ->with('error', __('无法删除：该分类下仍有视频，请先移除或转移视频。'));
        }

        $model->delete();

        return redirect()->route('admin.productVideoCategory.index')->with('success', __('删除成功'));
    }

    /**
     * Ensure url_key uses config('url.product_video_category') prefix (videocategory/).
     */
    protected function resolveCategoryUrlKey($raw, string $name, bool $isCreate): string
    {
        $prefix = trim((string)config('url.product_video_category', 'videocategory/'), '/');
        if ($prefix === '') {
            $prefix = 'videocategory';
        }
        $prefix .= '/';

        $key = trim((string)$raw);
        $key = str_replace('\\', '/', $key);
        $key = trim($key, '/');
        $key = preg_replace('#^(videocategory|video-category|product_video_category)/#i', '', $key);
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
            $key = 'video-category-' . ($isCreate ? time() : 'item');
        }

        return $prefix . $key;
    }
}
