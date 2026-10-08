<?php

namespace App\Modules\Product\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductFaq extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = [
        'subject',
        'content',
    ];

    protected $fillable = [
        'sort',
        'source_faq_id',
        'active',
    ];

    protected $casts = [
        'sort' => 'integer',
        'source_faq_id' => 'integer',
        'active' => 'integer',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_faq_product')
            ->withPivot('sort')
            ->withTimestamps()
            ->orderByPivot('sort', 'desc');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'product_faq_product_category')
            ->withPivot('sort')
            ->withTimestamps()
            ->orderByPivot('sort', 'desc');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
