<?php

namespace App\Repeats\Models;

class ProductTranslation extends \App\Modules\Product\Models\ProductTranslation
{

    protected $fillable = ['name', 'brief_content', 'm_content','content', 'product_details', 'attribute', 'title', 'keywords', 'description'];

}
