<?php

namespace App\Modules\Setting\Models;

use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomService extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot;

    const MODEL_TYPE = 'custom_service';

    public $translatedAttributes = ['title_prefix', 'title_suffix', 'subtitle'];

    protected $fillable = [
        'code',
        'bg_image',
        'layout',
        'sort',
        'active',
    ];

    public function items()
    {
        return $this->hasMany(CustomServiceItem::class)->orderByDesc('sort')->orderBy('id');
    }

    public function activeItems()
    {
        return $this->hasMany(CustomServiceItem::class)
            ->where('active', 1)
            ->orderByDesc('sort')
            ->orderBy('id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
