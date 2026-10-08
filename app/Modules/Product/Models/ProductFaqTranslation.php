<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFaqTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'subject',
        'content',
    ];
}
