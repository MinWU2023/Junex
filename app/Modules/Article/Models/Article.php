<?php

namespace App\Modules\Article\Models;


use App\Modules\Admin\Models\User;
use App\Modules\Product\Models\Product;
use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model implements TranslatableContract
{
    use HasFactory, Translatable, HasUrl,ModelBoot;

    const MODEL_TYPE = 'article';

    public $translatedAttributes = ['name', 'content', 'title', 'keywords', 'description'];

    protected $fillable = ['article_category_id','is_temp','admin_user_id','sort', 'path', 'active', 'is_menu', 'is_show', 'url_key','add_date','customer_at','is_translate','is_draft'];

    public function admin(){
        return $this->belongsTo(User::class,'admin_user_id','id');
    }


    public function setUrlKeyAttribute($value)
    {
        return $this->attributes['url_key'] = trim($value,'/');
    }

    public function articleCategory()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->where('is_temp',0);
    }
    public function scopeUnactive($query)
    {
        return $query->where('active', 0);
    }

    public function getUrlOptions(): UrlOptions
    {
        $controller = config('app.newsController');
        if (!$controller) {
            $controller = \App\Modules\Article\Controllers\ArticleController::class;
        }

        return UrlOptions::instance()
            ->routeUrlTo($controller, 'show')
            ->generateUrlSlugFrom('url_key')
            ->saveUrlSlugTo('url_key');
    }

    public function articleFiles()
    {
        return $this->hasMany(ArticleFile::class);
    }

    public function getCreatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
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


    public function product(){
        return $this->belongsToMany(Product::class)->active();
    }

    public function scheduledPublish()
    {
        return $this->hasOne(ArticleScheduledPublish::class, 'article_id');
    }



}
