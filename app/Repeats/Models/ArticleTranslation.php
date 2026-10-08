<?php

namespace App\Repeats\Models;

class ArticleTranslation extends \App\Modules\Article\Models\ArticleTranslation
{

    protected $fillable = ['name','content', 'title', 'keywords', 'description'];

}
