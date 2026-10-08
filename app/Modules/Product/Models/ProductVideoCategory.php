<?php

namespace App\Modules\Product\Models;

use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVideoCategory extends Model implements TranslatableContract
{
    use HasFactory, Translatable, HasUrl, ModelBoot;

    const MODEL_TYPE = 'product_video_category';

    public $translatedAttributes = ['name', 'content', 'content2', 'title', 'keywords', 'description'];

    protected $fillable = ['sort', 'active', 'path', 'url_key'];

    public function getUrlOptions(): UrlOptions
    {
        $controller = config('app.productVideoController') ?: \App\Http\Controllers\VideoController::class;
        return UrlOptions::instance()
            ->routeUrlTo($controller, 'category')
            ->generateUrlSlugFrom('url_key')
            ->saveUrlSlugTo('url_key');
    }

    public function videos()
    {
        return $this->hasMany(ProductVideo::class, 'product_video_category_id');
    }
}
