<?php


namespace App\Modules\Admin\Controllers;


use App\Models\Notice;
use App\Modules\Admin\Models\AdminLog;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends BaseController
{

    public function __construct(Setting $setting){
        $this->modelSource = $setting;
        $this->model = $setting;
        $this->modelName = 'Setting';
    }

    public function getNotice($id){
        $notice = Notice::query()->findOrFail($id);
        return view('Setting.Views.setting.notice',compact('notice'));
    }

    public function renew(){
        return view('Setting.Views.setting.renew');
    }

    public function index()
    {
        if (!file_exists(storage_path('locales.txt'))) {
            try {
                $locales = Cache::remember('remote_locales', 86400, function () {
                    $result = Http::withHeaders(['token' => 'D$%(xEL5$$6RXpp'])
                        ->timeout(3)
                        ->post('http://developers.dyyweb.com/api/getLocale');

                    if ($result->successful()) {
                        return $result->json()['data'];
                    }
                    return null;
                });

                if ($locales) {
                    file_put_contents(storage_path('locales.txt'), json_encode($locales));
                }
            } catch (\Exception $e) {
                Log::error('Failed to fetch locales: ' . $e->getMessage());
            }

            // Ensure file exists to prevent repeated blocking attempts on failure
            if (!file_exists(storage_path('locales.txt'))) {
                file_put_contents(storage_path('locales.txt'), json_encode([]));
            }
        }
        $data = $this->checkTranslate(1);
        $nums = [
            'tag_max_num'=>'tag输入框最大数量',
            'category_product_num' => '分类下产品显示个数',
            'product_list_num' =>'产品列表显示个数',
            'article_list_num'=> '文章列表显示个数',
            'sidebar_blog_category_num' =>'侧边栏博客分类显示个数',
            'sidebar_blog_num' =>'侧边栏博客显示个数',
            'sidebar_blog_tag_num' =>'侧边栏博客关键词个数',
            'header_menu_product_category_num' =>'导航栏产品分类显示个数',
            'blog_list_num'=> '博客列表显示个数',
            'project_case_list_num'=> 'Project Case列表显示个数',
            'faq_list_num'=> 'Faq列表显示个数',
            'product_search_list_num'=> '产品搜索页显示个数',
            'related_product_num'=> '相关产品显示个数',
            'related_article_num'=> '相关文章显示个数',
            'sidebar_product_category_num'=> '侧边栏产品分类显示个数',
            'sidebar_new_product_num'=> '侧边栏最新产品显示个数',
            'hot_product_list_num'=> 'hot产品数量',
            'recommend_product_num'=> '推荐产品数',
            'product_tag_num'=> '产品关键词数',
            'link_num'=> '友情链接显示个数',
        ];
        if (!file_exists(storage_path('robots.txt'))) {
            file_put_contents(storage_path('robots.txt'), "");
        }
        $robots = file_get_contents(storage_path('robots.txt'));
        if ($robots === false) {
            $robots = '';
        }
        $data = array_merge($data,[
            'ban_ips' => $data['model']->ban_ips??json_encode([]),
            'ban_emails' => $data['model']->ban_emails??json_encode([]),
            'ban_access_ips' => $data['model']->ban_access_ips??json_encode([]),
            'allow_ips' => $data['model']->allow_ips??json_encode([]),
            'robots' => $robots,
            'nums' => $nums,
            'sensitive_words' => $data['model']->sensitive_words??json_encode([]),
            'banner_areas' => $data['model']->banner_areas??json_encode([]),
        ]);
        $data['setting'] = $data['model'];
        unset($data['model']);
        return view('Setting.Views.setting.edit', $data);
    }


    public function reload(Request $request)
    {
        $setting = Setting::first();
        $translate = $request->get('translate');
        if ($request->get('chat_token')){
            if (!$request->get('nocaptcha_sitkey') || !$request->get('nocaptcha_secret')){
                return $this->badRequest('请填写验证码配置');
            }
        }
        if ($request->get('ico')){
            try {
                Storage::disk('disk')->put('public/favicon.ico',file_get_contents(public_path($request->get('ico'))));
            }catch (\ErrorException $errorException){

            }
        }
        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        if (isset($update['robots'])){
            $robots = $update['robots'];
            unset($update['robots']);
            file_put_contents(storage_path('robots.txt'),$robots);
        }
        try {
            if (isset($update['sensitive_words'])){
                $sensitive_words = $update['sensitive_words']??[];
                $sensitive_words =  array_values(array_unique(array_map('strtolower',$sensitive_words)));
                $update['sensitive_words'] = $sensitive_words;
            }
            $fields = [
                'banner_areas','ban_ips','allow_ips','ban_access_ips','ban_emails'
            ];
            foreach ($fields as $field){
                if (isset($update[$field])){
                    $update[$field] = array_values(array_unique($update[$field]))??[];
                }
            }
            $setting->update($update);
            AdminLog::log([
                'name' => date('Y-m-d H:i:s').' 用户'.$request->user()->email.'保存设置',
                'modelName'=> $this->modelName,
                'content' => json_encode($request->all())
            ]);
        } catch (\PDOException $exception) {
            Log::error('Setting:reload:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }
    public function clearCache()
    {
        Artisan::call('optimize:clear');
        return view('Admin.Views.Notify.success');
    }



}
