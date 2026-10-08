<?php

namespace App\Modules\Navigation\Models;

use App\Modules\Product\Models\ProductCategory;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory, Translatable, ModelBoot;

    const MODEL_TYPE = 'navigation';

    public const AREA_HEAD = '头部';
    public const AREA_FOOT = '底部';

    public const LINK_NORMAL = 'normal';
    public const LINK_CATEGORY = 'category';

    public $translatedAttributes = ['name'];

    protected $fillable = [
        'parent_id',
        'sort',
        'is_show',
        'is_new',
        'is_nofollow',
        'url',
        'is_translate',
        'area',
        'link_type',
    ];

    protected $casts = [
        'parent_id' => 'integer',
        'sort' => 'integer',
        'is_show' => 'integer',
        'is_new' => 'integer',
        'is_nofollow' => 'integer',
        'is_translate' => 'integer',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->orderByDesc('sort')
            ->orderBy('id');
    }

    public function visibleChildren()
    {
        return $this->children()->where('is_show', 1);
    }

    public function categories()
    {
        return $this->belongsToMany(
            ProductCategory::class,
            'navigation_product_category',
            'navigation_id',
            'product_category_id'
        )->withPivot('sort')->withTimestamps()
            ->orderByDesc('product_categories.sort')
            ->orderBy('product_categories.id');
    }

    public function scopeArea($query, string $area)
    {
        return $query->where('area', $area);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_show', 1);
    }

    public function isCategoryLink(): bool
    {
        return (string)$this->link_type === self::LINK_CATEGORY;
    }

    protected function isTranslationDirty(Model $translation): bool
    {
        $dirtyAttributes = $translation->getDirty();
        unset($dirtyAttributes[$this->getLocaleKey()]);
        $bol = false;
        foreach ($translation->getFillable() as $key => $value) {
            if ($translation->$value) {
                $bol = true;
                break;
            }
        }
        return count($dirtyAttributes) > 0 && $bol;
    }
}
