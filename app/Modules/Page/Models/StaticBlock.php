<?php

namespace App\Modules\Page\Models;

use App\Traits\EnsuresTranslateName;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Translate 插件 getData 要求：
 * - Translatable + translations 关系
 * - 可读 name（与 Banner 一致，走翻译表 name）
 * - multilingual.static_block 含 name 字段
 */
class StaticBlock extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot, EnsuresTranslateName;

    const MODEL_TYPE = 'static_block';

    // 与 Banner 对齐：name 必须在 translatedAttributes 中，供 GetDataCollection 读取
    public $translatedAttributes = ['name', 'title', 'content'];

    protected $fillable = [
        'sign',
        'sort',
        'active',
        'remark',
        'is_translate',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function pages()
    {
        return $this->belongsToMany(
            Page::class,
            'static_block_page',
            'static_block_id',
            'page_id'
        )->withTimestamps();
    }

    public function pageKeys()
    {
        return $this->hasMany(StaticBlockPageKey::class, 'static_block_id');
    }
}
