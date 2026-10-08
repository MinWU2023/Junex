<?php

namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogScheduledPublish extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'publish_at',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}