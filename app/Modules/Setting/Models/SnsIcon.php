<?php

namespace App\Modules\Setting\Models;

use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnsIcon extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot;

    const MODEL_TYPE = 'sns_icon';

    public $translatedAttributes = ['alt'];

    protected $fillable = [
        'sign',
        'path',
        'link',
        'sort',
        'active',
        'link_active',
        'share_active',
    ];

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->where('link_active', 1)->orWhere('share_active', 1);
        });
    }

    public function scopeLinkActive($query)
    {
        return $query->where('link_active', 1);
    }

    public function scopeShareActive($query)
    {
        return $query->where('share_active', 1);
    }
}
