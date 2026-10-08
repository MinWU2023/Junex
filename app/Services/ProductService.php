<?php

namespace App\Services;

use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductAttribute;
use App\Modules\Product\Models\ProductAttributeCategory;
use App\Modules\Product\Models\ProductAttributeValue;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductTag;

class ProductService
{
    public function getMenuCategory($limit = 8)
    {
        return ProductCategory::with([
            'translations',
            'children' => function ($query) {
                $query->with(['translations'])->where('is_menu', 1);
            }
        ])->where('is_menu', 1)
            ->where('parent_id', 0)
            ->orderByDesc('sort')
            ->limit($limit)
            ->get();
    }

    public function getAttributes($product)
    {
        if ($product->attribute_category_id) {
            $attribute_category = ProductAttributeCategory::with([
                'attributes' => function ($query) {
                    $query->orderByDesc('sort')->with(['translations']);
                }
            ])->find($product->attribute_category_id);
            $productAttributes = $attribute_category ? $attribute_category->attributes : collect();
        } else {
            $productAttributes = ProductAttribute::orderBy('sort', 'desc')->with(['translations'])->get();
        }
        $productAttributeValues = ProductAttributeValue::with(['translations'])->where([
            'product_id' => $product->id
        ])->orderByDesc('sort')->orderBy('id')->get();

        $locale = app()->getLocale();
        $res = [];
        foreach ($productAttributes as $productAttribute) {
            $values = [];
            foreach ($productAttributeValues as $productAttributeValue) {
                if ((int)$productAttributeValue->product_attribute_id !== (int)$productAttribute->id) {
                    continue;
                }
                $name = $productAttributeValue->translate($locale)->name
                    ?? $productAttributeValue->name
                    ?? '';
                $name = trim((string)$name);
                if ($name !== '' && !in_array($name, $values, true)) {
                    $values[] = $name;
                }
            }
            if (!empty($values)) {
                // 同一属性名下多个属性值用逗号连接
                $res[$productAttribute->name] = implode(', ', $values);
            }
        }
        return $res;
    }

    public function getRelatedProducts(Product $product, $limit = 6)
    {
        return Product::with([
            'translation',
            'productImages' => function ($query) {
                $query->where('is_main', 1);
            }
        ])->whereHas('productCategory', function ($query) use ($product) {
            $query->where('product_category_id', $product->product_category_id);
        })->active()
            ->orderByDesc('sort')->limit($limit)->get();
    }

    public function getHotCategory($limit = 6)
    {
        return ProductCategory::with([
            'translations',
            'products' => function ($query) {
                $query->with(['translations', 'productMainImage']);
                $query->where('is_hot', 1);
            }
        ])->where('is_show', 1)->orderByDesc('sort')->limit($limit)->get();
    }

    public function getHotTags($limit = 6)
    {
        $limit = (int)$limit;
        if ($limit <= 0) {
            $limit = 6;
        }

        return ProductTag::with(['translations', 'url'])
            ->where('is_hot', 1)
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    public function getHotProducts($limit = 8)
    {
        return Product::with(['translations', 'productMainImage'])
            ->active()
            ->where('is_hot', 1)
            ->orderByDesc('sort')
            ->limit($limit)
            ->get();
    }

    public function getNewProducts($limit = 8)
    {
        return Product::with(['translations', 'productMainImage'])
            ->active()
            ->where('is_new', 1)
            ->orderByDesc('sort')
            ->limit($limit)
            ->get();
    }

    public function getRecommendProducts($limit = 8)
    {
        return Product::with(['translations', 'productMainImage'])
            ->active()
            ->where('is_recommend', 1)
            ->orderByDesc('sort')
            ->limit($limit)
            ->get();
    }

    public function getProductAttribute(Product $product)
    {
        $ProductAttributes = ProductAttribute::with(['translations'])->orderBy('sort', 'desc')->get();
        $result = [];
        foreach ($ProductAttributes as $key => $value) {
            $attributes = json_decode($product->attribute, true) ?: json_decode($product->translate('en')->attribute,
                true);
            if (!$attributes) {
                $result[$value->name] = '';
            } else {
                foreach ($attributes as $k => $attribute) {
                    if ($value->mark === $k) {
                        $result[$value->name] = $attribute;
                    }
                }
            }
        }
        return $result;
    }

    public function getPrevProduct(Product $product)
    {
        return Product::with(['translations'])->where('id', '<', $product->id)->first();
    }

    public function getNextProduct(Product $product)
    {
        return Product::with(['translations'])->where('id', '>', $product->id)->first();
    }
}
