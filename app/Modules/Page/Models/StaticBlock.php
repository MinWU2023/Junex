<?php

namespace App\Modules\Page\Models;

use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Translate 插件 GetDataCollection 读取顶层 $model->name。
 * name 放在主表（非翻译字段），避免翻译表缺列/空值导致拉取异常；
 * 翻译表另保留可空 name 列供云端结构校验。前台只渲染 content，不受影响。
 */
class StaticBlock extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot;

    const MODEL_TYPE = 'static_block';

    // name 不在翻译属性中：GetDataCollection 直接读主表 name
    public $translatedAttributes = ['title', 'content'];

    protected $fillable = [
        'sign',
        'name',
        'sort',
        'active',
        'remark',
        'is_translate',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $model) {
            $sign = trim((string)($model->getAttributes()['sign'] ?? ''));
            $name = trim((string)($model->getAttributes()['name'] ?? ''));
            if ($name === '' && $sign !== '') {
                $model->setAttribute('name', mb_substr($sign, 0, 255));
            }
        });
    }

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
