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
use App\Modules\Product\Models\ProductScheduledPublish;
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

class ProductDraftController extends BaseController
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
        $this->viewPath = 'Product.Views.draft';
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
                Product::query()->with(['translations:name,product_id,locale', 'admin', 'productImages', 'productBrand', 'scheduledPublish']),
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
                    $query->where('active', 0)->where('is_draft', 1);
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

        $resolvedUrlKey = null;
        if ($request->exists('url_key')) {
            $rawUrlKey = trim((string)$request->input('url_key'));
            $resolvedUrlKey = $this->resolveProductUrlKey($rawUrlKey, $name, false);
            if ($rawUrlKey !== '') {
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
            $update['active'] = 1;
            $update['is_draft'] = 0;
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
     * 设置定时发布
     */
    public function setSchedule(Request $request, $id)
    {
        try {
            $product = Product::with(['translations', 'productImages', 'productCategory'])->findOrFail($id);

            // 验证产品是否为草稿
            if ($product->is_draft != 1 || $product->active != 0) {
                return response()->json([
                    'code' => 1,
                    'msg' => '只能为草稿产品设置定时发布'
                ]);
            }

            // 验证发布时间
            $publishAt = $request->input('publish_at');
            if (empty($publishAt)) {
                return response()->json([
                    'code' => 1,
                    'msg' => '请选择发布时间',
                    'errors' => []
                ]);
            }

            // 验证时间格式和是否晚于当前时间
            try {
                $publishTime = \Carbon\Carbon::parse($publishAt);
                if ($publishTime->lte(now())) {
                    return response()->json([
                        'code' => 1,
                        'msg' => '发布时间必须晚于当前时间',
                        'errors' => []
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'code' => 1,
                    'msg' => '日期格式不正确，格式应为：2026-02-06 15:30:00',
                    'errors' => []
                ]);
            }

            // 验证产品必填字段
            $validationErrors = $this->validateProductRequiredFields($product);
            if (!empty($validationErrors)) {
                return response()->json([
                    'code' => 1,
                    'msg' => '产品信息不完整，请先完善以下必填项：' . implode(', ', $validationErrors),
                    'errors' => $validationErrors
                ]);
            }

            // 创建或更新定时发布记录
            ProductScheduledPublish::updateOrCreate(
                ['product_id' => $id],
                ['publish_at' => $publishTime]
            );

            return response()->json([
                'code' => 0,
                'msg' => '设置成功'
            ]);
        } catch (\Exception $e) {
            Log::error('设置定时发布失败: ' . $e->getMessage());
            return response()->json([
                'code' => 1,
                'msg' => '设置失败：' . $e->getMessage()
            ]);
        }
    }

    /**
     * 验证产品必填字段
     */
    protected function validateProductRequiredFields($product)
    {
        $errors = [];
        $locale = config('app.locale');

        // 1. 验证排序
        if (empty($product->sort) && $product->sort !== 0) {
            $errors[] = '产品排序';
        }

        // 2. 验证分类
        if ($product->productCategory->isEmpty()) {
            $errors[] = '产品分类';
        }

        // 3. 验证产品名（翻译字段）
        $translation = $product->translations->firstWhere('locale', $locale);
        if (!$translation || empty($translation->name)) {
            $errors[] = '产品名称';
        }

        // 4. 验证主图
        $hasMainImage = $product->productImages->contains('is_main', 1);
        if (!$hasMainImage) {
            $errors[] = '产品主图';
        }

        // 5. 验证详情内容（翻译字段）
        if (!$translation || empty($translation->content)) {
            $errors[] = '产品详情内容';
        }

        return $errors;
    }

    /**
     * 删除定时发布
     */
    public function deleteSchedule(Request $request, $id)
    {
        try {
            $schedule = ProductScheduledPublish::where('product_id', $id)->first();

            if ($schedule) {
                $schedule->delete();
            }

            return response()->json([
                'code' => 0,
                'msg' => '已清除定时发布'
            ]);
        } catch (\Exception $e) {
            Log::error('删除定时发布失败: ' . $e->getMessage());
            return response()->json([
                'code' => 1,
                'msg' => '删除失败：' . $e->getMessage()
            ]);
        }
    }

    /**
     * 自定义 url：为空则按产品名生成；有值则规范化（保留 product/ 路径段）。
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
