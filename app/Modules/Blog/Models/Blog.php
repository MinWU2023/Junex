<?php

namespace App\Modules\Blog\Models;

use App\Modules\Admin\Models\User;
use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Traits\ModelBoot;
use App\Traits\Time;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model implements TranslatableContract
{
    use HasFactory, Translatable,HasUrl,ModelBoot,Time;

    const MODEL_TYPE = 'blog';

    public $translatedAttributes = ['name', 'content', 'title', 'keywords', 'description'];

    protected $fillable = ['blog_category_id','is_temp','admin_user_id', 'sort', 'path', 'active', 'url_key','customer_at','is_translate','is_draft'];


    public function setUrlKeyAttribute($value)
    {
        return $this->attributes['url_key'] = trim($value,'/');
    }

    public function admin(){
        return $this->belongsTo(User::class,'admin_user_id','id');
    }

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function blogFiles()
    {
        return $this->hasMany(BlogFile::class);
    }

    public function blogTags()
    {
        return $this->belongsToMany(BlogTag::class)->withTimestamps();
    }

    public function getUrlOptions(): UrlOptions
    {
        $controller = config('app.blogController') ?: \App\Http\Controllers\BlogController::class;
        return UrlOptions::instance()
            ->routeUrlTo($controller, 'show')
            ->generateUrlSlugFrom('url_key')
            ->saveUrlSlugTo('url_key');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->where('is_temp',0);
    }

    public function scopeUnactive($query)
    {
        return $query->where('active', 0);
    }

    protected function isTranslationDirty(Model $translation): bool
    {
        $dirtyAttributes = $translation->getDirty();
        unset($dirtyAttributes[$this->getLocaleKey()]);
        $bol = false;
        foreach($translation->getFillable() as $key => $value) {
            if ($translation->$value) {
                $bol = true;
                break;
            }
        }
        return count($dirtyAttributes) > 0 && $bol;
    }

    public function scheduledPublish()
    {
        return $this->hasOne(BlogScheduledPublish::class, 'blog_id');
    }

}
