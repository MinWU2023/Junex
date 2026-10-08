<?php

namespace App\Modules\Report\Controllers;

use Addons\Keywords\Models\Keyword;
use Addons\Keywords\Models\ProductTag;
use App\Models\AdSpace;
use App\Models\IndexLink;
use App\Models\Notice;
use App\Modules\Article\Models\Article;
use App\Modules\Article\Models\ArticleCategory;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Inquiry\Models\Newsletter;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Setting\Models\Locale;
use App\Modules\SiteCount\Models\SiteCount;
use App\Modules\Url\Models\Url;
use App\Services\ReportService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\AddedService;
class ReportController extends BaseController
{

    public function __construct(Product $product)
    {
        $this->viewPath = 'Report.Views.report';
    }


    public function show($id)
    {
        $id = (int)$id;
        $data = ['.show_product','.show_inquiry','.show_article','.show_site'];
        if (isset($data[$id-1])){
            return view($this->viewPath.$data[$id-1]);
        }
        return view($this->viewPath.$data[3]);
    }


    /**
     * 更新关键词收录
     * @return void
     */
    public function updateTagCollect(){

        if (Storage::disk('disk')->exists('storage/googleVerify.txt')){
            $res = Http::post('https://api.collection.dyyseo.com/api/collectedlink', [
                'domain' => parse_url(url('/'))['host'],
                'token' => Storage::disk('disk')->get('storage/googleVerify.txt'),
            ]);
            if ($res->successful()) {
                $response_data = $res->json()['data'];
                if (isset($response_data['urls'])){
                    foreach ($response_data['urls'] as $url_data) {
                        $type = 'other';
                        if (isset(parse_url($url_data['path'])['path'])) {
                            $link = trim(parse_url($url_data['path'])['path'], '/');
                            $url_model = Url::query()->where('url', $link)->first();
                            if ($url_model) {
                                $type = $url_model->urlable_type;
                            }
                        } else {
                            $link = '/';
                            $type = 'home';
                        }
                        IndexLink::query()->updateOrCreate([
                            'link' => $link,
                            'collected_date' => $url_data['collected_date'],
                            'type' => $type,
                        ]);
                    }
                }
                if (isset($response_data['urls2'])){
                    foreach ($response_data['urls2'] as $url) {
                        if (isset(parse_url($url)['path'])) {
                            $link = parse_url($url)['path'];
                        } else {
                            $link = '/';
                        }
                        IndexLink::query()->updateOrCreate([
                            'link' => $link,
                            'status' => 0
                        ]);
                    }
                }


            }
        }


    }


    public function index()
    {
        if (!Cache::has('home_pull')){
            $request_url = trim(config("cloud_api") ?? env('MIX_API_CLOUD'), '/') . '/api/customerWebsite/homePull';
            try {
                $res = Http::withHeaders(['token' => app()['settings']['setting']->website_token])->withoutVerifying()->post($request_url);
                if ($res->successful()){
                    if ($res->json()['status']){
                        $res_data  = $res->json();
                        foreach ($res_data['ad_spaces'] as $ad_space){
                            $temp_id = $ad_space['id'];
                            unset($ad_space['id']);
                            DB::table('ad_spaces')->updateOrInsert([
                                'id' => $temp_id
                            ],$ad_space);
                        }
                        foreach ($res_data['notices'] as $notice){
                            $temp_id = $notice['id'];
                            unset($notice['id']);
                            DB::table('notices')->updateOrInsert([
                                'id' => $temp_id
                            ],$notice);
                        }
                        $setting = app('settings')['setting'];
                        $setting->size_label = $res_data['size_label'];
                        $setting->max_size = $res_data['max_size'];
                        $setting->save();
                    }
                }
            }catch (ConnectionException $exception){

            }
            Cache::put('home_pull',true, now()->addMinutes(30));//缓存半小时
        }

        //每天拉取一下
//        if (!Cache::has('collectedlink_chche')){
//            $this->updateTagCollect();
//            Cache::put('collectedlink_chche',true,now()->addDays());
//        }

        $data = [];
        $data['product_count'] = Product::query()->active()->count();
        $data['inquiry_count'] = Inquiry::query()->whereHas('users',function ($query){
            $query->where([
                'user_id' => auth()->id(),
                'is_del' => 0
            ]);
        })->count();
//        $data['tl_count'] =  Inquiry::query()->where('title','like','%【First Page TL Inquiry】%')->whereHas('users',function ($query){
//            $query->where([
//                'user_id' => auth()->id(),
//                'is_del' => 0
//            ]);
//        })->count();
//        $data['inquiry_count'] = $data['inquiry_count']-$data['tl_count'];

        $data['article_count'] = Article::query()->count();
        $data['woodpecker_count'] = 0;
        $data['woodpeckers'] = [];
        if (Schema::hasTable('woodpeckers') && in_array('Woodpecker',app('myAddons'))){
            $data['woodpecker_count'] = DB::table('woodpeckers')->count();
            $data['woodpeckers'] = DB::table('woodpeckers')->orderByDesc('time')->limit(6)->get();
        }
        $data['product_video'] = self::countData()['video_count'];

        $data['tl_data_month'] = Inquiry::query()->where('title','like','%【First Page TL Inquiry】%')->whereHas('users',function ($query){
            $query->where([
                'user_id' => auth()->id(),
                'is_del' => 0
            ]);
        })->where('add_date',date('Ym'))->count();
        $data['tl_all_data']  = Inquiry::query()->where('title','like','%【First Page TL Inquiry】%')->whereHas('users',function ($query){
                $query->where([
                    'user_id' => auth()->id(),
                    'is_del' => 0
                ]);
            })->count();
        $data['tl_data'] =  Inquiry::query()->where('title','like','%【First Page TL Inquiry】%')->whereHas('users',function ($query){
            $query->where([
                'user_id' => auth()->id(),
                'is_del' => 0
            ]);
        })->limit(6)->get();

        $data['inquiry_country_count'] = count(array_unique(Inquiry::query()->pluck('msg_country')->all()));

        $profileInfo = [
            'num' => 0,
            'tags' => [],
            'productCategoryCount' => ProductCategory::query()->count(),
            'product_tag_count' => \App\Modules\Product\Models\ProductTag::query()->count(),
        ];
        if ($data['product_count']){
            $profileInfo['keyword_scale'] = round($profileInfo['product_tag_count']/$data['product_count'],1);
        }else{
            $profileInfo['keyword_scale'] = 0;
        }
        if (Schema::hasColumn('product_tags','current_rank') && in_array('Keywords',app('myAddons'))){
            $profileInfo['num'] =  \Addons\Keywords\Models\Keyword::query()->where('is_rank',1)->whereBetween('current_rank',[1,10])->count();
            $profileInfo['tags'] = ProductTag::query()->with([
                'productRanks'=>function($query){
                    $query->orderByDesc('id');
                }
            ])->orderByDesc('is_rank')->orderBy('current_rank')->limit(10)->get();
            if ($profileInfo['tags']) {
                $profileInfo['tags'] = DataManagerController::changeKeywordsData($profileInfo['tags']);
            }
        }
        $locales = Locale::query()->get();
        $website_info = json_decode(app('settings')['setting']->website_info,true);

        $site_count_1 = SiteCount::where('type',1)->orderBy('check_date','desc')->first();
        $weight_rank = $site_count_1?$site_count_1->data:0;
        $site_count_2 = SiteCount::where('type',2)->orderBy('check_date','desc')->first();
        $main_web_rank = $site_count_2?$site_count_2->data:0;
        $site_count_3 = SiteCount::where('type',3)->orderBy('check_date','desc')->first();
        $web_rank = $site_count_3?$site_count_3->data:0;
        $site_count_data = [
            'weight_rank' => $weight_rank,
            'main_web_rank' => $main_web_rank,
            'web_rank' => $web_rank,
        ];
        $notices = Notice::query()->where('is_show',1)->orderByDesc('is_top')->orderByDesc('sort')->limit(6)->get();
        $ad_spaces = AdSpace::query()->where('is_show',1)->orderByDesc('sort')->get();
        $data['website_score'] = 0;
        if (in_array('OperationalScore',app('myAddons'))){
            $operational_score_model = DB::table('operational_scores')->selectRaw('sum(score) as score,add_date,created_at')
                ->where('status', 1)
                ->groupBy('add_date')
                ->orderByDesc('add_date')
                ->first();
            if ($operational_score_model){
                $data['website_score'] = $operational_score_model->score;
            }
        }

        $data['inquiry_wd_count'] = Inquiry::query()->whereHas('users',function ($query){
            $query->where([
                'user_id'=>auth()->id(),
                'is_del' => 0
            ]);
        })->count()-Inquiry::query()->whereHas('users',function ($query){
                $query->where([
                    'user_id'=>auth()->id(),
                    'is_del' => 0
                ]);
            })->whereHas('reads',function ($query){
                $query->where('user_id',auth()->id());
            })->count();

        $data['newsletter_wd_count'] = Newsletter::query()->count()-Newsletter::query()->whereHas('reads',function ($query){
                $query->where('user_id',auth()->id());
            })->count();
        $added_services = AddedService::query()->where('is_show',1)->orderByDesc('active')->get();
        return view($this->viewPath . '.index', compact('data',
            'profileInfo','locales','website_info','site_count_data','notices','ad_spaces','added_services'));
    }


    public static function countData($date=''){
        $articleCategories = ArticleCategory::query()->get();
        $data = [
            'video_count' => 0,
            'news_count' => 0
        ];
        $cases = config('operational.cases', [
            'case',
            'cases',
            'project',
            'projects',
            'solution',
            'solutions',
            'resources',
            'application',
            'applications',
            'video',
            'videos'
        ]);
        $articleCategoryIds = [];
        foreach ($articleCategories as $key => $value) {
            if (in_array(strtolower($value->name), $cases)) {
                $articleCategoryIds[] = $value->id;
                $article_categories = DB::table('article_categories')->where('parent_id',$value->id)->get();
                foreach ($article_categories as $k => $v) {
                    $articleCategoryIds[] = $v->id;
                }
            }
        }
        if ($date){
            $data['video_count'] = Article::query()->active()->whereIn('article_category_id',$articleCategoryIds)->where('created_at', '<', $date)->count();
            $data['news_count'] = Article::query()->where('created_at', '<', $date)->get()->count()-$data['video_count'];
        }else{
            $data['video_count'] = Article::query()->active()->whereIn('article_category_id',$articleCategoryIds)->count();
            $data['news_count'] = Article::query()->get()->count()-$data['video_count'];
        }
        return $data;
    }



    public function getStatistics(Request $request)
    {
        $type = $request->post('type', 'product');
        $start_time = $request->post('start_time', null);
        $end_time = $request->post('end_time', null);
        $year_time = $request->post('year_time', null);
        switch ($type) {
            case 'inquiry' :
                $model = new Inquiry();
                break;
            case 'article' :
                $model = new Article();
                break;
            case 'site' :
                $model = new SiteCount();
                if ($start_time && $end_time) {
                    $data = $model->whereBetween('add_date', [$start_time, $end_time])->where('type',3)->select(DB::raw('check_date as add_date'), DB::raw('data as num'))->groupBy('check_date')->paginate($request->input('limit', 15));
                } else {
                    if ($year_time) {
                        $year_time = date('Y') . $year_time;
                        $data = $model->whereBetween('add_date', [$year_time, $year_time])->where('type',3)->select(DB::raw('check_date as add_date'), DB::raw('data as num'))->groupBy('check_date')->paginate($request->input('limit', 15));
                    } else if ($start_time || $end_time) {
                        if ($start_time) {
                            $data = $model->where('add_date', '>=', $start_time)->where('type',3)->select(DB::raw('check_date as add_date'), DB::raw('data as num'))->groupBy('check_date')->paginate($request->input('limit', 15));
                        } else {
                            $data = $model->where('add_date', '<=', $end_time)->where('type',3)->select(DB::raw('check_date as add_date'), DB::raw('data as num'))->groupBy('check_date')->paginate($request->input('limit', 15));
                        }
                    } else {
                        $data = $model->select(DB::raw('check_date as add_date'), DB::raw('data as num'))->where('type',3)->groupBy('check_date')->paginate($request->input('limit', 15));
                    }

                }
                return new CommonResourceCollection($data);
                break;
            default:
                $model = new Product();
                break;
        }

        if ($start_time && $end_time) {
            $data = $model->whereBetween('add_date', [$start_time, $end_time])->select('add_date', DB::raw('count(*) as num'))->groupBy('add_date')->paginate($request->input('limit', 15));
        } else {
            if ($year_time) {
                $year_time = date('Y') . $year_time;
                $data = $model->whereBetween('add_date', [$year_time, $year_time])->select('add_date', DB::raw('count(*) as num'))->groupBy('add_date')->paginate($request->input('limit', 15));
            } else if ($start_time || $end_time) {
                if ($start_time) {
                    $data = $model->where('add_date', '>=', $start_time)->select('add_date', DB::raw('count(*) as num'))->groupBy('add_date')->paginate($request->input('limit', 15));
                } else {
                    $data = $model->where('add_date', '<=', $end_time)->select('add_date', DB::raw('count(*) as num'))->groupBy('add_date')->paginate($request->input('limit', 15));
                }
            } else {
                $data = $model->select('add_date', DB::raw('count(*) as num'))->groupBy('add_date')->paginate($request->input('limit', 15));
            }

        }
        return new CommonResourceCollection($data);

    }

}
