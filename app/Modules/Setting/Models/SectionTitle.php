<?php

namespace App\Modules\Setting\Models;

use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionTitle extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot;

    const MODEL_TYPE = 'section_title';

    public $translatedAttributes = ['title', 'subtitle'];

    protected $fillable = [
        'sign',
        'name',
        'sort',
        'active',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSign($query, string $sign)
    {
        return $query->where('sign', $sign);
    }
}
