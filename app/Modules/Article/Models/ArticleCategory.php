<?php

namespace App\Modules\Article\Models;

use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model implements TranslatableContract
{
    use HasFactory, Translatable, HasUrl,ModelBoot;

    const MODEL_TYPE = 'article_category';

    public $translatedAttributes = ['name', 'content', 'title', 'keywords', 'description'];

    protected $fillable = ['parent_id', 'sort', 'path', 'url_key','is_translate'];

    public function getUrlOptions(): UrlOptions
    {
        $controller = config('app.newsController');
        if (!$controller) {
            $controller = \App\Modules\Article\Controllers\ArticleController::class;
        }

        return UrlOptions::instance()
            ->routeUrlTo($controller, 'category')
            ->generateUrlSlugFrom('url_key')
            ->saveUrlSlugTo('url_key');
    }

    public function setUrlKeyAttribute($value)
    {
        return $this->attributes['url_key'] = trim($value,'/');
    }


    public function children()
    {
        return $this->hasMany($this, 'parent_id', 'id');
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

}
