<?php

namespace App\Modules\Product\Models;

use Addons\Keywords\Models\ProductTagRank;
use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductTag extends Model implements TranslatableContract
{
    use HasFactory, Translatable, HasUrl,ModelBoot;

    const MODEL_TYPE = 'product_tag';

    public $translatedAttributes = ['name','title', 'keywords', 'description'];

    protected $fillable = ['sort', 'url_key','check_date','is_translate'];

    protected $appends = ['product_count'];

    public function getProductCountAttribute(){
        return Product::query()->whereIn('id',DB::table('product_product_tag')->where('product_tag_id',$this->getKey())->pluck('product_id')->toArray())->count();
    }

    public function productRanks()
    {
        return $this->hasMany(ProductTagRank::class);
    }


    public function setUrlKeyAttribute($value)
    {
        return $this->attributes['url_key'] = trim($value,'/');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
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


    /**
     * Get the options for generating the url.
     *
     * @return UrlOptions
     */
    public function getUrlOptions(): UrlOptions
    {
        $controller = config('app.productController') ?: \App\Http\Controllers\ProductController::class;
        return UrlOptions::instance()
            ->routeUrlTo($controller, 'tag')
            ->generateUrlSlugFrom('url_key')
            ->saveUrlSlugTo('url_key');
    }


}
