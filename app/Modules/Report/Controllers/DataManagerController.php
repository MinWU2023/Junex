<?php

namespace App\Modules\Report\Controllers;

use Addons\Keywords\Models\Keyword;
use Addons\WebsiteReport\Models\SessionTotal;
use App\Models\IndexLink;
use App\Models\LoginLog;
use App\Modules\Admin\Models\User;
use App\Modules\Product\Models\ProductTag;
use Addons\WebsiteReport\Models\WebsiteReport;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Setting\Models\Locale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class DataManagerController extends BaseController
{


    public function __construct()
    {
        $this->viewPath = 'Report.Views.dataManager';
    }

    const SNAPSHOT_URL= 'https://snapshot.dyyweb.com/';


    public function index()
    {
        $website_info = json_decode(app('settings')['setting']->website_info, true);
        if (!Cache::has('dataManager_cache')) {
            $data = [];
            $data['product_count'] = Product::query()->active()->count();
            $data['product_count_last_month'] = Product::query()->active()->where('created_at', '<', date('Y-m-t', strtotime("-1month")))->count();

            $data['product_category_count'] = ProductCategory::query()->count();
            $data['product_category_count_last_month'] = ProductCategory::query()->where('created_at', '<', date('Y-m-t', strtotime("-1month")))->count();

            $data['product_tag_count'] = ProductTag::query()->count();
            $data['product_tag_count_last_month'] = ProductTag::query()->where('created_at', '<', date('Y-m-t', strtotime("-1month")))->count();
            $data['keyword_scale'] = 0;
            if ($data['product_count']>0){
                $data['keyword_scale'] = round($data['product_tag_count'] / $data['product_count'], 1);
            }

            $count_data = ReportController::countData();
            $count_data_date = ReportController::countData(date('Y-m-t', strtotime("-1month")));
            $data['product_video_count'] = $count_data['video_count'];
            $data['product_video_count_last_month'] = $count_data_date['video_count'];

            $data['article_count'] = $count_data['news_count'];
            $data['article_count_last_month'] = $count_data_date['news_count'];

            $data['inquiry_count'] = Inquiry::query()->whereHas('users', function ($query) {
                $query->where([
                    'user_id' => auth()->id(),
                    'is_del' => 0
                ]);
            })->count();
            $data['inquiry_count_last_month'] = Inquiry::query()->whereHas('users', function ($query) {
                $query->where([
                    'user_id' => auth()->id(),
                    'is_del' => 0
                ]);
            })->where('created_at', '<', date('Y-m-t', strtotime("-1month")))->count();

            $data['tl_count'] = Inquiry::query()->where('title', 'like', '%【First Page TL Inquiry】%')->whereHas('users', function ($query) {
                $query->where([
                    'user_id' => auth()->id(),
                    'is_del' => 0
                ]);
            })->count();
            $data['inquiry_count'] = $data['inquiry_count'] - $data['tl_count'];

            $data['tl_data_month_count'] = Inquiry::query()->where('title', 'like', '%【First Page TL Inquiry】%')->whereHas('users', function ($query) {
                $query->where([
                    'user_id' => auth()->id(),
                    'is_del' => 0
                ]);
            })->where('add_date', date('Ym'))->count();
            $data['tl_data_count'] = Inquiry::query()->where('title', 'like', '%【First Page TL Inquiry】%')->whereHas('users', function ($query) {
                $query->where([
                    'user_id' => auth()->id(),
                    'is_del' => 0
                ]);
            })->count();
            $data['inquiry_countries'] = Inquiry::query()->selectRaw('msg_country,count(*) as count')->groupBy('msg_country')->get();

            $data['woodpecker_count'] = 0;
            $data['website_score'] = 0;
            $data['woodpeckers'] = [];
            if (Schema::hasTable('woodpeckers') && in_array('Woodpecker', app('myAddons'))) {
                $data['woodpecker_count'] = DB::table('woodpeckers')->count();
                $data['woodpeckers'] = DB::table('woodpeckers')->orderByDesc('id')->limit(6)->get();
            }
            if (in_array('OperationalScore', app('myAddons'))) {
                $operational_score_model = DB::table('operational_scores')->selectRaw('sum(score) as score,add_date,created_at')
                    ->where('status', 1)
                    ->groupBy('add_date')
                    ->orderByDesc('add_date')
                    ->first();
                if ($operational_score_model) {
                    $data['website_score_model'] = $operational_score_model;
                    $data['website_score'] = $operational_score_model->score;
                }
            }
            $data['inquiry_country_count'] = count(array_unique(Inquiry::query()->pluck('msg_country')->all()));
            $data['locale_count'] = Locale::query()->count();

            $data['last_create_product'] = Product::query()->select(['created_at'])->orderByDesc('created_at')->first();
            $data['last_update_product'] = Product::query()->select(['updated_at'])->orderByDesc('updated_at')->first();
            $data['keywordsRankData'] = [];
            $data['tag_rank_num'] = 0;
            if (in_array('Keywords', app('myAddons'))) {
                $data['tag_rank_num'] = \Addons\Keywords\Models\Keyword::query()->where('is_rank', 1)->whereBetween('current_rank', [1, 10])->count();

                $data['keywordsRankData'] = tap(\Addons\Keywords\Models\ProductTag::with(['translations', 'productRanks' => function ($query) {
                    $query->orderBy('id', 'desc');
                }]))->orderByDesc('is_rank')->orderBy('current_rank')->limit(12)->get();
                if ($data['keywordsRankData']) {
                    $data['keywordsRankData'] = $this->changeKeywordsData($data['keywordsRankData']);
                }
            }
            $data['countryReport'] = $this->countryReport();
            $pageViewRankData = [];
            if (Schema::hasTable('website_reports')){
                $pageViewRankData = WebsiteReport::query()->where('type', 8)->first();
                if ($pageViewRankData &&  isset(json_decode($pageViewRankData->data, true)['data'])) {
                    $pageViewRankData = json_decode($pageViewRankData->data, true)['data'];
                }else{
                    $pageViewRankData = [];
                }

            }
            $data['pageViewRankData'] = $pageViewRankData;
            $data['currentProductIndexRate'] = $this->getCurrentProductIndexRate();
            $data['users'] = $this->adminUserData();
            $data['analysisData'] = $this->analysisData();
            Cache::put('dataManager_cache', $data,now()->addHours());
            $current_time = date('Y-m-d H:i:s');
            Cache::put('dataManager_cache_time', $current_time);
        } else {
            $data = Cache::get('dataManager_cache');
            $current_time = Cache::get('dataManager_cache_time', date('Y-m-d H:i:s'));
        }
        if (isset($website_info['expiration_time'])) {
            $website_info['count_month'] = round((strtotime($website_info['expiration_time']) - strtotime($website_info['start_time'])) / (60 * 60 * 24 * 30));
            $website_info['db_month'] = round((time() - strtotime($website_info['start_time'])) / (60 * 60 * 24 * 30));
            $website_info['sy_month'] = $website_info['count_month']-$website_info['db_month'];
        }
        return view($this->viewPath . '.index', compact('data', 'website_info', 'current_time'));
    }

    public function productCategoryRate(){
        if (Cache::has('productCategoryIndexRateDataHtml')){
            $productCategoryIndexRateDataHtml = Cache::get('productCategoryIndexRateDataHtml');
        }else{
            $productCategoryIndexRateDataHtml = $this->productCategoryIndexRateData();
            Cache::put('productCategoryIndexRateDataHtml',$productCategoryIndexRateDataHtml,now()->addDays());
        }
        return $this->data($productCategoryIndexRateDataHtml);
    }

    public function chartData(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        if (empty($start_date) || empty($end_date)){
            if (!Cache::has('chartData_cache')){
                $data = [
                    'keywordsRankData' => $this->rankData($start_date, $end_date),
                    'inquiryData' => $this->inquiryData($start_date, $end_date),
                    'inquiryDataByMonth' => $this->inquiryDataByMonth($start_date, $end_date),
                    'inquiryCountryRate' => $this->inquiryCountryRate($start_date, $end_date),
                    'operationalData' => $this->operationalData($start_date, $end_date),
                    'contentData' => $this->contentData($start_date, $end_date),
                    'productData' => $this->productData($start_date, $end_date),
                    'productIndexLinkRateData' => $this->productIndexLinkRateData($start_date, $end_date),
                ];
                Cache::put('chartData_cache',$data,now()->addHours());
            }else{
                $data = Cache::get('chartData_cache');
            }
        }else{
            $data = [
                'keywordsRankData' => $this->rankData($start_date, $end_date),
                'inquiryData' => $this->inquiryData($start_date, $end_date),
                'inquiryDataByMonth' => $this->inquiryDataByMonth($start_date, $end_date),
                'inquiryCountryRate' => $this->inquiryCountryRate($start_date, $end_date),
                'operationalData' => $this->operationalData($start_date, $end_date),
                'contentData' => $this->contentData($start_date, $end_date),
                'productData' => $this->productData($start_date, $end_date),
                'productIndexLinkRateData' => $this->productIndexLinkRateData($start_date, $end_date),
            ];
        }
        return $this->data($data);
    }

    /**
     * 流量分析数据
     * @param $start_date
     * @param $end_date
     * @return array
     */
    protected function analysisData()
    {
        if (!Schema::hasTable('session_totals') || !in_array('WebsiteReport', app('myAddons'))) {
            return [
                'data' => [],
            ];
        }
        $data = [];
        $times = array_reverse($this->getTimes('', ''));
        $max_sessions = 0;
        $max_screenPageViews = 0;
        $max_newUsers = 0;
        $max_sessions_date = '';
        $max_screenPageViews_date = '';
        $max_newUsers_date = '';
        foreach ($times as $time_key => $time) {
            $site_count = SessionTotal::query()
                ->whereBetween('date', [date('Ym01', strtotime($time)), date('Ymt', strtotime($time))])
                ->selectRaw('sum(sessions) as sum_sessions,sum(screenPageViews) as sum_screenPageViews,sum(newUsers) as sum_newUsers')->first();
            if ($site_count['sum_sessions'] > 0) {
                $data[$time_key]['time'] = $time;
                $data[$time_key]['sessions'] = $site_count['sum_sessions'];// 总访问次数
                $data[$time_key]['screenPageViews'] = $site_count['sum_screenPageViews'];//(总浏览次数pv)
                $data[$time_key]['newUsers'] = $site_count['sum_newUsers'];//总访客数
            }
        }
        foreach ($data as $datum_key => $datum) {

            if ($datum['sessions'] > $max_sessions) {
                $max_sessions = $datum['sessions'];
                $max_sessions_date = $datum['time'];
            }
            if ($datum['screenPageViews'] > $max_screenPageViews) {
                $max_screenPageViews = $datum['screenPageViews'];
                $max_screenPageViews_date = $datum['time'];
            }
            if ($datum['newUsers'] > $max_newUsers) {
                $max_newUsers = $datum['newUsers'];
                $max_newUsers_date = $datum['time'];
            }

            if (isset($data[$datum_key + 1])) {
                if ($data[$datum_key + 1]['sessions'] > 0) {
                    $data[$datum_key]['sessions_hb_rate'] = round((($datum['sessions'] - $data[$datum_key + 1]['sessions']) / $data[$datum_key + 1]['sessions']) * 100, 2);
                } else {
                    $data[$datum_key]['sessions_hb_rate'] = $datum['sessions'];
                }
                if ($data[$datum_key + 1]['screenPageViews'] > 0) {
                    $data[$datum_key]['screenPageViews_hb_rate'] = round((($datum['screenPageViews'] - $data[$datum_key + 1]['screenPageViews']) / $data[$datum_key + 1]['screenPageViews']) * 100, 2);
                } else {
                    $data[$datum_key]['screenPageViews_hb_rate'] = $datum['screenPageViews'];
                }
                if ($data[$datum_key + 1]['newUsers'] > 0) {
                    $data[$datum_key]['newUsers_hb_rate'] = round((($datum['newUsers'] - $data[$datum_key + 1]['newUsers']) / $data[$datum_key + 1]['newUsers']) * 100, 2);
                } else {
                    $data[$datum_key]['newUsers_hb_rate'] = $datum['newUsers'];
                }
            } else {
                $data[$datum_key]['sessions_hb_rate'] = $datum['sessions'];
                $data[$datum_key]['screenPageViews_hb_rate'] = $datum['screenPageViews'];
                $data[$datum_key]['newUsers_hb_rate'] = $datum['newUsers'];
            }
        }
        return [
            'data' => $data,
            'max_sessions_date' => $max_sessions_date,
            'max_screenPageViews' => $max_screenPageViews_date,
            'max_newUsers_date' => $max_newUsers_date,
        ];
    }

    /**
     * 获取账号数据
     * @return array
     */
    protected function adminUserData()
    {
        $data = [];
        $users = User::query()->with(['logs', 'products' => function ($query) {
            $query->active();
        }])->get();
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'product_count' => $user->products()->count(),
                'month_create' => Product::query()->where('admin_user_id', $user->id)->active()->where('add_date', date('Ym'))->count(),
                'month_update' => Product::query()->where('admin_user_id', $user->id)->active()->where('updated_at', '>', date('Y-m-01'))->count(),
                'inquiry_count' => DB::table('inquiry_user')->where([
                    'is_del' => 0,
                    'user_id' => $user->id,
                ])->count(),
                'inquiry_month_count' => Inquiry::query()->where('add_date', date('Ym'))->whereHas('users', function ($query) use ($user) {
                    $query->where(['is_del' => 0, 'user_id' => $user->id]);
                })->count(),
                'login_count' => $user->logs()->count(),
                'login_month_count' => LoginLog::query()->where('finally_at', '>', date('Y-m-01'))->where('user_id', $user->id)->count(),
                'last_login_at' => $user->last_login_at
            ];
        }
        return $data;
    }


    protected function getCurrentProductIndexRate()
    {
        $links = IndexLink::query()->where([
            'status' => 1,
            'type' => 'App\Modules\Product\Models\Product'
        ])->pluck('link')->toArray();
        //获取收录链接数量和现有产品链接交集，得到有效产品被收录的数量
        $product_urls = Product::query()->pluck('url_key')->toArray();
        if (!isset($product_urls[0])) {
            return 0;
        }
        $intersection = array_intersect($links, $product_urls);
        $intersectionCount = count($intersection);
        return round(($intersectionCount / count($product_urls)) * 100, 2);
    }


    /**
     * 返回产品收录率数据
     * @param $start_date
     * @param $end_date
     * @return array
     */
    protected function productIndexLinkRateData($start_date = '', $end_date = '')
    {
        $data = [];
        $times = $this->getTimes($start_date, $end_date);
        foreach ($times as $time) {
            $links = IndexLink::query()->where([
                'status' => 1,
                'type' => 'App\Modules\Product\Models\Product'
            ])->where('collected_date', '<=', date('Ymt', strtotime($time)))->pluck('link')->toArray();
            $data['times'][] = $time;
            if (!isset($links[0])) {
                $data['rate'][] = 0;
                continue;
            }
            //获取收录链接数量和现有产品链接交集，得到有效产品被收录的数量
            $product_urls = Product::query()->where('add_date', '<=', str_replace('-', null, $time))->pluck('url_key')->toArray();
            if (!isset($product_urls[0])) {
                $data['rate'][] = 0;
                continue;
            }
            $intersection = array_intersect($links, $product_urls);
            $intersectionCount = count($intersection);
            $data['rate'][] = round(($intersectionCount / count($product_urls)) * 100, 2);
        }
        return $data;
    }

    /**
     * 获取关键词排名，根据时间筛选
     * @return array
     */
    protected function rankData($start_date = '', $end_date = '')
    {
        $data = [];
//        $times = [];
//        $one_data = [];
//        $two_data = [];
//        $three_data = [];
        if (!in_array('Keywords',app('myAddons'))){
            return  $data;
        }
        $times = $this->getTimes($start_date, $end_date);

        foreach ($times as $time) {
            $one_count = 0; //第一页排名1-10
            $two_count = 0; //第二页排名11-20
            $three_count = 0; //第三页排名20-30

            $start_at = $time . '-01';
            $end_at = date('Y-m-t', strtotime($time));

            $tag_data = Keyword::query()->with(['ranks'=>function($query){
                $query->orderByDesc('id');
            }])->whereHas('ranks', function ($query) use ($start_at, $end_at) {
                $query
                // ->whereBetween('check_date', [$start_at, $end_at])
                ->where('check_date','<=',$end_at)
                ->orderByDesc('check_date');
            })->where('is_rank', 1)->orderBy('current_rank')->get();
            if (isset($tag_data[0])) {
                foreach ($tag_data as $tag_datum) {
                    if (isset($tag_datum->ranks[0])) {
                        if ($tag_datum->ranks[0]['rank'] >= 1 && $tag_datum->ranks[0]['rank'] <= 10) {
                            $one_count++;
                            continue;
                        }
                        if ($tag_datum->ranks[0]['rank'] >= 11 && $tag_datum->ranks[0]['rank'] <= 20) {
                            $two_count++;
                            continue;
                        }
                        if ($tag_datum->ranks[0]['rank'] >= 21 && $tag_datum->ranks[0]['rank'] <= 30) {
                            $three_count++;
                        }
                    }

                }
            }

            $data['times'][] = str_replace('-', '.', $time);
            $data['one_data'][] = $one_count;
            $data['two_data'][] = $two_count;
            $data['three_data'][] = $three_count;
        }
        return $data;
    }

    /**
     * 产品分类下产品收录比例
     * @param $start_date
     * @param $end_date
     */
    protected function productCategoryIndexRateData()
    {
        $data = [];
        $product_categories = ProductCategory::query()->with(['products'])->get();
        $links = IndexLink::query()->where('status', 1)->pluck('link')->toArray();
        foreach ($product_categories as $product_category) {
            $product_urls = array_column($product_category->products->toArray(), 'url_key');
            if (isset($product_urls[0])) {
                $intersection = array_intersect($links, $product_urls);
                $intersectionCount = count($intersection);
                if ($intersectionCount > 0) {
                    $data[] = [
                        'product_category_name' => $product_category->name,
                        'url_key' => $product_category->url_key,
                        'index_count' => $intersectionCount . '/' . count($product_urls),
                        'rate' => round(($intersectionCount / count($product_urls)) * 100, 2),
                    ];
                }
            }
        }
        $rates = array_column($data, 'rate');
// 使用 array_multisort() 进行排序
        array_multisort($rates, SORT_DESC, $data);

        $html = View::make('components.admin.rate-loading',compact('data'))->render();
        return $html;
    }


    /**
     * 询盘每月累计数量
     * @param $start_date
     * @param $end_date
     * @return array
     */
    protected function inquiryData($start_date = '', $end_date = '')
    {
        $data = [];
        $times = $this->getTimes($start_date, $end_date);
        foreach ($times as $time) {
// 创建 DateTime 对象，设置为指定日期
            $date = new \DateTime($time);
// 增加一个月
            $date->add(new \DateInterval('P1M')); // P1M 表示增加一个月
// 获取加一后的日期
            $nextMonth = $date->format('Y-m-d');
            $data['times'][] = str_replace('-', '.', $time);
            $data['data'][] = Inquiry::query()->where('created_at', '<', $nextMonth)->count();
        }
        return $data;
    }

    /**
     * 每月询盘数量
     * @param $start_date
     * @param $end_date
     * @return array
     */
    protected function inquiryDataByMonth($start_date = '', $end_date = '')
    {
        $data = [];
        $times = $this->getTimes($start_date, $end_date);
        foreach ($times as $time) {
            $data['times'][] = str_replace('-', '.', $time);
            $data['data'][] = Inquiry::query()->where('add_date', str_replace('-', null, $time))->count();
        }
        return $data;
    }


    protected function getTimes($start_date, $end_date)
    {
        $times = [];
        if ($start_date && $end_date) {
            $times[] = date('Y-m', strtotime($start_date));
            for ($i = 0; $i < 100; $i++) {
                if (last_month(end($times)) <= $end_date) {
                    $times[] = last_month(end($times));
                } else {
                    break;
                }
            }
        } else {
            for ($i = 11; $i >= 0; $i--) {
                $time = getMonth(date('Y-m-d'),$i);
                $times[] = $time;
            }
        }
        return $times;
    }

    protected function inquiryCountryRate($start_date = '', $end_date = '')
    {
        $data = [];
        $inquiries = Inquiry::query()->selectRaw('msg_country,count(*) as count')->orderByDesc('count')->groupBy('msg_country')->get()->toArray();
        foreach ($inquiries as $inquiry) {
            $data[] = [
                'name' => $inquiry['msg_country'],
                'value' => $inquiry['count'],
            ];
        }
        if (count($data) > 10){
            $count = 0;
            foreach ($data as $k=>$datum){
                if ($k > 9){
                    $count+= $datum['value'];
                    unset($data[$k]);
                }
            }
            $data[9]['name'] = '其他';
            $data[9]['value'] = $count;
        }
        return $data;
    }


    /**
     * 获取内容数量统计
     * @param $start_date
     * @param $end_date
     * @return array|array[]
     */
    protected function contentData($start_date = '', $end_date = '')
    {
        $times = $this->getTimes($start_date, $end_date);
        $data = [
            'product' => [],
            'product_category' => [],
            'product_tag' => [],
            'product_video' => [],
            'article' => [],
            'times' => [],
            'product_score' => [],
            'product_category_score' => [],
            'keywords_rate' => [],
        ];
        foreach ($times as $time) {
            $data['product'][] = Product::query()->active()->where('created_at', '<', date('Y-m-t', strtotime($time)))->count();
            $data['product_category'][] = ProductCategory::query()->where('created_at', '<', date('Y-m-t', strtotime($time)))->count();
            $data['product_tag'][] = ProductTag::query()->where('created_at', '<', date('Y-m-t', strtotime($time)))->count();
            $countData = ReportController::countData(date('Y-m-t', strtotime($time)));
            $data['product_video'][] = $countData['video_count'];
            $data['article'][] = $countData['news_count'];
            $data['times'][] = str_replace('-', '.', $time);
            if (in_array('OperationalScore', app('myAddons'))) {
                $product_scores = DB::table('operational_scores')->where(['status' => 1, 'type' => 'active_products_count'])->where('add_date', 'like', str_replace('-', null, $time) . '%')->select(['score'])->pluck('score')->toArray();
                $product_category_scores = DB::table('operational_scores')->where(['status' => 1, 'type' => 'active_product_categories_count'])->where('add_date', 'like', str_replace('-', null, $time) . '%')->select(['score'])->pluck('score')->toArray();
                $product_tag_scores = DB::table('operational_scores')->where(['status' => 1, 'type' => 'active_product_tags_count'])->where('add_date', 'like', str_replace('-', null, $time) . '%')->select(['score'])->pluck('score')->toArray();
                if ($product_scores) {
                    $data['product_score'][] = array_sum($product_scores) / count($product_scores) * 20;
                } else {
                    $data['product_score'][] = 0;
                }
                if ($product_category_scores) {
                    $data['product_category_score'][] = array_sum($product_category_scores) / count($product_category_scores) * 20;
                } else {
                    $data['product_category_score'][] = 0;
                }
                if ($product_tag_scores) {
                    $data['keywords_rate'][] = array_sum($product_tag_scores) / count($product_tag_scores);
                } else {
                    $data['keywords_rate'][] = 0;
                }
            } else {
                $data['product_score'][] = 0;
                $data['product_category_score'][] = 0;
                $data['keywords_rate'][] = 0;
            }
        }
        return $data;
    }

    /**
     * 产品相关
     * @param $start_date
     * @param $end_date
     * @return array|array[]
     */
    protected function productData($start_date = '', $end_date = '')
    {
        if (!in_array('OperationalScore', app('myAddons'))) {
            return [
                'product_weight' => [],
                'product_keyword_weight' => [],
                'product_content_link_weight' => [],
                'product_img_alt_weight' => []
            ];
        }
        $times = $this->getTimes($start_date, $end_date);
        $types = [
            'product_weight', 'product_keyword_weight',
            'product_content_link_weight', 'product_img_alt_weight'
        ];
        $data = [
            'product_weight' => [],
            'product_keyword_weight' => [],
            'product_content_link_weight' => [],
            'product_img_alt_weight' => []
        ];
        foreach ($times as $time) {
            $data['times'][] = str_replace('-', '.', $time);
            foreach ($types as $type) {
                $models = DB::table('operational_scores')->where(['status' => 1, 'type' => $type])->where('add_date', 'like', str_replace('-', null, $time) . '%')->select(['data'])->pluck('data')->toArray();
                if ($models) {
                    $data[$type][] = $this->getNum($models);
                } else {
                    $data[$type][] = 0;
                }
            }
        }
        return $data;
    }

    protected function getNum($data)
    {
        $num = 0;
        foreach ($data as $datum) {
            $num += count(json_decode($datum, true)['data']);
        }
        if ($num > 0) {
            $num = round($num / count($data));
        }
        return $num;
    }

    /**
     * 运营指数历史得分
     * @return array
     */
    protected function operationalData($start_date = '', $end_date = '')
    {
        if (!in_array('OperationalScore', app('myAddons'))) {
            return [
                'times' => [],
                'data' => [],
            ];
        }
        $data = [];
        if ($start_date && $end_date) {
            $models = DB::table('operational_scores')->selectRaw('sum(score) as score,add_date')
                ->where('status', 1)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->groupBy('add_date')
                ->get()->toArray();
        } else {
            $models = DB::table('operational_scores')->selectRaw('sum(score) as score,add_date')
                ->where('status', 1)
                ->groupBy('add_date')
                ->get()->toArray();
        }

        foreach ($models as $model) {
            $data['times'][] = str_insert(str_insert($model->add_date, '.', 4), '.', 7);
            $data['data'][] = $model->score;
        }
        return $data;
    }


    /**
     * 获取国家浏览量图表数据
     * @return array
     */
    protected function countryReport()
    {
        $data = [];
        if (Schema::hasTable('website_reports')){
            $report = WebsiteReport::query()->where('type', 6)->first();
            if ($report) {
                $report_data = json_decode($report->data, true);
                if (isset($report_data['data'][0])) {
                    $count = 0;
                    foreach ($report_data['data'] as $k => $report_datum) {
                        $data[] = [
                            'rank' => $k + 1,
                            'name' => $report_datum['name'],
                            'view_count' => isset($report_datum['activeUsers'])?$report_datum['activeUsers']:0,
                        ];
                        $count += $report_datum['value'];
                    }

                    foreach ($data as $k => $datum) {
                        $data[$k]['rate'] = round(($datum['view_count'] / $count) * 100, 2);
                    }
                    $data = custom_multisort($data,'view_count');
                }
            }
        }
        return $data;
    }


    public static function changeKeywordsData($keywordsData)
    {
        foreach ($keywordsData as $key => $data) {
            $discrepancy = [
                'catch_url' => '',
                'type' => '', //up上升，down下降
                'num' => 0,
                'check_date' => '',
            ];
            if (isset($data->productRanks[0])) {
                $discrepancy['catch_url'] = $data->productRanks[0]['catch_url'];
                $discrepancy['check_date'] = $data->productRanks[0]['check_date'];

                if (strstr($data->productRanks[0]['snapshot'],'snapshot.dyyweb.com')){
                    $discrepancy['snapshot'] = trim($data->productRanks[0]['snapshot'],'/');
                }else{
                    $discrepancy['snapshot'] = self::SNAPSHOT_URL.trim($data->productRanks[0]['snapshot'],'/');
                }
                if (isset($data->productRanks[1]) && $data->productRanks[0]['rank'] > 0 && $data->productRanks[1]['rank'] > 0) { //之前有排名且排名有效
                    if ($data->productRanks[0]['rank'] > $data->productRanks[1]['rank']) {
                        $discrepancy['type'] = 'down';
                        $discrepancy['num'] = $data->productRanks[0]['rank'] - $data->productRanks[1]['rank'];
                    } else {
                        if ($data->productRanks[1]['rank'] > $data->productRanks[0]['rank']) {
                            $discrepancy['type'] = 'up';
                            $discrepancy['num'] = $data->productRanks[1]['rank'] - $data->productRanks[0]['rank'];
                        }
                    }
                }
            }
            $keywordsData[$key]['discrepancy'] = $discrepancy;
        }
        return $keywordsData;
    }

}
