<?php

namespace App\Modules\Setting\Models;

use App\Modules\Blog\Models\Blog;
use App\Traits\EnsuresTranslateName;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcitingUpdate extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot, EnsuresTranslateName;

    const MODEL_TYPE = 'exciting_update';

    protected $table = 'exciting_updates';

    public $translatedAttributes = ['name', 'title', 'button_text', 'alt'];

    protected $fillable = [
        'blog_id',
        'sort',
        'active',
        'is_translate',
        // legacy columns kept for BC, no longer edited in admin
        'path',
        'button_url',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        // 前台内容来自 Blog；同步 name 供 Translate 插件拉取展示
        static::saved(function (self $model) {
            $model->syncTranslateNameFromBlog();
        });
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function syncTranslateNameFromBlog(): void
    {
        if (!$this->blog_id) {
            return;
        }

        $blog = $this->relationLoaded('blog') ? $this->blog : $this->blog()->with('translations')->first();
        if (!$blog) {
            return;
        }

        $locale = (string)(config('translatable.locale') ?: config('app.locale') ?: 'en');
        $blogName = '';
        try {
            $blogName = function_exists('translated_attr')
                ? translated_attr($blog, 'name', $locale)
                : (string)($blog->name ?? '');
        } catch (\Throwable $e) {
            $blogName = (string)($blog->name ?? '');
        }
        $blogName = mb_substr(trim(strip_tags($blogName)), 0, 255);
        if ($blogName === '') {
            return;
        }

        $existing = $this->translations()->where('locale', $locale)->first();
        if ($existing && (string)$existing->name === $blogName) {
            return;
        }

        $this->translations()->updateOrCreate(
            ['locale' => $locale],
            ['name' => $blogName]
        );
    }
}
