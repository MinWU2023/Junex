<?php

namespace App\Modules\Article\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleScheduledPublish extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'publish_at',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}


