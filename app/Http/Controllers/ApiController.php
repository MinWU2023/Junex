<?php

namespace App\Http\Controllers;

use Addons\Keywords\Models\Keyword;
use App\Http\Middleware\DyycloudMiddleware;
use App\Models\EmailSend;
use App\Modules\Admin\Models\AdminLog;
use App\Modules\Article\Models\Article;
use App\Modules\Article\Models\ArticleCategory;
use App\Modules\Blog\Models\Blog;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductTag;
use App\Modules\Setting\Models\Locale;
use App\Modules\SiteCount\Models\SiteCount;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\AddedService;
class ApiController extends Controller
{
    use ResponseTrait;

    protected $status = true;


    public function __construct()
    {
        $this->middleware(DyycloudMiddleware::class)
            ->except(['websiteData', 'googleVerify', 'product', 'lastProduct', 'category']);
    }

    /**
     * @url
     * file_name
     *
     *
     * @param Request $request
     */
    public function googleVerify(Request $request)
    {
        if (!Storage::disk('disk')->exists('storage/googleVerify.txt')) {
            file_put_contents(storage_path('googleVerify.txt'), $request->get('token'));
        } else {
            if ($request->get('token') != Storage::disk('disk')->get('storage/googleVerify.txt')) {
                return $this->badRequest('验证失败');
            }
        }
        $robots = file_get_contents(storage_path('robots.txt'));
        if (!strstr($robots, 'Allow')) {
            return $this->badRequest('网站未开启robots');
        }
        $file_name = $request->post('file_name');
        if (!Storage::disk('disk')->exists('public/' . $file_name)) {
            $arr = explode('.', $file_name);
            if (array_pop($arr) == 'html') {
                file_put_contents(public_path($file_name), 'google-site-verification: ' . $file_name);
                response('yes', 200);
            }
        }
    }

    public function websiteSize(Request  $request)
    {
        $database = config('database.connections.mysql.database');
        $websiteSize = 500 / 1024;
        $size = DB::select("SELECT table_schema AS database_name, ROUND(SUM(data_length + index_length) / 1024 / 1024 / 1024, 2) AS total_size_GB FROM information_schema.tables WHERE table_schema = ? GROUP BY table_schema", [$database]);
        if (!empty($size)) {
            $size = $size[0]->total_size_GB;
        } else {
            $size = 0;
        }
        $fileSize =  (DB::table('file_infos')->whereIn('extention',[
                'jpg','png','gif','jpeg'
            ])->sum('size') / 1024 / 1024 / 1024)*3;

        $fileSize+=DB::table('file_infos')->whereIn('extention',[
                'zip','rar','pdf','mp4'
            ])->sum('size') / 1024 / 1024 / 1024;

        $max_size = $request->get('max_size');
        if ($max_size){
            $setting = app('settings')['setting'];
            $setting->max_size = $max_size;
            $setting->save();
        }
            return [
                'status' => true,
                'data' => round($size + $websiteSize + $fileSize, 2)
            ];


    }


    public function addedService(Request $request)
    {
        $data = $request->get('data');
        foreach ($data as $item) {
            AddedService::query()->updateOrCreate([
                'source_id' => $item['source_id'],
            ],[
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'active' => $item['active'],
                'is_show' => $item['is_show']
            ]);
        }
        return true;
    }


    public function operationLog(Request $request)
    {
        $last_id = $request->get('id');
        $logs = AdminLog::query()->orderByDesc('id')->where('user_id','>',1)->where('id', '>', $last_id)->select(['id', 'name', 'modelName', 'created_at','data_source_id','data_created_at'])->get()->toArray();
        if (isset($logs[0])) {
            $last_id = $logs[0]['id'];
        }
        return $this->data(
            [
                'logs' => $logs,
                'last_id' => $last_id
            ]
        );
    }

    public function category(Request $request)
    {
        if ($request->header('token') != app('settings')['setting']->website_id) {
            return $this->badrequest('验证失败');
        }
        $categories = \App\Modules\Product\Models\ProductCategory::query()->get();
        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'custom_cat_id' => $category->id,
                'custom_cat_name' => $category->name,
                'custom_custom_cat_id' => $category->parent_id
            ];
        }
        return $data;
    }

    public function product(Request $request)
    {
        if ($request->header('token') != app('settings')['setting']->website_id) {
            return $this->badrequest('验证失败');
        }

        $product_id = $request->get('product_id', 0);

        $products = \App\Modules\Product\Models\Product::query()->with(['productCategory', 'productImages'])->where('id', '>', $product_id)->limit(10)->get();

        $data = [];
        $rand_category = ProductCategory::query()->first();
        foreach ($products as $product) {
            $imgs = array_column($product->productImages->toArray(), 'path');
            foreach ($imgs as $k => $img) {
                $imgs[$k] = url($img);
            }
            try {
                $data[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'category_name' => isset($product->productCategory->toArray()[0]['name']) ? $product->productCategory->toArray()[0]['name'] : $rand_category->name,
                    'product_brief' => $product->brief_content,
                    'img' => $imgs,
                    'keywords' => array_column($product->productTags->toArray(), 'name'),
                    'product_detail' => $product->content
                ];
            } catch (\Exception $exception) {
                Log::info('api product error:' . $exception->getMessage());
            }

        }
        return $data;
    }

    public function lastProduct(Request $request)
    {
        if ($request->header('token') != app('settings')['setting']->website_id) {
            return $this->badrequest('验证失败');
        }
        return Product::query()->orderByDesc('id')->first()->id;
    }


    public function websiteData(Request $request)
    {
        if ($request->get('crm_token') != app('settings')['setting']->website_id) {
            return $this->badrequest('验证失败');
        }

        switch ($request->get('type')) {
            case 'all_lang':
                $locales = Locale::query()->where('language_code', '<>', 'en')->pluck('language_code')->toArray();
                return $this->data($locales);
            case 'last_month_product_count':
                return Product::query()->active()->where('add_date', date('Ym', strtotime("-1month")))->count();
            case 'product_count':
                return Product::query()->active()->where('add_date', date('Ym'))->count();
            case 'news_count':
                $article_categories = ArticleCategory::query()->get();
                $count = 0;
                foreach ($article_categories as $articleCategory) {
                    if (strstr(strtolower($articleCategory->name),'news') || strstr(strtolower($articleCategory->name),'information')) {
                        $count += Article::active()->where(['add_date' => date('Ym'), 'article_category_id' => $articleCategory->id])->count();
                    }
                }
                return $count;
            case 'all_news_count':
                $article_categories = ArticleCategory::query()->with(['children'])->get();
                $count = 0;
                foreach ($article_categories as $articleCategory) {
                    if (strstr(strtolower($articleCategory->name),'news') || strstr(strtolower($articleCategory->name),'information')) {
                        $count+= Article::active()->where(['article_category_id' => $articleCategory->id])->count();
                    }
                }
                return $count;
            case 'all_product_count':
                return Product::query()->active()->count();
            case 'all_enquiry_count':
                return Inquiry::query()->count();
            case 'last_month_msg':
                return Inquiry::query()->where('add_date', date('Ym', strtotime("-1month")))->count();
            case 'unread_msg_count':
                return Inquiry::query()->whereHas('reads', function ($query) {
                    $query->where('user_id', 2);
                })->count();
            case 'keywords':
                $data = [];
                if (Schema::hasTable("keywords")) {
                    $keywords = Keyword::query()->with(['ranks' => function ($query) {
                        $query->orderByDesc('id')->limit(1);
                    }])->orderByDesc('is_rank')->orderBy('current_rank')->get();
                    foreach ($keywords as $keyword) {
                        $rank_data = [
                            'name' => $keyword->name,
                            'rank' => $keyword->current_rank,
                            'catch_url' => '',
                            'check_date' => '',
                        ];
                        if (isset($keyword->ranks[0])) {
                            $rank_data['catch_url'] = $keyword->ranks[0]['catch_url'];
                            $rank_data['check_date'] = $keyword->ranks[0]['check_date'];
                        }
                        $data[] = $rank_data;
                    }
                } else {
                    $product_tags = ProductTag::query()->with(['translations'])->get();
                    foreach ($product_tags as $product_tag) {
                        $data[] = [
                            'name' => $product_tag->name,
                            'rank' => 0,
                            'catch_url' => '',
                            'check_date' => '',
                        ];
                    }
                }
                $sort = array(
                    'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
                    'field' => 'rank',       //排序字段
                );
                $arrSort = array();
                foreach ($data as $uniqid => $row) {
                    foreach ($row as $key => $value) {
                        $arrSort[$key][$uniqid] = $value;
                    }
                }
                array_multisort($arrSort[$sort['field']], constant($sort['direction']), $data);
                return $this->data($data);
            case 'blog_count':
                return Blog::query()->active()->count();
            case 'inquiry':
                $inquiries = Inquiry::query()->whereHas('users', function ($query) {
                    $query->where(['is_del' => 0, 'user_id' => 2]);
                })->where('id', '>', $request->get('max_id'))->get()->toArray();
                return $this->data($inquiries);
            case 'included':
                $data = [
                    'check_date' => date('Ymd', strtotime("-1days")),
                    'main' => 0,
                    'all' => 0,
                ];
                $main_site_count = SiteCount::query()->where(['check_date' => date('Y-m-d', strtotime("-1days")), 'type' => 2])->first();
                $all_site_count = SiteCount::query()->where(['check_date' => date('Y-m-d', strtotime("-1days")), 'type' => 3])->first();
                if ($main_site_count) {
                    $data['main'] = $main_site_count->data;
                }
                if ($all_site_count) {
                    $data['all'] = $all_site_count->data;
                }
                return $this->data($data);
        }
    }


    public function failEmail(Request $request)
    {
        $source_id = $request->get('source_id');
        $type = $request->get('type');
        $inquiry = Inquiry::query()->findOrFail($source_id);
        if ($inquiry) {
            EmailSend::query()->where([
                'type' => $type,
                'source_id' => $source_id
            ])->update([
                'status' => 1
            ]);
            $inquiry->send_emails = implode(',', $request->get('emails'));
            $inquiry->save();
            return true;
        }
        return $this->badRequest('not found inquiry');
    }

}
