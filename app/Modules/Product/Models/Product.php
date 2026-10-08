<?php

namespace App\Modules\Product\Models;

use App\Modules\Admin\Models\User;
use App\Modules\Article\Models\Article;
use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Traits\ModelBoot;
use App\Traits\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;


class Product extends Model implements TranslatableContract
{
    use HasFactory, Translatable, HasUrl,Time,ModelBoot;

    const MODEL_TYPE = 'product';

//    public $translatedAttributes = ['name' ];

    public $translatedAttributes = ['name', 'brief_content', 'content',
        'content_1',
        'content_2','content_3','content_4','content_5','content_6','content_7','content_8',
        'content_9','content_10',
        'm_content', 'product_details', 'attribute', 'title', 'keywords', 'description'];

    protected $fillable = [
        'product_brand_id', 'sort', 'url_key', 'img_alt', 'active', 'is_new', 'is_hot',
        'is_recommend','is_temp','admin_user_id','add_date', 'updated_at','attribute_category_id',
        'video','is_translate','backup_tags','is_draft'
    ];

    public $appends = ['category_name','art_no'];


    public function getArtNoAttribute(){}

    public function setUrlKeyAttribute($value)
    {
        return $this->attributes['url_key'] = trim($value,'/');
    }


    public function admin(){
        return $this->belongsTo(User::class,'admin_user_id','id');
    }

    public function getCategoryNameAttribute(){
      $res=  DB::table('product_product_category')->where('product_id',$this->getKey())->first();
      if ($res){
//          DB::table('product_category_translations')->where([
//              'locale'
//          ])

         $cate =  ProductCategory::query()->with(['translations'])->find($res->product_category_id);
        return $cate->name;
      }
      return  "";
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class)->orderByDesc('is_main')->orderByDesc('sort');
    }

    public function productMainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', 1);
    }

    public function productFiles()
    {
        return $this->hasMany(ProductFile::class);
    }

    public function productCategory()
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    public function productCategories()
    {
        return $this->productCategory();
    }

    public function article(){
        return $this->belongsToMany(Article::class)->withTimestamps();
    }

    public function productBrand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->where('is_temp',0);
    }

    public function scopeUnactive($query)
    {
        return $query->where('active', 0);
    }

    public function attributes(){
        return $this->belongsToMany(ProductAttribute::class,'product_attribute_values');
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
            ->routeUrlTo($controller, 'show')
            ->generateUrlSlugFrom('url_key')
            ->saveUrlSlugTo('url_key');
    }

    public function productTags()
    {
        return $this->belongsToMany(ProductTag::class)->withTimestamps()->orderByPivot('sort','desc');
    }

    public function productFaqs()
    {
        return $this->belongsToMany(ProductFaq::class, 'product_faq_product')
            ->withPivot('sort')
            ->withTimestamps()
            ->orderByPivot('sort', 'desc');
    }

    public function scheduledPublish()
    {
        return $this->hasOne(ProductScheduledPublish::class, 'product_id');
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
