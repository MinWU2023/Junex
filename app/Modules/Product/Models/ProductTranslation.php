<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;


    protected $fillable = ['name', 'brief_content', 'm_content','content',
        'content_1',
        'content_2','content_3','content_4','content_5','content_6','content_7','content_8',
        'content_9','content_10',
        'product_details', 'attribute', 'title', 'keywords', 'description'];

}
