<?php

namespace App\Modules\Download\Models;


use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadCategory extends Model implements TranslatableContract
{
    use HasFactory,Translatable,HasUrl,ModelBoot;

    const MODEL_TYPE = 'download_category';

    public $translatedAttributes = ['name','title','keywords','description'];

    public $fillable = ['sort','img','url_key','parent_id','is_translate'];

    public function getUrlOptions(): UrlOptions
    {
        $controller = config('app.downloadController');
        if (!$controller) {
            $controller = \App\Modules\Download\Controllers\DownloadController::class;
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

    public function downloads(){
        return $this->hasMany(Download::class,'download_category_id','id');
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
