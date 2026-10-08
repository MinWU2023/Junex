<?php
namespace App\Services;

use App\Modules\AddonsMarket\Models\Addon;
use App\Modules\Article\Models\Article;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Product\Models\Product;
use App\Modules\SiteCount\Models\SiteCount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportService {

    public static function reportData()
    {
        $products = Product::where('created_at', '>=', date('Y-01-01 00:00:00'))->get();
        $inquirys = Inquiry::where('created_at', '>=', date('Y-01-01 00:00:00'))
            ->whereHas('users',function ($query){
                $query->where(['user_id'=>Auth::id(),'is_del'=>0]);
            })->get();
        $articles = Article::where('created_at', '>=', date('Y-01-01 00:00:00'))->get();
        $siteCounts = SiteCount::query()->where('type',3)->orderByDesc('check_date')->limit(10)->get();
        $data = [];
        $data['product_total'] = Product::count();
        $data['inquiry_total'] = Inquiry::whereHas('users',function ($query){
            $query->where(['user_id'=>Auth::id(),'is_del'=>0]);
        })->count();
        $data['article_total'] = Article::count();
        $last_site= SiteCount::query()->orderByDesc('check_date')->where('type',3)->first();
        if ($last_site){
            $data['siteCount_total']=  $last_site->data;
        }else{
            $data['siteCount_total']=  0;
        }
        $data['last12MonthProduct'] = [];
        $data['last12MonthInquiry'] = [];
        $data['last12MonthArticle'] = [];
        $data['last12SiteCount'] = array_column($siteCounts->toArray(),'data','check_date');
        foreach ($products as $key => $product) {
            $data['last12MonthProduct'][intval(date('m', strtotime($product->created_at)))][] = $key;
        }
        foreach ($inquirys as $key => $inquiry) {
            $data['last12MonthInquiry'][intval(date('m', strtotime($inquiry->created_at)))][] = $key;
        }
        foreach ($articles as $key => $article) {
            $data['last12MonthArticle'][intval(date('m', strtotime($article->created_at)))][] = $key;
        }
        foreach ($data["last12MonthProduct"] as $k => $datum) {
            $data["last12MonthProduct"][$k] = count($datum);
        }
        foreach ($data["last12MonthInquiry"] as $k => $datum) {
            $data["last12MonthInquiry"][$k] = count($datum);
        }
        foreach ($data["last12MonthArticle"] as $k => $datum) {
            $data["last12MonthArticle"][$k] = count($datum);
        }
//        foreach ($data["last12SiteCount"] as $k => $datum) {
//            $data["last12SiteCount"][$k] = array_sum(array_values($datum));
//        }
        $data['last12MonthProduct'] = fu_null_val($data['last12MonthProduct']);
        $data['last12MonthInquiry'] = fu_null_val($data['last12MonthInquiry']);
        $data['last12MonthArticle'] = fu_null_val($data['last12MonthArticle']);
//        $data['last12SiteCount'] = fu_null_val($data['last12SiteCount']);
        ksort($data['last12MonthProduct']);
        ksort($data['last12MonthInquiry']);
        ksort($data['last12MonthArticle']);
        ksort($data['last12SiteCount']);

        $data['is_report_addons'] =Addon::where(['sign'=>'WebsiteReport','status'=>1])->first() ? true:false;
//  dd($data['last12SiteCount']);
        $base_data = json_encode($data);
        $website_info = app('settings')['setting']->website_info;
        if ($website_info){
            $website_info = json_decode($website_info,true);
            $website_info['expiration_day'] = before_day($website_info['expiration_time']);
        }
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
//    dd($base_data);
        return ['base_data'=>$base_data,'website_info'=>$website_info,'site_count_data'=>$site_count_data];
    }

}
