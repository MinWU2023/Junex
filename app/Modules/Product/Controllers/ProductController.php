<?php

namespace App\Modules\Product\Controllers;

use App\Modules\Admin\Models\AdminLog;
use App\Modules\Admin\Models\User;
use App\Modules\Article\Models\Article;
use App\Modules\Common\Collections\CommonCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Collections\ProductListCollection;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductAttributeCategory;
use App\Modules\Product\Models\ProductAttributeValue;
use App\Modules\Product\Models\ProductBrand;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductFile;
use App\Modules\Product\Models\ProductImage;
use App\Modules\Product\Models\ProductTag;
use App\Modules\Url\Models\Url;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class ProductController extends BaseController
{
    private const TRANSLATABLE_FIELDS = [
        'brief_content',
        'content',
        'm_content',
        'product_details',
        'title',
        'keywords',
        'description'
    ];
    public function __construct(Product $product)
    {
        $this->modelName = 'Product';
        $this->model = $product;
        $this->modelSource = $product;
        $this->viewPath = 'Product.Views.product';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'categories' => 'required',
            'translate.' . config('app.locale') . '.name' => 'required',
            'is_main' => 'required',
            'translate.' . config('app.locale') . '.content' => 'required',
        ];
        $this->messages = [
            'translate.' . config('app.locale') . '.name.required' => '请填写产品名(' . config('app.locale') . ')',
            'translate.' . config('app.locale') . '.content.required' => '请填写详情(' . config('app.locale') . ')',
            'is_main.required' => '请添加主图',
            'categories.required' => '请选择产品分类',
        ];
    }

    public function index()
    {
        $request = \request();
        $category_id = intval($request->get('category_id'));
        $brand_id = intval($request->get('brand_id'));
        $name = $request->get('name');
        $id = $request->get('id');
        $productCategory = '';
        if ($category_id) {
            $productCategory = ProductCategory::find($category_id);
        }
        $productBrand = '';
        if ($brand_id) {
            $productBrand = ProductBrand::find($brand_id);
        }
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(
                Product::query()->with(['translations:name,product_id,locale', 'admin', 'productImages', 'productBrand']),
                function ($query) use ($request) {
                    if ($name = $request->get('name')) {
                        $query->whereTranslationLike('name', '%' . $name . '%');
                    }
                    if ($id = $request->get('id')) {
                        $query->where('id', $id);
                    }
                    if ($brand_id = $request->get('brand_id')) {
                        $query->where('product_brand_id', $brand_id);
                    }
                    if ($attribute_value = $request->get('attribute_value')) {
                        $product_id = ProductAttributeValue::select('product_id')->whereTranslationLike('name', '%' . $attribute_value . '%')->get()->toArray();
                        $product_id = array_column($product_id, 'product_id');
                        $query->whereIn('id', $product_id);
                    }
                    if ($select_admin = $request->get('select_admin')) {
                        $query->where('admin_user_id', $select_admin);
                    }
                    if ($sort = $request->get('sort')) {
                        $temp = explode('-', $sort);
                        if (count($temp) === 2) {
                            if ($temp[0] === 'name') {
                                $query->orderByTranslation($temp[0], $temp[1]);
                            } else {
                                $query->orderBy($temp[0], $temp[1]);
                            }
                        }
                    } else {
                        $query->latest('updated_at');
                    }
                    if ($attributes = $request->get('attribute')) {
                        $attributes = explode(',', $attributes);
                        if (is_array($attributes) && count($attributes)) {
                            foreach ($attributes as $attribute) {
                                switch ($attribute) {
                                    case 'is_new':
                                        $query->where('is_new', 1);
                                        break;
                                    case 'is_hot':
                                        $query->where('is_hot', 1);
                                        break;
                                    case 'is_recommend':
                                        $query->where('is_recommend', 1);
                                        break;
                                }
                            }
                        }
                    }
                    $query->active();
                }
            );
            if ($request->get('category_id')) {
                $category_id = $request->get('category_id');
                $cate_ids = [$category_id];
                self::getChildCategory($category_id, $cate_ids);
                $data->whereHas('productCategory', function ($categoryQuery) use ($cate_ids) {
                    $categoryQuery->whereIn('product_category_id', $cate_ids);
                });
            }

            if (!in_array(\auth()->id(), User::ALLOW_ADMIN_ID)) {
                $data->whereHas('admin', function ($query) {
                    $query->where('admin_user_id', \auth()->id());
                });
            }

            if ($request->get('keywords')) {
                $data->whereHas('productTags', function ($query) use ($request) {
                    if ($keywords = $request->get('keywords')) {
                        $query->whereTranslationLike('name', $keywords);
                    }
                });
            }


            $data = $data->paginate($request->input('limit', 15));

            return new ProductListCollection($data);
        }
        $admins = User::query()->get();
        return view(
            $this->viewPath . '.index',
            compact('category_id', 'brand_id', 'productCategory', 'admins', 'productBrand', 'name', 'id')
        );
    }


    private static function getChildCategory($category_id, &$cate_ids)
    {
        $children_ids = ProductCategory::with(['children'])->where('parent_id', $category_id)->pluck('id')->toArray();
        if (isset($children_ids[0])) {
            foreach ($children_ids as $children_id) {
                $cate_ids[] = $children_id;
                self::getChildCategory($children_id, $cate_ids);
            }
        }
    }

    public function trash()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(Product::with(['translations', 'productImages']), function ($query) use ($request) {
                if ($name = $request->get('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            })
                ->unActive()->where('is_draft', 0)->orderByDesc('updated_at')
                ->paginate($request->input('limit', 15));
            return new ProductListCollection($data);
        }
        return view($this->viewPath . '.trash', compact('name'));
    }


    public function keywords(Request $request)
    {
        $keyword = $request->get('keyword');
        $page = $request->get('page', 1);
        $size = $request->get('limit', 15);
        if (!$keyword) {
            return new CommonCollection([]);
        }
        $adwords_token = app('settings')['setting']->adwords_token;
        //        $adwords_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImI3ZmZlYjQ2N2VlMDk1MzhlMWIzOTYwOThmOWE2NDk3MmQ3YzFlZmIwNmY0ZWY5ZjM2ZTFmNjRiM2M4YTgxOWIzZWY0ZmUwOGRiY2UxZjZhIn0.eyJhdWQiOiIxIiwianRpIjoiYjdmZmViNDY3ZWUwOTUzOGUxYjM5NjA5OGY5YTY0OTcyZDdjMWVmYjA2ZjRlZjlmMzZlMWY2NGIzYzhhODE5YjNlZjRmZTA4ZGJjZTFmNmEiLCJpYXQiOjE2NjAwMTM0MzcsIm5iZiI6MTY2MDAxMzQzNywiZXhwIjoxNjkxNTQ5NDM3LCJzdWIiOiIzNTAiLCJzY29wZXMiOltdfQ.fnhgQp2QiyCcR1PjNBGl6vZjh_o2uw2-qcpPoW2zeyUQJriabHaOjCMCH3QcUqFa1p8zMsJQJKcISePVThrxmBPi0gZK7gGjv0dGFbfIh9MvUQO1l2T50BL27v3rE8tIzQUNcj0Bxp5bkC4bFWSQHmKdgidC-AJNUyiwKEFZh3QBUF1qyIN2-KDDGvB2Qa-zeV2lX1ZVeSme5Jx26i9N5lCt3J6PIiSMK3VKPH7eFYfe1YqK7OHmO28vaeHU9q8lDpcOY4f4TH_RvJihj0ZileLqp2lHGmB4DdyDmSAL-aE9m-DeTHkVPDh9ube-rWPGvBwxsH3ch7azb8bfsBoVeJDGOmY4MkS0o9xO8PMXE9OLTPvtjOEPH00nGTwttpdRx7LJ2TsgdHyz27oT7GW8lMpHyJxSNAHj7cKv_tpS6gOmfS0alZ8KnD43ED5WH2Nsl10TEGHxVcA_pF4iqBIh2r9xFrh6NltlQPJUTmTo2C9UpegCh1ARqmFJARuwQu0lj42FPshtWD9gySvJZQvstMo1Vn__crpgPJ1mT9lQbNG6QX6wOPq1_aYTl-gawRhapFoXczHOO9qNymfTsFP7Px0163_vKATt6sSd_5mcHDJEHwSUnUys9yS0KFnV8-6GmcSOGez_i2qKB7iHQeCML9q7EnC1hZjfi2pXN6kQeqU';
        if (!$adwords_token) {
            return [
                'msg' => 'adwords token未填写',
                'code' => 0,
                'count' => 0,
                'data' => [],
            ];
        }
        $responseData = Http::withToken($adwords_token)->post('https://www.dyykeyword.com/api/search', [
            'keyword' => $keyword,
            'page' => $page,
            'size' => $size
        ]);
        if (!$responseData->json()) {
            return [
                'msg' => '请检查token是否填写正确',
                'code' => 0,
                'count' => 0,
                'data' => [],
            ];
        }
        $res = [
            'data' => isset($responseData->json()['data']) ? $responseData->json()['data'] : [],
            'code' => 0,
            'count' => $responseData->json()['total']['value'] - 15
        ];
        return $res;
    }

    public function restore($id)
    {
        $product = Product::find($id);
        try {
            // 恢复产品状态
            $product->active = 1;
            $product->save();

            // 还原关键词关联关系
            if ($product->backup_tags) {
                $backupTags = json_decode($product->backup_tags, true);
                if (is_array($backupTags) && count($backupTags) > 0) {
                    $tagIds = [];
                    foreach ($backupTags as $tagData) {
                        // 检查关键词是否还存在，如果不存在则创建
                        $productTag = ProductTag::find($tagData['id']);
                        if (!$productTag) {
                            // 关键词可能已被删除，尝试根据名称查找或创建
                            $productTag = ProductTag::whereTranslation('name', $tagData['name'])->first();
                            if (!$productTag) {
                                $productTag = ProductTag::create([
                                    'url_key' => trim(config('url.product_tag') . Str::slug($tagData['name'], '-', config('app.locale')), '/'),
                                    'sort' => 0,
                                    config('app.locale') => [
                                        'name' => $tagData['name']
                                    ]
                                ]);
                            }
                        }

                        if ($productTag) {
                            $tagIds[$productTag->id] = ['sort' => $tagData['sort']];
                        }
                    }

                    if (count($tagIds) > 0) {
                        $product->productTags()->sync($tagIds);
                    }
                }

                // 清除备份数据
                $product->backup_tags = null;
                $product->save();
            }
        } catch (\PDOException $exception) {
            Log::error($this->modelName . '（' . $id . '）恢复失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function create()
    {
        $attribute_categories = ProductAttributeCategory::all();
        return view($this->viewPath . '.create', compact('attribute_categories'));
    }

    public function getAttribute($attributeCategoryId, Request $request)
    {
        if ($attributeCategoryId) {
            $attribute_category = ProductAttributeCategory::with(['attributes' => function ($query) {
                $query->orderByDesc('sort')->with(['translations']);
            }])->find($attributeCategoryId);
            $productAttribute = $attribute_category->attributes;
        } else {
            $productAttribute = [];
        }
        $productAttributeValues = collect();
        if ($product_id = $request->post('product_id')) {
            $productAttributeValues = ProductAttributeValue::where([
                'product_id' => $product_id
            ])->orderByDesc('sort')->orderBy('id')->get();
        }

        $locales = config('translatable.locales');
        if (!auth()->user()->hasRole('超级管理员') && !app('settings')['setting']->all_locale_active) {
            $locales = ['en'];
        }
        $arr = [
            'productAttribute' => $productAttribute,
            'theLocales' => $locales,
            'productAttributeValues' => $productAttributeValues,
            'attribute_category_id' => $attributeCategoryId
        ];
        $out = View::make('components.admin.product-attribute', $arr)
            ->render();
        return $this->data($out);
    }

    public function copy($id)
    {
        $model = $this->model->with(['productCategory', 'productBrand', 'productTags', 'translations' => function ($query) {
            $query->where('locale', config('app.locale'));
        }])->find($id);
        $attribute_categories = ProductAttributeCategory::all();
        return view(
            $this->viewPath . '.copy',
            [
                'model' => $model,
                'attribute_categories' => $attribute_categories
            ]
        );
    }

    public function video($id, Request  $request)
    {
        $model = $this->model->with(['productCategory', 'productBrand', 'productTags', 'translations' => function ($query) {
            $query->where('locale', config('app.locale'));
        }])->find($id);
        $attribute_categories = ProductAttributeCategory::all();
        return view(
            $this->viewPath . '.video',
            [
                'model' => $model,
                'attribute_categories' => $attribute_categories
            ]
        );
    }

    public function edit($id)
    {
        $model = $this->model->with(['productCategory', 'productBrand', 'productTags'])->find($id);
        $attribute_categories = ProductAttributeCategory::all();
        $data = $this->checkTranslate($id);
        $data['attribute_categories'] = $attribute_categories;
        $data['model'] = $model;

        $products = Product::where('is_temp', 1)->where('created_at', '<', date('Y-m-d H:i:s', strtotime("-1day")))->get();
        $is_del = false;
        foreach ($products as $model) {
            DB::table('product_attribute_values')->where('product_id', $model->id)->delete();
            DB::table('product_product_tag')->where('product_id', $model->id)->delete();
            DB::table('product_attribute_values')->where('product_id', $model->id)->delete();
            Product::where('id', $model->id)->delete();
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Product\Models\Product',
                'urlable_id' => $model->id
            ])->forceDelete();
            $is_del = true;
        }
        if ($is_del) {
            $maxId = Product::query()->max('id');
            // 如果你想设置的新的起始自增ID比当前最大ID小，那么你需要确保不会产生冲突
            $newStartingId = $maxId + 1; // 你希望设置的下一个自增ID
            // 执行SQL命令来修改自增ID
            DB::statement("ALTER TABLE products AUTO_INCREMENT = $newStartingId;");
        }
        return view($this->viewPath . '.edit', $data);
    }

    public function update($id, Request $request)
    {
        $action = $request->get('action');
        $model = $this->model->find($id);
        if (!$model) {
            return $this->badRequest();
        }
        if (!in_array(Auth::id(), User::ALLOW_ADMIN_ID) && Auth::id() != $model->admin_user_id) {
            return $this->badRequest('无权限修改');
        }

        $translate = $request->get('translate');
        $locale = config('app.locale');
        $name = (string)(($translate[$locale]['name'] ?? '') ?: ($model->name ?? ''));

        // SEO 页提交了自定义 url：空则按产品名生成；有值则规范化；未提交则不改 url_key
        $resolvedUrlKey = null;
        if ($request->exists('url_key')) {
            $rawUrlKey = trim((string)$request->input('url_key'));
            $resolvedUrlKey = $this->resolveProductUrlKey($rawUrlKey, $name, false);
            // 手动修改时校验唯一；清空后自动生成交给 syncUrlRecord 去重
            if ($rawUrlKey !== '') {
                $this->validatorData['url_key'] = [
                    'required',
                    new UrlKeyRule($id, Product::class),
                ];
            }
        }
        if ($action === 'draft') {
            $this->validatorData = [
                'sort' => 'required|numeric',
                'translate.' . $locale . '.name' => 'required',
            ];
            if ($resolvedUrlKey !== null && trim((string)$request->input('url_key')) !== '') {
                $this->validatorData['url_key'] = [
                    'required',
                    new UrlKeyRule($id, Product::class),
                ];
            }
        }

        $validator = $this->getValidationFactory()->make(
            array_merge($request->all(), $resolvedUrlKey !== null ? ['url_key' => $resolvedUrlKey] : []),
            $this->validatorData,
            $this->messages
        );
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $temp_ids = Product::where('is_temp', 1)->pluck('id')->toArray();
        $temp_ids[] = $id;
        $repeat = DB::table('product_translations')->where([
            'locale' => $locale,
            'name' => $translate[$locale]['name']
        ])->whereNotIn('product_id', $temp_ids)->first();
        if ($repeat) {
            $validator->errors()->add('field', '产品名已存在，请修改');
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        if ($resolvedUrlKey !== null) {
            $update['url_key'] = $resolvedUrlKey;
        } else {
            unset($update['url_key']);
        }
        try {
            $temp_product_id = $request->get('temp_product_id');
            $this->delTempProduct($temp_product_id);

            $update['product_brand_id'] = $request->get('brand_id');
            $update['updated_at'] = date('Y-m-d H:i:s');
            foreach (self::TRANSLATABLE_FIELDS as $field) {
                if (array_key_exists($field, $update[$locale]) && empty(trim($update[$locale][$field]))) {
                    foreach (config('translatable.locales') as $loc) {
                        $update[$loc][$field] = null;
                    }
                }
            }
            $originalUrlKey = trim((string)($model->url_key ?: optional($model->url)->url), '/');
            $model->update($update);
            if ($resolvedUrlKey !== null && $resolvedUrlKey !== $originalUrlKey) {
                $model->refresh();
                $model->syncUrlRecord();
            }
            DB::table('product_images')->where('product_id', $model->id)->delete();
            DB::table('product_files')->where('product_id', $model->id)->delete();
            $this->createProductCategory($model, $request);
            $this->createProductImage($model, $request);
            $this->createProductFile($model, $request);
            $this->createProductTag($model, $request);
            $this->createProductArticle($model, $request);
            if ($update['attribute_category_id'] == 0) {
                //清除产品关联属性
                $model->attributes()->detach();
            } else {
                if (isset($update['attributes'])) {
                    $attributes = $update['attributes'];
                    $this->saveAttribute($model, $attributes);
                }
            }
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . $request->user()->email . '编辑产品(' . $model->id . ')' . $model->name,
                'modelName' => $this->modelName,
                'content' => json_encode($request->all()),
                'data_source_id' => $id,
                'data_created_at' => $model->created_at
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function changeProperty($id, Request $request)
    {
        $model = $this->model->find($id);
        switch ($request->type) {
            case 'product_new':
                $model->is_new = !$model->is_new;
                break;
            case 'product_hot':
                $model->is_hot = !$model->is_hot;
                break;
            case 'product_recommend':
                $model->is_recommend = !$model->is_recommend;
                break;
            case 'product_sort':
                $model->sort = intval($request->get('sort'));
                break;
        }
        $model->save();
        return $this->success();
    }

    public function store(Request $request)
    {
        $action = $request->get('action');
        if ($action === 'draft') {
            $this->validatorData = [
                'sort' => 'required|numeric',
                'translate.' . config('app.locale') . '.name' => 'required',
            ];
        }
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData, $this->messages);
        $translate = $request->get('translate');
        $temp_ids = Product::where('is_temp', 1)->pluck('id')->toArray();
        $repeat = DB::table('product_translations')->where([
            'locale' => config('app.locale'),
            'name' => $translate[config('app.locale')]['name']
        ])->whereNotIn('product_id', $temp_ids)->first();
        if ($repeat) {
            $validator->errors()->add('field', '产品名已存在，请修改');
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        $locale = config('app.locale');
        $name = (string)($translate[$locale]['name'] ?? $add[$locale]['name'] ?? '');
        $rawUrlKey = trim((string)$request->input('url_key', ''));
        $add['url_key'] = $this->resolveProductUrlKey($rawUrlKey, $name, true);

        // 手动填写的 url 做唯一校验；留空自动生成时由 syncUrlRecord 处理冲突后缀
        if ($rawUrlKey !== '') {
            $urlValidator = $this->getValidationFactory()->make(
                ['url_key' => $add['url_key']],
                ['url_key' => ['required', new UrlKeyRule(null, Product::class)]],
                $this->messages
            );
            if (!$urlValidator->passes()) {
                return response()->json([
                    'code' => 422,
                    'errors' => $urlValidator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        try {
            $temp_product_id = $request->get('temp_product_id');
            $this->delTempProduct($temp_product_id);
            $add['product_brand_id'] = $request->get('brand_id');
            $add['admin_user_id'] = Auth::id();
            $add['add_date'] = date('Ym');
            $product = $this->model->create($add);
            $product->refresh();
            $product->syncUrlRecord();
            $this->createProductCategory($product, $request);
            $this->createProductImage($product, $request);
            $this->createProductFile($product, $request);
            $this->createProductTag($product, $request);
            $this->createProductArticle($product, $request);
            if (isset($add['attributes'])) {
                $attributes = $add['attributes'];
                $this->saveAttribute($product, $attributes);
            }
            if ($action === 'draft') {
                $product->is_draft = 1;
                $product->active = 0;
                $product->save();
            }
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . $request->user()->email . '新增产品(' . $product->id . ')' . $product->name,
                'modelName' => $this->modelName,
                'content' => json_encode($request->all())
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }


    protected function delTempProduct($temp_product_id)
    {
        $product = Product::with(['productTags', 'attributes'])->where([
            'is_temp' => 1,
            'id' => $temp_product_id,
        ])->first();
        if ($product) {
            DB::table('product_attribute_values')->where('product_id', $product->id)->delete();
            $product->productTags()->detach($product->productTags);
            $product->attributes()->detach($product->attributes);
            $product->delete();
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Product\Models\Product',
                'urlable_id' => $product->id
            ])->forceDelete();
            $maxId = Product::query()->max('id');
            // 如果你想设置的新的起始自增ID比当前最大ID小，那么你需要确保不会产生冲突
            $newStartingId = $maxId + 1; // 你希望设置的下一个自增ID
            // 执行SQL命令来修改自增ID
            DB::statement("ALTER TABLE products AUTO_INCREMENT = $newStartingId;");
        }
    }

    public function remove(Request $request)
    {
        $id = $request->get('id');
        $product = Product::with(['productTags'])->find($id);
        if (!in_array(Auth::id(), User::ALLOW_ADMIN_ID) && Auth::id() != $product->admin_user_id) {
            return $this->badRequest('无权限');
        }
        try {
            // 备份关键词数据
            $backupTags = [];
            if ($product->productTags->count() > 0) {
                foreach ($product->productTags as $tag) {
                    $backupTags[] = [
                        'id' => $tag->id,
                        'name' => $tag->name,
                        'sort' => $tag->pivot->sort ?? 0
                    ];
                }
            }

            // 保存备份数据到产品表
            $product->backup_tags = json_encode($backupTags);

            // 删除产品与关键词的关联关系
            DB::table('product_product_tag')->where('product_id', $product->id)->delete();

            // 软删除产品
            $product->active = 0;
            $product->save();
        } catch (\PDOException $exception) {
            Log::error('ProductController:remove:产品（' . $id . '）软删除失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
        if (!in_array(Auth::id(), User::ALLOW_ADMIN_ID) && Auth::id() != $model->admin_user_id) {
            return $this->badRequest('无权限');
        }
        try {
            DB::table('product_attribute_values')->where('product_id', $model->id)->delete();
            $model->productTags()->detach($model->productTags);
            $model->attributes()->detach($model->attributes);
            $model->delete();
            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Product\Models\Product',
                'urlable_id' => $model->id
            ])->forceDelete();
            AdminLog::log([
                'name' => date('Y-m-d H:i:s') . ' 用户' . \request()->user()->email . '将产品(' . $model->id . ')' . $model->name . '删除',
                'modelName' => $this->modelName,
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function multipleMoveCategoryShow()
    {
        return view($this->viewPath . '.multipleMoveCategoryShow');
    }


    public function multipleMoveCategory(Request $request)
    {
        $ids = explode(',', $request->get('ids'));
        if (!$request->get('categories')) {
            return $this->badRequest('请选择分类');
        }
        foreach ($ids as $id) {
            $product = Product::find($id);
            $product->productCategory()->sync($request->get('categories'));
        }
        return $this->success();
    }

    public function multipleMoveBrandShow()
    {
        return view($this->viewPath . '.multipleMoveBrandShow');
    }

    public function multipleMoveBrand(Request $request)
    {
        $ids = $request->get('ids');
        Product::whereIn('id', explode(',', $ids))->update(
            [
                'product_brand_id' => $request->get('brand_id')
            ]
        );
        return $this->success();
    }

    public function multipleMoveUserShow()
    {
        return view($this->viewPath . '.multipleMoveUser');
    }

    public function multipleMoveUser(Request $request)
    {
        $ids = $request->get('ids');
        Product::whereIn('id', explode(',', $ids))->update(
            [
                'admin_user_id' => $request->get('user_id')
            ]
        );
        return $this->success();
    }

    public function multipleMoveTrash(Request $request)
    {
        $ids = $request->get('ids');

        $products = Product::with(['productTags'])->whereIn('id', $ids)->get();

        foreach ($products as $product) {
            try {
                // 备份关键词数据
                $backupTags = [];
                if ($product->productTags->count() > 0) {
                    foreach ($product->productTags as $tag) {
                        $backupTags[] = [
                            'id' => $tag->id,
                            'name' => $tag->name,
                            'sort' => $tag->pivot->sort ?? 0
                        ];
                    }
                }

                // 保存备份数据到产品表
                $product->backup_tags = json_encode($backupTags);

                // 删除产品与关键词的关联关系
                DB::table('product_product_tag')->where('product_id', $product->id)->delete();

                // 软删除产品
                $product->active = 0;
                $product->save();
            } catch (\Exception $exception) {
                Log::error('批量删除产品(' . $product->id . ')失败,msg:' . $exception->getMessage());
            }
        }

        return $this->success();
    }

    public function multipleRestore(Request $request)
    {
        $ids = $request->get('ids');

        $products = Product::whereIn('id', $ids)->get();

        foreach ($products as $product) {
            try {
                // 恢复产品状态
                $product->active = 1;
                $product->save();

                // 还原关键词关联关系
                if ($product->backup_tags) {
                    $backupTags = json_decode($product->backup_tags, true);
                    if (is_array($backupTags) && count($backupTags) > 0) {
                        $tagIds = [];
                        foreach ($backupTags as $tagData) {
                            // 检查关键词是否还存在，如果不存在则创建
                            $productTag = ProductTag::find($tagData['id']);
                            if (!$productTag) {
                                // 关键词可能已被删除，尝试根据名称查找或创建
                                $productTag = ProductTag::whereTranslation('name', $tagData['name'])->first();
                                if (!$productTag) {
                                    $productTag = ProductTag::create([
                                        'url_key' => trim(config('url.product_tag') . Str::slug($tagData['name'], '-', config('app.locale')), '/'),
                                        'sort' => 0,
                                        config('app.locale') => [
                                            'name' => $tagData['name']
                                        ]
                                    ]);
                                }
                            }

                            if ($productTag) {
                                $tagIds[$productTag->id] = ['sort' => $tagData['sort']];
                            }
                        }

                        if (count($tagIds) > 0) {
                            $product->productTags()->sync($tagIds);
                        }
                    }

                    // 清除备份数据
                    $product->backup_tags = null;
                    $product->save();
                }
            } catch (\Exception $exception) {
                Log::error('批量恢复产品(' . $product->id . ')失败,msg:' . $exception->getMessage());
            }
        }

        return $this->success();
    }

    public function multipleDestroy(Request $request)
    {
        $ids = $request->get('ids');

        $products = Product::with(['productTags'])->whereIn('id', $ids)->get();
        foreach ($products as $product) {
            try {
                DB::table('product_attribute_values')->where('product_id', $product->id)->delete();
                $product->productTags()->detach($product->productTags);
                $product->attributes()->detach($product->attributes);
                $product->delete();
                Url::withTrashed()->where(['urlable_id' => $product->id, 'urlable_type' => 'App\Modules\Product\Models\Product'])->forceDelete();
            } catch (\Exception $exception) {
                Log::error('删除产品(' . $product->id . ')失败,msg:' . $exception->getMessage());
            }
        }
        return $this->success();
    }

    protected function createProductImage(Product $product, $request)
    {
        if ($imgPaths = $request->get('imgPath')) {
            $sorts = $request->get('imgSorts');
            $alts = $request->get('imgAlts');
            foreach ($imgPaths as $key => $imgPath) {
                if ($imgPath) {
                    $add = [];
                    $add['product_id'] = $product->id;
                    $add['path'] = $imgPath;
                    $add['is_main'] = $request->get('is_main') === $imgPath;
                    $add['sort'] = isset($sorts[$key]) ? $sorts[$key] : 0;
                    $add['alt'] = isset($alts[$key]) ? $alts[$key] : '';
                    ProductImage::create($add);
                }
            }
        }
    }

    protected function createProductFile(Product $product, $request)
    {
        if ($filePaths = $request->get('filePath')) {
            $sorts = $request->get('fileSorts');
            $names = $request->get('fileNames');
            foreach ($filePaths as $key => $imgPath) {
                if (isset($names[$key])) {
                    $add = [];
                    $add['product_id'] = $product->id;
                    $add['path'] = $imgPath;
                    $add['name'] = $names[$key];
                    $add['sort'] = isset($sorts[$key]) ? $sorts[$key] : 0;
                    ProductFile::create($add);
                }
            }
        }
    }


    protected function createProductCategory(Product $product, $request)
    {
        $categoryIds = $request->get('categories', []);
        $categoryIds = ProductCategory::query()->whereIn('id', $categoryIds)->pluck('id')->toArray();
        $product->productCategory()->sync($categoryIds);
    }


    protected function createProductArticle(Product $product, $request)
    {
        $categoryIds = $request->get('articles', []);
        $categoryIds = Article::query()->whereIn('id', $categoryIds)->pluck('id')->toArray();
        $product->article()->sync($categoryIds);
    }

    protected function createProductTag(Product $product, $request)
    {
        DB::table('product_product_tag')->where('product_id', $product->id)->delete();
        $tag_names = $request->get('tag_names');
        $tag_names = array_values(array_filter($tag_names));
        $tagIds = [];
        if (isset($tag_names[0])) {
            foreach ($tag_names as $sort => $tag_name) {
                if ($tag_name = merge_spaces($tag_name)) {
                    $productTag = ProductTag::whereTranslation('name', $tag_name)->first();
                    if ($productTag) {
                        $productTag->name = $tag_name;
                        $productTag->save();
                    } else {
                        $productTag = ProductTag::create([
                            'url_key' => trim(config('url.product_tag') . Str::slug($tag_name, '-', config('app.locale')), '/'),
                            'sort' => 0,
                            config('app.locale') => [
                                'name' => $tag_name
                            ]
                        ]);
                    }
                    $tagIds[$productTag->id] = ['sort' => 100 - $sort];
                }
            }
            $product->productTags()->sync($tagIds);
        }

        return true;
    }


    protected function saveAttribute($product, $attributes)
    {
        $locales = config('translatable.locales');
        $submittedAttributeIds = [];

        foreach ($attributes as $product_attribute_id => $attribute) {
            $product_attribute_id = (int)$product_attribute_id;
            if ($product_attribute_id <= 0) {
                continue;
            }
            $submittedAttributeIds[] = $product_attribute_id;

            $existing = ProductAttributeValue::where([
                'product_attribute_id' => $product_attribute_id,
                'product_id' => $product->id,
            ])->get();
            foreach ($existing as $old) {
                DB::table('product_attribute_value_translations')
                    ->where('product_attribute_value_id', $old->id)
                    ->delete();
                $old->delete();
            }

            // 多选属性值：translate[attributes][id] = "A,B,C"
            if (is_string($attribute)) {
                $selectedValues = array_values(array_unique(array_filter(array_map('trim', explode(',', $attribute)), 'strlen')));
                foreach ($selectedValues as $sort => $valueName) {
                    $one = ProductAttributeValue::create([
                        'product_attribute_id' => $product_attribute_id,
                        'product_id' => $product->id,
                        'sort' => count($selectedValues) - $sort,
                    ]);
                    foreach ($locales as $locale) {
                        DB::table('product_attribute_value_translations')->insert([
                            'product_attribute_value_id' => $one->id,
                            'locale' => $locale,
                            'name' => $valueName,
                        ]);
                    }
                }
                continue;
            }

            if (!is_array($attribute)) {
                continue;
            }

            // 自由文本：translate[attributes][id][locale] = "text"
            $hasLocaleMap = false;
            foreach ($attribute as $locale => $v) {
                if (!is_numeric($locale)) {
                    $hasLocaleMap = true;
                    break;
                }
            }

            if ($hasLocaleMap) {
                $hasAnyValue = false;
                foreach ($attribute as $v) {
                    if (is_string($v) && trim($v) !== '') {
                        $hasAnyValue = true;
                        break;
                    }
                }
                if (!$hasAnyValue) {
                    continue;
                }
                $one = ProductAttributeValue::create([
                    'product_attribute_id' => $product_attribute_id,
                    'product_id' => $product->id,
                    'sort' => 0,
                ]);
                foreach ($attribute as $locale => $v) {
                    if (!is_string($locale)) {
                        continue;
                    }
                    DB::table('product_attribute_value_translations')->updateOrInsert([
                        'product_attribute_value_id' => $one->id,
                        'locale' => $locale,
                    ], [
                        'product_attribute_value_id' => $one->id,
                        'locale' => $locale,
                        'name' => is_string($v) ? $v : '',
                    ]);
                }
                continue;
            }

            // 数组多选：translate[attributes][id][] = value
            $selectedValues = array_values(array_unique(array_filter(array_map(function ($v) {
                return is_string($v) ? trim($v) : '';
            }, $attribute), 'strlen')));
            foreach ($selectedValues as $sort => $valueName) {
                $one = ProductAttributeValue::create([
                    'product_attribute_id' => $product_attribute_id,
                    'product_id' => $product->id,
                    'sort' => count($selectedValues) - $sort,
                ]);
                foreach ($locales as $locale) {
                    DB::table('product_attribute_value_translations')->insert([
                        'product_attribute_value_id' => $one->id,
                        'locale' => $locale,
                        'name' => $valueName,
                    ]);
                }
            }
        }

        $orphansQuery = ProductAttributeValue::where('product_id', $product->id);
        if (!empty($submittedAttributeIds)) {
            $orphansQuery->whereNotIn('product_attribute_id', $submittedAttributeIds);
        }
        foreach ($orphansQuery->get() as $old) {
            DB::table('product_attribute_value_translations')
                ->where('product_attribute_value_id', $old->id)
                ->delete();
            $old->delete();
        }
    }

    /**
     * 自定义 url：为空则按产品名生成；有值则规范化（保留 product/ 路径段）。
     * 新增/编辑均走此逻辑；编辑时表单回显已有 url，避免因空值被重新生成。
     */
    protected function resolveProductUrlKey($raw, string $name, bool $isCreate): string
    {
        $key = trim((string)$raw);
        $key = str_replace('\\', '/', $key);
        $key = trim($key, '/');
        $prefix = trim((string)config('url.product'), '/');
        $lang = config('app.locale') ?: 'en';

        if ($key === '') {
            $slug = Str::slug(trim($name), '-', $lang);
            if ($slug === '') {
                $slug = 'product-' . time();
            }
            return $prefix !== '' ? ($prefix . '/' . $slug) : $slug;
        }

        $parts = array_values(array_filter(explode('/', $key), static fn ($p) => $p !== ''));
        $parts = array_map(static fn ($p) => Str::slug($p, '-', $lang), $parts);
        $parts = array_values(array_filter($parts, static fn ($p) => $p !== ''));
        $key = implode('/', $parts);

        if ($key === '') {
            $slug = Str::slug(trim($name), '-', $lang);
            if ($slug === '') {
                $slug = 'product-' . time();
            }
            return $prefix !== '' ? ($prefix . '/' . $slug) : $slug;
        }

        return $key;
    }
}
