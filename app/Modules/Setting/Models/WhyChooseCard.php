<?php

namespace App\Modules\Setting\Models;

use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChooseCard extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot;

    const MODEL_TYPE = 'why_choose_card';

    public $translatedAttributes = ['label', 'value', 'value_suffix', 'description'];

    protected $fillable = [
        'image_mobile',
        'background_desktop',
        'url',
        'sort',
        'active',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
