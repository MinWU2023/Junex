<?php

namespace App\Modules\Setting\Models;

use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeProductCategory extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot;

    const MODEL_TYPE = 'home_product_category';

    public $translatedAttributes = ['title', 'description', 'button_text', 'alt'];

    protected $fillable = [
        'path',
        'button_url',
        'sort',
        'active',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
