<?php

namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticBlockTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    // 与 BannerTranslation 对齐：含外键/locale/name
    protected $fillable = [
        'static_block_id',
        'locale',
        'name',
        'title',
        'content',
    ];
}
