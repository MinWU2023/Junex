<?php

namespace App\Modules\Setting\Models;

use App\Modules\Blog\Models\Blog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcitingUpdate extends Model
{
    use HasFactory;

    protected $table = 'exciting_updates';

    protected $fillable = [
        'blog_id',
        'sort',
        'active',
        // legacy columns kept for BC, no longer edited in admin
        'path',
        'button_url',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
