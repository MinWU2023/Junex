<?php

namespace App\Modules\Article\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id', 'name', 'path', 'sort'
    ];
}
