<?php

namespace App\Repeats\Models;

class Article extends \App\Modules\Article\Models\Article
{

    public function getMorphClass()
    {
        return "App\Modules\Article\Models\Article";
    }

    public $translatedAttributes = ['name', 'content', 'title', 'keywords', 'description'];

    //请在该处添加白名单
    protected $fillable = ['article_category_id', 'sort', 'path', 'active', 'is_menu', 'is_show', 'url_key','add_date','customer_at'];


}
