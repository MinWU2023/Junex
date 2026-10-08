<?php

namespace App\Modules\Page\Models;

use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticBlock extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot;

    const MODEL_TYPE = 'static_block';

    public $translatedAttributes = ['title', 'content'];

    protected $fillable = [
        'sign',
        'sort',
        'active',
        'remark',
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
