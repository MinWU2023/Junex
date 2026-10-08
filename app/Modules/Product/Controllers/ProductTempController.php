<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Article\Models\Article;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductAttributeValue;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductFile;
use App\Modules\Product\Models\ProductImage;
use App\Modules\Product\Models\ProductTag;
use App\Modules\Url\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductTempController extends Controller
{

    public function preview($id, Request $request)
    {
        $translate = $request->get('translate');
        $product = Product::where([
            'is_temp' => 1,
            'id' => $id
        ])->first();
        is_array($translate) ? $data = array_merge($translate, $request->all()) : $data = $request->all();
        try {
            if ($product) {
                $data['product_brand_id'] = $request->get('brand_id');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $data = array_filter($data, function ($value) {
                    // 如果 value 不是 false, null, 空字符串, 数组为空或者 0，则返回 true
                    return ($value !== false && $value !== null && $value !== '' && (is_array($value) ? count($value) > 0 : true) && $value !== 0);
                });
                unset($data['url_key']);
                $product->update($data);
            } else {
                $data['is_temp'] = 1;
                $data['admin_user_id'] = auth()->user()->id;
                if (!isset($data['en']['name'])) {
                    $data['en']['name'] = '请输入产品名称';
                }
                if (!isset($data['en']['content'])) {
                    $data['en']['content'] = '请输入详情内容';
                }
                if (!isset($data['en']['brief_content'])) {
                    $data['en']['brief_content'] = '请输入详情简介';
                }
                $data['url_key'] = 'preProduct-'.rand(1, 10000);
                $product = Product::create($data);
            }
            DB::table('product_images')->where('product_id', $product->id)->delete();
            DB::table('product_files')->where('product_id', $product->id)->delete();
            $this->createProductCategory($product, $request);
            $this->createProductImage($product, $request);
            $this->createProductFile($product, $request);
            $this->createProductTag($product, $request);
            $this->createProductArticle($product, $request);
            if ($data['attribute_category_id'] == 0) {
                //清除产品关联属性
                $product->attributes()->detach();
            } else {
                if (isset($data['attributes'])) {
                    $attributes = $data['attributes'];
                    $this->saveAttribute($product, $attributes);
                }
            }
        }catch (\PDOException $exception){
            Log::error('productModel:update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->data([
            'temp_product_id' => $product->id,
            'url_key' => url($product->url_key)
        ]);
    }


//    public function save($id, Request $request)
//    {
//        $product = Product::find($id);
//        $translate = $request->get('translate');
//        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
//        try {
//            $update['product_brand_id'] = $request->get('brand_id');
//            $update['updated_at'] = date('Y-m-d H:i:s');
//            $update = array_filter($update, function ($value) {
//                // 如果 value 不是 false, null, 空字符串, 数组为空或者 0，则返回 true
//                return ($value !== false && $value !== null && $value !== '' && (is_array($value) ? count($value) > 0 : true) && $value !== 0);
//            });
//            $product->update($update);
//            DB::table('product_images')->where('product_id', $product->id)->delete();
//            DB::table('product_files')->where('product_id', $product->id)->delete();
//            $this->createProductCategory($product, $request);
//            $this->createProductImage($product, $request);
//            $this->createProductFile($product, $request);
//            $this->createProductTag($product, $request);
//            $this->createProductArticle($product, $request);
//            if ($update['attribute_category_id'] == 0) {
//                //清除产品关联属性
//                $product->attributes()->detach();
//            } else {
//                if (isset($update['attributes'])) {
//                    $attributes = $update['attributes'];
//                    $this->saveAttribute($product, $attributes);
//                }
//            }
//        } catch (\PDOException $exception) {
//            Log::error('productModel:update:更新失败，错误原因为：' . $exception->getMessage());
//            return $this->badRequest();
//        }
//        return $this->success();
//
//    }


    public function delete($id)
    {
        $is_del = false;
        $product = Product::with(['productTags', 'attributes'])->where([
            'is_temp' => 1,
            'id' => $id
        ])->first();
        if ($product) {
            $this->delTempProduct($product->id);
            $is_del = true;
        }
        $products = Product::where('is_temp', 1)->where('created_at', '<', date('Y-m-d H:i:s', strtotime("-1day")))->get();
        foreach ($products as $model) {
            $this->delTempProduct($model->id);
            $is_del = true;
        }
        if ($is_del){
            $maxId = Product::query()->max('id');
// 如果你想设置的新的起始自增ID比当前最大ID小，那么你需要确保不会产生冲突
            $newStartingId = $maxId + 1; // 你希望设置的下一个自增ID
// 执行SQL命令来修改自增ID
            DB::statement("ALTER TABLE products AUTO_INCREMENT = $newStartingId;");
        }
        return $this->success();
    }

    protected function delTempProduct($product_id)
    {
        DB::table('product_attribute_values')->where('product_id', $product_id)->delete();
        DB::table('product_product_tag')->where('product_id',$product_id)->delete();
        DB::table('product_attribute_values')->where('product_id',$product_id)->delete();
        Product::where('id',$product_id)->delete();
        Url::withTrashed()->where([
            'urlable_type' => 'App\Modules\Product\Models\Product',
            'urlable_id' => $product_id
        ])->forceDelete();

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


    protected function createProductTag(Product $product, $request)
    {
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
                            'url_key' => Str::slug($tag_name, '-', config('app.locale')),
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


    protected function createProductArticle(Product $product, $request)
    {
        $categoryIds = $request->get('articles', []);
        $categoryIds = Article::query()->whereIn('id', $categoryIds)->pluck('id')->toArray();
        $product->article()->sync($categoryIds);
    }


    protected function createProductCategory(Product $product, $request)
    {
        $categoryIds = $request->get('categories', []);
        $categoryIds = ProductCategory::query()->whereIn('id', $categoryIds)->pluck('id')->toArray();
        if (!$categoryIds) {
            $categoryIds = [ProductCategory::query()->latest()->first()->id];
        }
        $product->productCategory()->sync($categoryIds);
    }


    protected function createProductFile(Product $product, $request)
    {
        if ($filePaths = $request->get('filePath')) {
            $sorts = $request->get('fileSorts');
            $names = $request->get('fileNames');
            foreach ($filePaths as $key => $imgPath) {
                if (isset($names[$key])){
                    $add = [];
                    $add['product_id'] = $product->id;
                    $add['path'] = $imgPath;
                    $add['name'] = $names[$key];
                    $add['sort'] = isset($sorts[$key])?$sorts[$key]:0;
                    ProductFile::create($add);
                }
            }
        }
    }


    protected function createProductImage(Product $product, $request)
    {
        $imgPaths = $request->get('imgPath');
        if ($imgPaths) {
            $sorts = $request->get('imgSorts');
            $alts = $request->get('imgAlts');

            foreach ($imgPaths as $key => $imgPath) {
                $add = [];
                $add['product_id'] = $product->id;
                $add['path'] = $imgPath;
                if ($request->get('is_main')){
                    $add['is_main'] = $request->get('is_main') === $imgPath;
                }else{
                    if ($key == 0){
                        $add['is_main'] = 1;
                    }
                }
                $add['sort'] = isset($sorts[$key]) ? $sorts[$key] : 0;
                $add['alt'] = isset($alts[$key]) ? $alts[$key] : '';
                ProductImage::create($add);
            }
        } else {
            ProductImage::create([
                'product_id' => $product->id,
                'path' => 'images/default_main.jpg',
                'is_main' => 1,
                'sort' => 999,
                'alt' => $product->name
            ]);
            ProductImage::create([
                'product_id' => $product->id,
                'path' => 'images/default_sub.jpg',
                'is_main' => 0,
                'sort' => 9,
                'alt' => $product->name
            ]);
            ProductImage::create([
                'product_id' => $product->id,
                'path' => 'images/default_sub.jpg',
                'is_main' => 0,
                'sort' => 8,
                'alt' => $product->name
            ]);
            ProductImage::create([
                'product_id' => $product->id,
                'path' => 'images/default_sub.jpg',
                'is_main' => 0,
                'sort' => 8,
                'alt' => $product->name
            ]);
            ProductImage::create([
                'product_id' => $product->id,
                'path' => 'images/default_sub.jpg',
                'is_main' => 0,
                'sort' => 8,
                'alt' => $product->name
            ]);
        }
    }


    public function existCategory()
    {
        return ProductCategory::query()->exists();
    }

}
