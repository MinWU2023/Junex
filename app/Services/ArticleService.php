<?php


namespace App\Services;


use App\Modules\Article\Models\Article;
use App\Modules\Page\Models\Page;

class ArticleService
{
    public function getArticles($limit = 8)
    {
        return Article::with(['translations'])->active()->orderByDesc('sort')->limit($limit);
    }
}
