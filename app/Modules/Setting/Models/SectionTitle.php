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

    // name 仅在主表（后台板块标识），不进翻译属性，避免覆盖主表 name 导致前后台异常。
    // 翻译表仍保留可空 name 列，满足云端 Translate 插件表结构要求。
    public $translatedAttributes = ['title', 'subtitle'];

    protected $fillable = [
        'sign',
        'name',
        'sort',
        'active',
        'is_translate',
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
