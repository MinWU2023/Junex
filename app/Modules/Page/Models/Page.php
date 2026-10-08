<?php

namespace App\Modules\Page\Models;

use App\Http\Controllers\PageController;
use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory, Translatable, HasUrl,ModelBoot;

    const MODEL_TYPE = 'page';

    public $translatedAttributes = ['name', 'brief_content', 'content', 'title', 'keywords', 'description'];

    protected $fillable = [

        'parent_id','is_temp', 'sort', 'img_alt', 'url_key', 'schema', 'img_path', 'active','is_translate','updated_at'
    ];

    public function getUrlOptions(): UrlOptions
    {
        $controller = config('app.pageController');
        if (!$controller) {
            $controller = PageController::class;
        }

        return UrlOptions::instance()
            ->routeUrlTo($controller, 'show')
            ->generateUrlSlugFrom('url_key')
            ->saveUrlSlugTo('url_key');
    }

    public function setUrlKeyAttribute($value)
    {
        return $this->attributes['url_key'] = trim($value,'/');
    }


    public function children()
    {
        return $this->hasMany($this, 'parent_id', 'id')->active()->orderByDesc('sort');
    }

    public function pageFiles()
    {
        return $this->hasMany(PageFile::class)->orderByDesc('sort');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->where('is_temp',0);
    }

    public function scopeUnactive($query)
    {
        return $query->where('active', 0);
    }

    public function staticBlocks()
    {
        return $this->belongsToMany(
            StaticBlock::class,
            'static_block_page',
            'page_id',
            'static_block_id'
        )->withTimestamps();
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
