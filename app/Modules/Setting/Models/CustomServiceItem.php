<?php

namespace App\Modules\Setting\Models;

use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomServiceItem extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot;

    const MODEL_TYPE = 'custom_service_item';

    public $translatedAttributes = ['title'];

    protected $fillable = [
        'custom_service_id',
        'path',
        'url',
        'sort',
        'active',
    ];

    public function service()
    {
        return $this->belongsTo(CustomService::class, 'custom_service_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
