<?php
namespace App\Modules\Blog\Models;

use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model implements TranslatableContract
{
    use HasFactory,Translatable,HasUrl,ModelBoot;

    const MODEL_TYPE = 'blog_tag';

    public $translatedAttributes = ['name'];

    protected $fillable = ['sort','url_key','is_translate'];


    public function blogs(){
        return $this->belongsToMany(Blog::class)->active();
    }

    public function setUrlKeyAttribute($value)
    {
        return $this->attributes['url_key'] = trim($value,'/');
    }

    public function getUrlOptions(): UrlOptions
    {
        $controller = config('app.blogController') ?: \App\Http\Controllers\BlogController::class;
        return tap(UrlOptions::instance())
            ->routeUrlTo($controller, 'tag')
            ->generateUrlSlugFrom('url_key')
            ->saveUrlSlugTo('url_key');
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
