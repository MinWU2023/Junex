<?php

namespace App\Modules\Setting\Models;

use App\Traits\EnsuresTranslateName;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandSolution extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot, EnsuresTranslateName;

    const MODEL_TYPE = 'brand_solution';

    public $translatedAttributes = ['name', 'title', 'description', 'button_text', 'features'];

    protected $fillable = [
        'path',
        'button_url',
        'sort',
        'active',
        'is_translate',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
