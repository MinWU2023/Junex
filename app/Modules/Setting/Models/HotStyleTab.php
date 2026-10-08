<?php

namespace App\Modules\Setting\Models;

use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotStyleTab extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot;

    const MODEL_TYPE = 'hot_style_tab';

    const SOURCE_TYPES = [
        'flag' => '标记来源(新品/热销/推荐)',
        'category' => '产品分类+指定产品',
    ];

    const PRODUCT_SOURCES = [
        'new' => '新品(is_new)',
        'hot' => '热销(is_hot)',
        'recommend' => '推荐(is_recommend)',
    ];

    public $translatedAttributes = ['label'];

    protected $fillable = [
        'tab_key',
        'source_type',
        'product_source',
        'product_category_id',
        'sort',
        'active',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'hot_style_tab_product', 'hot_style_tab_id', 'product_id')
            ->withPivot(['sort'])
            ->withTimestamps()
            ->orderByDesc('hot_style_tab_product.sort')
            ->orderByDesc('products.id');
    }

    public function isCategoryMode(): bool
    {
        return (string)$this->source_type === 'category';
    }
}
