<?php

namespace App\Modules\Product\Models;

use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Modules\Product\Models\Product;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVideo extends Model implements TranslatableContract
{
    use HasFactory, Translatable, HasUrl, ModelBoot;

    const MODEL_TYPE = 'product_video';

    public $translatedAttributes = ['name', 'content', 'content2', 'title', 'keywords', 'description'];

    protected $fillable = [
        'product_video_category_id',
        'path',
        'video_url',
        'url_key',
        'sort',
        'is_recommend',
        'active',
    ];

    public function getUrlOptions(): UrlOptions
    {
        $controller = config('app.productVideoController') ?: \App\Http\Controllers\VideoController::class;
        return UrlOptions::instance()
            ->routeUrlTo($controller, 'show')
            ->generateUrlSlugFrom('url_key')
            ->saveUrlSlugTo('url_key');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(ProductVideoCategory::class, 'product_video_category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_video_product');
    }
}
