<?php

namespace App\Repeats\Models;

class Product extends \App\Modules\Product\Models\Product
{

    public function getMorphClass()
    {
        return "App\Modules\Product\Models\Product";
    }


    public $translatedAttributes = ['name', 'brief_content', 'content', 'm_content', 'product_details', 'attribute', 'title', 'keywords', 'description'];

    protected $fillable = [
        'product_brand_id', 'sort', 'url_key', 'img_alt', 'active', 'is_new', 'is_hot',
        'is_recommend','admin_user_id','add_date', 'updated_at','attribute_category_id'
    ];

}
