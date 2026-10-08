<?php

namespace App\Console\Commands\Sync;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Article\Models\Article;
use App\Modules\Article\Models\ArticleCategory;
use App\Modules\Download\Models\Download;
use App\Modules\Download\Models\DownloadCategory;
use App\Modules\FileInfo\Models\FileInfo;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Page\Models\Page;
use App\Modules\Photo\Models\PhotoAlbum;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductTag;
use App\Services\GeoLiteService;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OldSyncCommand extends Command
{
    /**
     * 同步老站数据
     *
     * @var string
     */
    protected $signature = 'old:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public $url = 'https://www.newstarhose.com/';

    public function handle()
    {
        DB::table('urls')->truncate();
//        Artisan::call('testData:install');
        $this->importPhoto();
        $this->info('相册图片导入成功');
        $this->importProduct();
        $this->info('产品相关导入成功');
        $this->importArticle();
        $this->info('文章相关导入成功');
        $this->importBlog();
        $this->info('博客相关导入成功');
        $this->importDownload();
        $this->info('下载相关导入成功');
        $this->importInquiry();
        $this->info('询盘相关导入成功');
        $this->importPage();
        $this->info('单页面相关导入成功');
    }

    /**
     * 导入询盘
     */
    public function importInquiry()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('inquiries')->truncate();
        DB::table('inquiry_user')->truncate();
        DB::table('inquiry_user_reads')->truncate();
        DB::table('inquiry_remarks')->truncate();
        $geoLiteService = new GeoLiteService();
        /**
         * b2b_msg询盘表
         */
        $old_inquiries = DB::connection('tmp')->table('b2b_msg')->get()->toArray();
        foreach ($old_inquiries as $old_inquiry) {
            $data = [
                'product_id' => 0,
                'title' => $old_inquiry->msg_title,
                'content' => $old_inquiry->msg_content,
                'email' => $old_inquiry->msg_email,
                'tel' => $old_inquiry->msg_tel,
                'ip' => $old_inquiry->msg_ip,
                'location' =>  $geoLiteService->getLocationByIp($old_inquiry->msg_ip),
                'source_url' => $old_inquiry->msg_url,
                'created_at' => $old_inquiry->msg_time,
                'updated_at' => $old_inquiry->msg_time,
                'add_date' => date('Ym', strtotime($old_inquiry->msg_time)),
//                'is_read' => $old_inquiry->msg_state == 0 ? 0 : 1,
                'client' => $old_inquiry->msg_mobile == 0 ? "pc" : "mobile",
            ];
            $new_inquiry = Inquiry::create($data);
            if ($old_inquiry->msg_genjin) {
                $new_inquiry->inquiryRemark()->create([
                    'admin_user_id' => 1,
                    'inquiry_id' => $new_inquiry->id,
                    'content' => $old_inquiry->msg_genjin
                ]);
            }
        }
    }


    /**
     * 导入博客相关
     */
    public function importBlog()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('blogs')->truncate();
        DB::table('blog_translations')->truncate();
        DB::table('blog_categories')->truncate();
        DB::table('blog_category_translations')->truncate();
        DB::table('blog_tags')->truncate();
        DB::table('blog_tag_translations')->truncate();
        DB::table('blog_blog_tag')->truncate();
        DB::table('blog_files')->truncate();
        /**
         * b2b_user_blogcat  b2b_blogcategory_lang 博客分类表
         */
        $old_blog_categories = DB::connection('tmp')->table('b2b_user_blogcat')->get()->toArray();
        foreach ($old_blog_categories as $old_blog_category) {
            $old_blog_category_translations = DB::connection('tmp')->table('b2b_blogcategory_lang')->where(['user_blogcat_id' => $old_blog_category->user_blogcat_id])->get()->toArray();
            $addData1 = $this->getAttributes($old_blog_category_translations, [
                'name' => 'user_blogcat_name',
                'title' => 'seo_title',
                'content' => 'seo_content',
                'keywords' => 'seo_keywords',
            ]);
            $addData2 = [
                'url_key' => Str::slug($old_blog_category->user_blogcat_name),
                'sort' => $old_blog_category->blogcat_sort,
                'parent_id' => $old_blog_category->user_blogcat_cat_id,
                'path' => '',
                'en' => [
                    'name' => $old_blog_category->user_blogcat_name,
                    'title' => $old_blog_category->seo_title,
                    'content' => $old_blog_category->seo_content,
                    'keywords' => $old_blog_category->seo_keywords,
                ]
            ];
            $addData = array_merge($addData1, $addData2);
            $new_blog_category = BlogCategory::query()->create($addData);
            /**
             * b2b_user_blog    b2b_blog_lang 博客表
             */
            $olg_blogs = DB::connection('tmp')->table('b2b_user_blog')->where(['user_blogcat_id' => $old_blog_category->user_blogcat_id])->get()->toArray();
            if (!empty($olg_blogs) && $new_blog_category) {
                foreach ($olg_blogs as $olg_blog) {
                    $old_blog_translations = DB::connection('tmp')->table('b2b_blog_lang')->where(['user_blog_id' => $olg_blog->user_blog_id])->get()->toArray();
                    $addData1 = $this->getAttributes($old_blog_translations, [
                        'name' => 'user_blog_subject',
                        'content' => 'user_blog_content',
                        'title' => 'seo_title',
                        'keywords' => 'seo_keyword',
                        'description' => 'seo_description',
                    ]);
                    $addData2 = [
                        'url_key' => Str::slug($olg_blog->user_blog_subject),
                        'blog_category_id' => $new_blog_category->id,
                        'sort' => $olg_blog->user_blog_sort,
                        'active' => 1,
                        'path' => $this->createImg($this->url,'uploadfile/blog/' . $olg_blog->user_blog_pic),
                        'en' => [
                            'name' => $olg_blog->user_blog_subject,
                            'content' => $olg_blog->user_blog_content,
                            'title' => $olg_blog->seo_title,
                            'keywords' => $olg_blog->seo_keyword,
                            'description' => $olg_blog->seo_description,
                        ],
                    ];
                    $addData = array_merge($addData1, $addData2);
                    $new_blog = Blog::create($addData);
                    /**
                     * 产品关键词
                     */
                    $this->insertBlogTags($olg_blog->user_blog_id, $new_blog->id);
                }
            }
        }
    }

    protected function importProduct()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_images')->truncate();
        DB::table('product_translations')->truncate();
        DB::table('products')->truncate();
        DB::table('product_category_translations')->truncate();
        DB::table('product_categories')->truncate();
        DB::table('product_brands')->truncate();
        DB::table('product_attr_translations')->truncate();
        DB::table('product_tag_translations')->truncate();
        DB::table('product_tags')->truncate();
        DB::table('product_attributes')->truncate();
        //同步产品相关
        $old_product_categories = DB::connection('tmp')->table('b2b_custom_cat')->get()->toArray();
        foreach ($old_product_categories as $old_product_category) {
            /**
             *产品分类表  b2b_custom_cat  b2b_category_lang
             **/
            $old_product_category_translations = DB::connection('tmp')->table('b2b_category_lang')->where(['custom_cat_id' => $old_product_category->custom_cat_id])->get()->toArray();
            $addData1 = $this->getAttributes($old_product_category_translations, [
                'name' => 'custom_cat_name',
                'content' => 'custom_brief',
                'title' => 'seo_custom_title',
                'keywords' => 'seo_custom_keywords',
                'description' => 'seo_product_template_description',
            ]);
            $new_ids =[];
            if ($old_product_category->custom_custom_cat_id>0){
                $new_ids[] = $old_product_category->custom_custom_cat_id;
            }
            $addData2 = [
                'parent_id' => $old_product_category->custom_custom_cat_id,
                'sort' => 0,
                'is_show' => $old_product_category->is_show,
                'is_menu' => $old_product_category->custom_cat_nav,
                'path' => $this->createImg($this->url, 'uploadfile/category/' . $old_product_category->custom_cat_pic),
                'url_key' => Str::slug($old_product_category->custom_cat_name),
                'en' => [
                    'name' => $old_product_category->custom_cat_name,
                    'content' => $old_product_category->custom_brief,
                    'title' => $old_product_category->seo_product_template_title,
                    'keywords' => $old_product_category->seo_custom_keywords,
                    'description' => $old_product_category->seo_product_template_description
                ],

            ];
            $addData = array_merge($addData1, $addData2);
            $success_new_product_category = ProductCategory::create($addData);
            $new_ids[] = $success_new_product_category->id;
            /**
             * 产品表  b2b_product
             */
            $old_products = DB::connection('tmp')->table('b2b_product')->where(['custom_cat_id' => $old_product_category->custom_cat_id])->get()->toArray();
            if (!empty($old_products) && $success_new_product_category) {
                foreach ($old_products as $old_product) {
                    $old_product_translations = DB::connection('tmp')->table('b2b_product_lang')->where(['product_id' => $old_product->product_id])->get()->toArray();
                    $addData1 = $this->getAttributes($old_product_translations, [
                        'name' => 'product_name',
                        'brief_content' => 'product_brief',
                        'content' => 'product_detail',
                        'm_content' => 'product_detail',
                        'title' => 'product_seo_title',
                        'keywords' => 'product_seo_keyword',
                        'description' => 'product_seo_description',
                    ]);
                    $addData2 = [
                        'admin_user_id' => 1,
                        'product_category_id' => $success_new_product_category->id,
                        'product_brand_id' => 0,
                        'sort' => $old_product->product_sort,
                        'img_alt' => 'something',
                        'url_key' => Str::slug($old_product->product_name),
                        'active' => 1,
                        'is_new' => $old_product->is_new,
                        'is_hot' => $old_product->is_hot,
                        'is_recommend' => $old_product->product_isrecommend,
                        'add_date' => date('Ym'),
                        'en' => [
                            'name' => $old_product->product_name,
                            'brief_content' => $old_product->product_brief,
                            'content' => $old_product->product_detail,
                            'm_content' => $old_product->product_detail,
                            'title' => $old_product->product_seo_title,
                            'keywords' => $old_product->product_seo_keyword,
                            'description' => $old_product->product_seo_description,
                            'attribute' => "",
                        ],
                    ];
                    $addData = array_merge($addData1, $addData2);
                    $success_new_product = Product::create($addData);

                    $success_new_product->productCategory()->sync($new_ids);
                    /**
                     * 产品关键词
                     */
                    $insert_ids = $this->insertProductTags($old_product->product_id, $success_new_product->id);
                    $success_new_product->productTags()->sync($insert_ids);
                    /**
                     * 产品图片
                     */
                    $images = $this->getProductImages($old_product->product_pic, $success_new_product->id);
                    DB::table('product_images')->insert($images);
                }
            }
        }
    }

    /**
     * 导入单页面
     */
    public function importPage()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('page_translations')->truncate();
        DB::table('pages')->truncate();
        DB::table('page_files')->truncate();
        /**
         * b2b_single_page   b2b_singlepage_lang 单页面表
         */
        $old_pages = DB::connection('tmp')->table('b2b_single_page')->get()->toArray();
        foreach ($old_pages as $old_page) {
            $addData1 = [
                'parent_id' => $old_page->single_parent_id,
                'sort' => $old_page->single_page_sort,
                'img_alt' => '',
                'url_key' => Str::slug($old_page->single_page_title),
                'img_path' => $this->createImg($this->url,'uploadfile/single/' . $old_page->single_page_pic),
                'active' => 1,
                'en' => [
                    'name' => $old_page->single_page_title,
                    'content' => $old_page->single_page_content,
                    'title' => $old_page->seo_title,
                    'keywords' => $old_page->seo_keyword,
                    'description' => $old_page->seo_description,
                ],
            ];
            $old_page_translations = DB::connection('tmp')->table('b2b_singlepage_lang')->where(['single_page_id' => $old_page->single_page_id])->get()->toArray();
            $addData2 = $this->getAttributes($old_page_translations,[
                'name'  =>'single_page_title',
                'content'  =>'single_page_content',
                'title'  =>'seo_title',
                'keywords'  =>'seo_keyword',
                'description'  =>'seo_description',
            ]);
            $addData = array_merge($addData1, $addData2);
            Page::create($addData);
        }
    }

    /**
     * 导入下载
     */
    public function importDownload()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('downloads')->truncate();
        DB::table('download_translations')->truncate();
        DB::table('download_categories')->truncate();
        DB::table('download_category_translations')->truncate();
        /**
         * 下载分类表  b2b_user_downloadscat  b2b_downloadscategory_lang
         */
        $old_download_categories = DB::connection('tmp')->table('b2b_user_downloadscat')->get()->toArray();
        foreach ($old_download_categories as $old_download_category) {
            $cateAttributes = DB::connection('tmp')->table('b2b_downloadscategory_lang')->where(['user_downloadscat_id' => $old_download_category->user_downloadscat_id])->get()->toArray();
            $addData1 = $this->getAttributes($cateAttributes, [
                'name' => 'user_downloadscat_name',
                'title' => 'seo_title',
                'keywords' => 'seo_keywords',
                'description' => 'seo_content',
            ]);
            $addData2 = [
                'sort' => $old_download_category->downloadscat_sort,
                'parent_id' => $old_download_category->user_downloadscat_cat_id,
                'img' => '',
                'is_menu' => 0,
                'en' => [
                    'name' => $old_download_category->user_downloadscat_name,
                    'title' => $old_download_category->seo_title,
                    'keywords' => $old_download_category->seo_keywords,
                    'description' => $old_download_category->seo_content,
                ],

            ];
            $addData = array_merge($addData1, $addData2);
            $new_download_category = DownloadCategory::create($addData);

            /**
             * b2b_downloads    b2b_downloads_lang 下载表
             */
            $old_downloads = DB::connection('tmp')->table('b2b_downloads')->where(['user_downloadscat_id' => $old_download_category->user_downloadscat_id])->get()->toArray();
            if (!empty($old_downloads) && $new_download_category) {
                foreach ($old_downloads as $old_download) {
                    $old_download_translations = DB::connection('tmp')->table('b2b_downloads_lang')->where(['user_downloads_id' => $old_download->user_downloads_id])->get()->toArray();
                    $addData1 = $this->getAttributes($old_download_translations,[
                        'name' => 'user_downloads_subject',
                        'content' => 'user_downloads_content'
                    ]);
                    $addData2 = [
                        'download_category_id' => $new_download_category->id,
                        'sort' => $old_download->user_downloads_sort,
                        'url' => $old_download->downloads_url??"",
                        'img' => $this->createImg($this->url,'uploadfile/downloads/' . $old_download->user_downloads_pic),
                        'filepath' => $this->createImg($this->url,'uploadfile/downloads/' . $old_download->user_downloads_file),
                        'en' => [
                            'name' => $old_download->user_downloads_subject,
                            'content' => $old_download->user_downloads_content,
                        ],
                    ];
                    $addData = array_merge($addData1, $addData2);
                    Download::create($addData);
                }
            }
        }
    }

    /**
     * 导入文章相关
     */
    public function importArticle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('article_translations')->truncate();
        DB::table('articles')->truncate();
        DB::table('article_category_translations')->truncate();
        DB::table('article_categories')->truncate();
        /**
         * b2b_user_newscat  b2b_newscategory_lang文章分类表
         */
        $old_article_categories = DB::connection('tmp')->table('b2b_user_newscat')->get()->toArray();
        foreach ($old_article_categories as $old_article_category) {
            $old_article_category_translations = DB::connection('tmp')->table('b2b_newscategory_lang')->where(['user_newscat_id' => $old_article_category->user_newscat_id])->get()->toArray();
            $addData1 = $this->getAttributes($old_article_category_translations, [
                'name' => 'user_newscat_name',
                'title' => 'seo_title',
                'content' => 'seo_content',
                'keywords' => 'seo_keywords',
                'description' => 'user_newscat_content',
            ]);
            $addData2 = [
                'url_key' => Str::slug($old_article_category->user_newscat_name),
                'sort' => $old_article_category->newscat_sort,
                'parent_id' => $old_article_category->user_newscat_cat_id,
                'path' => '',
                'en' => [
                    'name' => $old_article_category->user_newscat_name,
                ],
            ];
            $addData = array_merge($addData1, $addData2);
            $new_article_category = ArticleCategory::create($addData);
            /**
             * b2b_user_news  b2b_news_lang  文章表
             */
            $old_articles = DB::connection('tmp')->table('b2b_user_news')->where(['user_newscat_id' => $old_article_category->user_newscat_id])->get()->toArray();
            if (!empty($old_articles) && $new_article_category) {
                foreach ($old_articles as $old_article) {
                    $articleAttributes = DB::connection('tmp')->table('b2b_news_lang')->where(['user_news_id' => $old_article->user_news_id])->get()->toArray();
                    $addData1 = $this->getAttributes($articleAttributes, [
                        'name' => 'user_news_subject',
                        'content' => 'user_news_content',
                        'title' => 'seo_title',
                        'keywords' => 'seo_keyword',
                        'description' => 'seo_description',
                    ]);
                    $addData2 = [
                        'url_key' => Str::slug($old_article->user_news_subject),
                        'sort' => $old_article->user_news_sort,
                        'is_show' => 0,
                        'is_menu' => 0,
                        'active' => 1,
                        'article_category_id' => $new_article_category->id,
                        'path' => $this->createImg($this->url, 'uploadfile/news/' . $old_article->user_news_pic),
                        'en' => [
                            'name' => $old_article->user_news_subject,
                            'content' => $old_article->user_news_content,
                            'title' => $old_article->seo_title,
                            'keywords' => $old_article->seo_keyword,
                            'description' => $old_article->seo_description,
                        ],
                    ];
                    $addData = array_merge($addData1, $addData2);
                    Article::query()->create($addData);
                }
            }
        }
    }

    public function getAttributes($models, $fields)
    {
        $data = [];
        foreach ($models as $model) {
            $lang_name = $this->getLangNameById($model->lang_id);

            foreach ($fields as $new => $old) {
                $data[$lang_name][$new] = $model->$old;
            }
        }
        return $data;
    }


    public function insertProductTags($old_product_id, $new_product_id)
    {
        $tags = DB::connection('tmp')->table('b2b_product_key')->where('product_product_id', $old_product_id)->get()->toArray();
        $insert_ids = [];
        if (!empty($tags) && is_array($tags)) {
            foreach ($tags as $tag) {
                $data = [
                    'url_key' => Str::slug($tag->product_key_keyword),
                    'sort' => 0,
                    'en' => [
                        'name' => $tag->product_key_keyword,
                    ],
                ];
                $keys = json_decode($tag->product_key_lang, true);
                if (!empty($keys) && is_array($keys)) {
                    foreach ($keys as $key) {
                        $lang_name = $this->getLangNameById(array_keys($key)[0]);
                        $data[$lang_name] = [
                            'name' => array_values($key)[0],
                        ];
                    }
                }
                //关键词去重
                $successTag = ProductTag::whereTranslation('name', $tag->product_key_keyword)->first();
                if (!$successTag){
                    $successTag = ProductTag::create($data);
                }
                $insert_ids[]= $successTag->id;
            }
        }
        return $insert_ids;
    }


    public function getProductImages($imageIds, $product_id)
    {
        $data = [];
        if ($imageIds) {
            $imageIds = explode(',', $imageIds);
            $images = DB::connection('tmp')->table('meu_imgs')->whereIn('id', $imageIds)->get()->toArray();
            if (!empty($images) && is_array($images)) {
                foreach ($images as $k => $image) {
                    $data[] = [
                        'product_id' => $product_id,
                        'path' => $this->createImg($this->url, 'uploadfile/' . $image->dir . '/' . $image->pickey . '.' . $image->ext),
                        'is_main' => $k == 0 ? 1 : 0,
                        'alt' => '',
                        'sort' => 1,
                        'created_at' => date('Y-m-d H:i:s', $image->create_time),
                        'updated_at' => date('Y-m-d'),
                    ];
                }
            }
        }
        return $data;
    }


    public function getLangNameById($lang_id)
    {
        $langs = DB::connection('tmp')->table('b2b_lang')->get()->toArray();
        foreach ($langs as $lang) {
            if ($lang->lang_id == $lang_id) {
                return $lang->lang_name;
            }
        }
        return 'en';

    }

    public function createImg($url, $path)
    {
        $client = new Client(['verify' => false]);  //忽略SSL错误
        $url = trim($url, '/');
        $path = trim($path, '/');
        $uploadPath = substr($path, 0, strrpos($path, '/') + 1);
        $storage = Storage::disk('public');
        if (!$storage->exists($uploadPath)) {
            $storage->makeDirectory($uploadPath);
        }
        if (!is_file(public_path('storage/' . $path))) {
//            $this->info('需要下载');
            try {
                $storage->put($path, (string)$client->get($url . '/' . $path)->getBody());
            } catch (\Exception $exception) {

            }
        }
        return 'storage/' . trim($path, '/');
    }


    private function insertBlogTags($old_blog_id, $new_blog_id)
    {
        /*
         * b2b_blog_key 博客关键词
         */
        $tags = DB::connection('tmp')->table('b2b_blog_key')->where('blog_blog_id', $old_blog_id)->get()->toArray();
        if (!empty($tags) && is_array($tags)) {
            foreach ($tags as $tag) {
                $data = [
                    'url_key' => Str::slug($tag->blog_key_keyword),
                    'sort' => 0,
                    'en' => [
                        'name' => $tag->blog_key_keyword,
                    ],
                ];
                $keys = json_decode($tag->blog_key_keyword, true);
                if (!empty($keys) && is_array($keys)) {
                    foreach ($keys as $key) {
                        $lang_name = $this->getLangNameById(array_keys($key)[0]);
                        $data[$lang_name] = [
                            'name' => array_values($key)[0],
                        ];
                    }
                }

                $successTag = BlogTag::whereTranslation('name', $tag->blog_key_keyword)->first();
                if (!$successTag){
                    $successTag = BlogTag::create($data);
                }
                DB::table('blog_blog_tag')->insert([
                    'blog_id' => $new_blog_id,
                    'blog_tag_id' => $successTag->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        return true;
    }

    public function importPhoto()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('photo_albums')->truncate();
        DB::table('file_infos')->truncate();
        //相册表 meu_albums  meu_imgs
        $old_albums = DB::connection('tmp')->table('meu_albums')->get()->toArray();
        foreach ($old_albums as $old_album) {
            $new_album = PhotoAlbum::query()->where('name', $old_album->name)->first();
            if (!$new_album) {
                $new_album = PhotoAlbum::query()->create([
                    'name' => $old_album->name
                ]);
            }
            $old_images = DB::connection('tmp')->table('meu_imgs')->where(['album' => $old_album->id])->get()->toArray();
            foreach ($old_images as $old_image) {
                $true_path = $this->createImg($this->url, 'uploadfile/' . $old_image->dir . '/' . $old_image->pickey . '.' . $old_image->ext);
                $repeat = FileInfo::query()->where('true_path', $true_path)->first();
                if (!$repeat) {
                    FileInfo::query()->create([
                        'file_name' => $old_image->name,
                        'mimeType' => 'image/jpeg',
                        'true_path' => $true_path,
                        'extention' => $old_image->ext,
                        'size' => filesize(public_path($true_path)),
                        'is_download' => 1,
                        'photo_album_id' => $new_album->id,
                        'is_watermark' => 0
                    ]);
                }
            }
        }
    }

}
