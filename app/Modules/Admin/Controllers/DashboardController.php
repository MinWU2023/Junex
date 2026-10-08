<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\User;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Menu\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Addons\AdminMultilingual\Config\Translates;

class DashboardController extends BaseController
{
    //
    public function index()
    {
        if (!Cache::has('use_size')){
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
            $use_size = round($size + $websiteSize + $fileSize, 2);
            Cache::put('use_size',$use_size,now()->addDays());
        }else{
            $use_size = Cache::get('use_size');
        }
        $size_status = false;
        if ($use_size >= app('settings')['setting']->max_size){
            $size_status = true;
        }
        //$size_status = true;
        return view('Admin.Views.dashboard',compact('size_status'));
    }


    public function getSizeContent()
    {
        $use_size = Cache::get('use_size');
        $size_content = View::make('components.admin.size-label',[
            'use_size'  => $use_size
        ])->render();
        return $size_content;
    }

    public function openLanguage(){
        $website_info = json_decode(app('settings')['setting']->website_info,true);
        return view('Admin.Views.language',compact('website_info'));
    }



    public function syncLocale()
    {
        $result = Http::withHeaders(['token' => 'D$%(xEL5$$6RXpp'])->post('http://developers.dyyweb.com/api/getLocale');
        if ($result->successful()){
            file_put_contents(storage_path('locales.txt'),json_encode($result->json()['data']));
            return response()->json([
                'status' => true,
                'msg' => '获取成功',
                'code' => 0
            ]);
        }
        return response()->json([
            'status' => false,
            'msg' => '获取失败,请联系管理员查看',
            'code' => 0
        ]);
    }

    public function keeplive()
    {
        return 'ok';
    }



    public function globalcolor($color){
        $setting = app('settings')['setting'];
        $setting->global_color = $color;
        $setting->save();

        $menus = make_tree(Menu::all()->toArray());
        $default_background = 'background:#101427!important;';
        $default_color = 'color:rgba(255,255, 255,0.7)';
        $default_class = 'layui-side layui-side-menu layui-side-black';
        switch ($color){
            case 'blue':
                $default_background = 'background:#656EE6!important';
                $default_color = 'color:rgba(255,255, 255,0.8)';
                $default_class = 'layui-side layui-side-menu layui-side-blue';
                break;
            case 'white':
                $default_background = 'background:#fff!important';
                $default_color = 'color:rgba(0,0, 0,0.7)';
                $default_class = 'layui-side layui-side-menu layui-side-white wz-black';
                break;
            case 'grey':
                $default_background = 'background:#f6f8fc!important';
                $default_color = 'color:rgba(0,0, 0,0.7)';
                $default_class = 'layui-side layui-side-menu layui-side-grey wz-black';
                break;
        }
        $scroll_html = View::make('components.admin.layui-side-scroll',[
            'menus' => $menus,
            'default_background' => $default_background,
            'default_color' => $default_color,
            'default_class' => $default_class,
        ])->render();
        return $this->data($scroll_html);
    }

    public function changePassword(){
        return \view('Admin.Views.changePassword');
    }


    public function changePasswordUpdate(Request $request){
        $password = $request->get('password');
        $password_confirmation= $request->get('current_password');
        if (\auth()->user()->id === 2){
            if ($password && $password === $password_confirmation){
                $admin = User::query()->find(2);
                $admin->password = bcrypt($password);
                $admin->save();
                return  $this->success();
            }
        }
        return  $this->badRequest('system error');

    }

    public function translationsJs(Request $request)
    {
        $translations = [];
        // 判断 Addons\AdminMultilingual\Config\Translates 是否存在
        if (file_exists(base_path('addons/AdminMultilingual/Config/Translates.php'))) {
            $translations = (new Translates)->allTranslate();
        }
        $etag = md5(json_encode($translations));

        // 检查If-None-Match头，如果匹配则返回304
        if ($request->header('If-None-Match') === $etag) {
            return response('', 304);
        }

        $jsContent = "window.translations = " . json_encode($translations, JSON_UNESCAPED_UNICODE) . ";\n";
        $jsContent .= "function __(val) {\n";
        $jsContent .= "    return window.translations[val] ? window.translations[val] : val;\n";
        $jsContent .= "}";

        return response($jsContent)
            ->header('Content-Type', 'application/javascript; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600') // 缓存1小时
            ->header('ETag', $etag); // 添加ETag支持
    }
}
