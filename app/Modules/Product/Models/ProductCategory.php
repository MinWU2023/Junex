<?php


namespace App\Modules\Product\Models;


use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Model implements TranslatableContract
{
    use HasFactory, Translatable, HasUrl,ModelBoot ;

    const MODEL_TYPE = 'product_category';

    public $translatedAttributes = ['name', 'content', 'content2', 'page_block', 'title', 'keywords', 'description'];

    protected $fillable = ['parent_id', 'sort', 'is_show', 'is_menu', 'display_mode',
        'path', 'url_key','logo', 'admin_user_id','is_translate'
    ];

    /** 侧栏 + 右侧产品列表 */
    public const DISPLAY_PRODUCT_LIST = 'product_list';

    /** 分类标题 + 产品区块（无侧栏） */
    public const DISPLAY_CATEGORY_PRODUCT = 'category_product';

    public static function displayModeOptions(): array
    {
        return [
            self::DISPLAY_PRODUCT_LIST => '产品列表形式',
            self::DISPLAY_CATEGORY_PRODUCT => '分类&产品形式',
        ];
    }

    public function getUrlOptions(): UrlOptions
    {
        $controller = config('app.productController') ?: \App\Http\Controllers\ProductController::class;
        return UrlOptions::instance()
            ->routeUrlTo($controller, 'category')
            ->generateUrlSlugFrom('url_key')
            ->saveUrlSlugTo('url_key');
    }

    protected $appends = ['product_count'];



    public function setUrlKeyAttribute($value)
    {
        return $this->attributes['url_key'] = trim($value,'/');
    }

    private static function getChildrenProduct($id,&$product_ids){
        $product_ids = array_merge(DB::table('product_product_category')->where('product_category_id',$id)->pluck('product_id')->toArray(),$product_ids); //当前分类底下产品
        $children_category_ids = DB::table('product_categories')->where('parent_id',$id)->select(['id'])->pluck('id')->toArray(); //获取二级分类和对应子产品
        if (isset($children_category_ids[0])){
            foreach ($children_category_ids as $children_category_id){
                self::getChildrenProduct($children_category_id,$product_ids);
            }
        }

    }


    public function getProductCountAttribute($value){
        $id = $this->id;
        $product_ids = [];
        self::getChildrenProduct($id,$product_ids);
        return  Product::query()->whereIn('id',$product_ids)->active()->count();
    }

    public function children()
    {
        return $this->hasMany($this, 'parent_id', 'id')
            ->orderByDesc('sort')
            ->orderBy('id');
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id', 'id');
    }

    /**
     * 向上追溯到最上层一级分类（parent_id = 0）；自身已是一级则返回自身。
     */
    public function rootCategory(): self
    {
        $current = $this;
        $guard = 0;
        while ((int)($current->parent_id ?? 0) > 0 && $guard < 20) {
            $parent = $current->relationLoaded('parent')
                ? $current->parent
                : $current->parent()->with('translations')->first();
            if (!$parent) {
                break;
            }
            if (!$parent->relationLoaded('translations')) {
                $parent->load('translations');
            }
            $current = $parent;
            $guard++;
        }
        return $current;
    }

    /**
     * 富文本是否有实质内容（含纯图片/表格）。
     */
    public static function hasRichHtml(?string $html): bool
    {
        $html = trim((string)$html);
        if ($html === '') {
            return false;
        }
        if (trim(strip_tags($html)) !== '') {
            return true;
        }
        return (bool)preg_match('/<(img|table|iframe|video|hr)\b/i', $html);
    }

    /**
     * 分类页板块：自身有内容则用自身，否则延用最上层一级分类的设置。
     */
    public function resolvePageBlockHtml(): string
    {
        $own = (string)($this->page_block ?? '');
        if (self::hasRichHtml($own)) {
            return front_html_prefer_webp($own);
        }

        $root = $this->rootCategory();
        if ((int)$root->id === (int)$this->id) {
            return '';
        }

        if (!$root->relationLoaded('translations')) {
            $root->load('translations');
        }

        $inherited = (string)($root->page_block ?? '');
        return self::hasRichHtml($inherited) ? front_html_prefer_webp($inherited) : '';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function getCreatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function productFaqs()
    {
        return $this->belongsToMany(ProductFaq::class, 'product_faq_product_category')
            ->withPivot('sort')
            ->withTimestamps()
            ->orderByPivot('sort', 'desc');
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
