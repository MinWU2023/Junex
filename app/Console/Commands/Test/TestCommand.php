<?php

namespace App\Console\Commands\Test;

use Addons\AdminMultilingual\Model\AdminMultilingual;
use Addons\Keywords\Models\ProductTagRank;
use Addons\Multilingual\Models\Multilingual;
use Addons\OperationalScore\Constant\Constant;
use Addons\WebsiteReport\Models\SessionTotal;
use Addons\WebsiteReport\Models\WebsiteReport;
use Addons\Woodpecker\Models\Woodpecker;
use App\Imports\CommonImport;
use App\Models\IndexLink;
use App\Models\LoginLog;
use App\Modules\AddonsMarket\Models\Addon;
use App\Modules\Admin\Models\AdminLog;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Admin\Models\User;
use App\Modules\Article\Models\Article;
use App\Modules\Article\Models\ArticleCategory;
use App\Modules\FileInfo\Models\FileInfo;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Inquiry\Models\Newsletter;
use App\Modules\Menu\Models\Menu;
use App\Modules\Page\Models\Page;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductBrand;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductImage;
use App\Modules\Product\Models\ProductTag;
use App\Modules\Report\Controllers\DataManagerController;
use App\Modules\Report\Controllers\ReportController;
use App\Modules\Setting\Models\Locale;
use App\Modules\Setting\Models\Setting;
use App\Modules\Url\Models\Url;
use App\Observers\NewsletterObserver;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Permission;
use App\Modules\Download\Models\DownloadCategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;
use App\Services\GibberishDetectionService;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

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


    protected function createProductTag($product, $tag_names)
    {
        $tagIds = [];
        if (isset($tag_names[0])){
            foreach ($tag_names as $sort=>$tag_name) {
                if ($tag_name = merge_spaces($tag_name)) {
                    $productTag = ProductTag::whereTranslation('name', $tag_name)->first();
                    if ($productTag){
                        $productTag->name = $tag_name;
                        $productTag->save();
                    }else{
                        $productTag = ProductTag::create([
                            'url_key' => Str::slug($tag_name, '-', config('app.locale')),
                            'sort' => 0,
                            config('app.locale') => [
                                'name' => $tag_name
                            ]
                        ]);
                    }
                    $tagIds[$productTag->id] = ['sort'=>100-$sort];
                }
            }
            $product->productTags()->sync($tagIds);
        }
        return true;
    }

    protected function createProductImage(Product $product, $images)
    {
        DB::table('product_images')->where('product_id',$product->id)->delete();
        foreach ($images as $k=>$image){
            $add = [];
            $add['product_id'] = $product->id;
            $add['path'] = 'storage/uploads/'.trim($image,'/');
            $add['is_main'] = 0;
            if ($k == 0){
                $add['is_main'] = 1;
            }
            $add['sort'] = 999-$k;
            $add['alt'] = $product->name;
            ProductImage::create($add);
        }

    }

    public static function getProductPermissionIds(){
        $group_names = [
            '产品分类管理','产品品牌管理','关键词数据管理','产品属性管理','产品管理','主页','营销管理','相册管理',
        ];
        $permission_names = [
            'admin.menu.dashboard.visibility','admin.menu.product.visibility','admin.menu.marketing.visibility','admin.menu.information.visibility'
        ];
        $pg_ids = array_column(DB::table('permission_groups')->select(['id'])->whereIn('name',$group_names)->get()->toArray(),'id');
        $permission_ids = array_column(DB::table('permissions')->select(['id'])->whereIn('pg_id',$pg_ids)->get()->toArray(),'id');
        $p_ids = array_column(DB::table('permissions')->select(['id'])->whereIn('name',$permission_names)->get()->toArray(),'id');
        $permission_ids  = array_unique(array_merge($permission_ids,$p_ids));
        sort($permission_ids);
        return $permission_ids;
    }


    public static function getChildrenIds(&$cate_ids,$id)
    {
        $children = ArticleCategory::query()->where('parent_id',$id)->first();
        if ($children){
            $cate_ids[] = $children->id;
            self::getChildrenIds($cate_ids,$children->id);
        }

    }
    protected static function newUrl(&$url_key, $id)
    {
        $repeat = Url::where([
            'url' => $url_key,
        ])->where('urlable_id', '<>', $id)
            ->first();
        if ($repeat) {
            $url_key = $url_key . '-' . rand(1, 1000);
            self::newUrl($url_key, $id);
        }
    }


    protected function saveVideo($path)
    {
        $new_folder = 'storage/uploads/videos/'.date('Ym/d');
        if (!file_exists(public_path($new_folder))) {
            mkdir(public_path($new_folder), 0755, true);
        }
        $new_name = md5(uniqid().date('YmdHis')) . '.mp4';
        file_put_contents(public_path($new_folder.'/'.$new_name),file_get_contents($path));
        return $new_folder.'/'.$new_name;
    }

    public function handle()
    {
        $models = Inquiry::get();
        foreach($models as $model){
            $gibberishService = app(GibberishDetectionService::class);
            $score = $gibberishService->calculateGibberishScore($model->content);
            $model->gibberish_score = $score['score'];
            $model->gibberish_details = $score['details'];
            $model->save();
        }
        dd('ok');

        $content = 'uXTfWlhbRdgcg';
        $gibberishService = app(GibberishDetectionService::class);
        $score = $gibberishService->calculateGibberishScore($content);
        dd($score);

        $add = [

            'zh-CN' => [
                'name' => 'hehehehhee',
            ],
        ];

        AdminMultilingual::create($add);
        dd(1);

        $temp = AdminMultilingual::query()->first();
        dd($temp->translate());

//         Url::onlyTrashed()->whereIn('urlable_type',['App\Modules\Product\Models\ProductCategory','App\Modules\Download\Models\DownloadCategory'])->forceDelete();
// dd(1234);
        $models = ProductCategory::get();
        foreach($models as $model){
            Url::query()->lockForUpdate()->updateOrCreate([
                'url' => $model->url_key,
                'urlable_type' => 'App\Modules\Product\Models\ProductCategory',
                'urlable_id' => $model->id
            ]);
        }
        $models = DownloadCategory::get();
        foreach($models as $model){
            Url::query()->lockForUpdate()->updateOrCreate([
                'url' => $model->url_key,
                'urlable_type' => 'App\Modules\Download\Models\DownloadCategory',
                'urlable_id' => $model->id
            ]);
        }
        dd(1243);
        $str = Str::slug('100M Unmanaged PoE Switches');
        dd($str);

        // $user = User::query()->find(1);
        // $user->password = Hash::make('密码');
        // $user->save();
//         dd(11);
//         $str =  Str::slug('PCB 工厂','-','zh-CN');
//         dd($str);
//         $category = ProductCategory::with(['children'])->find(4);
//         $ids = [4,18,19];
//         foreach ($category->children as $child){
//             $ids[] = $child->id;
//         }
//         $json =   DB::table('product_product_category')->whereIn('product_category_id',$ids)->select(['product_id','product_category_id'])->get()->toJson();
//         file_put_contents(storage_path('product_product_category.json'),$json);
//         dd($json);

//         dd('1234');
//         $res =  Http::post('https://api.crm.dyyseo.com/api/inquiry',[
//             'token' => app('settings')['setting']->website_id,
//             'content' => 'test inquiry',
//         ]);
// dd($res->status());
        $targetDir  = base_path('addons/'. \Addons\Keywords\Constant\Constant::APP_SIGN.'/public');
        $linkDir = base_path('public/addons/' . \Addons\Keywords\Constant\Constant::APP_SIGN);
// 检查是否具有足够的权限以及目标目录是否存在
        if (is_dir($targetDir)) {
            // 创建目录符号链接
            exec("mklink /D \"$linkDir\" \"$targetDir\"", $output, $return);

            if ($return === 0) {
                echo "符号链接创建成功。\n";
            } else {
                echo "符号链接创建失败。\n";
            }
        } else {
            echo "目标目录不存在。\n";
        }
        dd(121);
        dd(app('settings')['setting']->website_id);
        Schema::dropIfExists('ai_videos');
        sleep(1);
        Schema::create('ai_videos',function (Blueprint  $table){
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('选择产品');
            $table->string('subject')->comment('标题');
            $table->string('language')->comment('语言');
            $table->text('script')->comment('文案');
            $table->string('terms')->comment('关键词');
            $table->string('source')->comment('来源');
            $table->string('transition_mode')->comment('转场模式');
            $table->text('materials')->nullable()->comment('本地素材');
            $table->string('aspect')->default('9:16')->comment('视频比例');
            $table->string('voice_name')->comment('朗读声音');
            $table->string('path')->nullable()->comment('视频链接');
            $table->boolean('status')->default(0)->comment('状态,0等待生成,1生成成功,2生成失败');
            $table->boolean('is_del')->default(0)->comment('已删除');
            $table->unsignedBigInteger('source_id')->default(0)->comment('源id');
            $table->timestamps();
        });
dd(22);
        dd(parse_url(url('/'))['host']);
        $models = AiVideo::query()->where([
            'status'=> 0,
            'is_del' => 0,
        ])->get();
        foreach ($models as $model){
            try {
                $response = Http::asJson()->get('http://5.188.231.184:8080/api/v1/tasks/'.$model->task_id);
                if ($response->successful()){
                    $result = $response->json();
                    if ($result['data']['state'] == 1){
                        $model->path = $this->saveVideo($result['data']['videos'][0]);
                        $model->status = 1;
                        $model->save();
                    }else{
                        if (time()-$model->push_at > 3600){
                            $model->status = 2;
                            $model->save();
                        }
                    }
                }
            }catch (\Exception $exception){
                Log::error('拉取视频失败,错误原因:'.$exception->getMessage());
            }
        }

dd(22);
//        $file = app()->make(Filesystem::class);
//        $file->link('../../addons/' . \Addons\AiVideo\Constant\Constant::APP_SIGN . '/public', base_path('public/addons/' . Constant::APP_SIGN));
////        dd(22);

        $targetDir  = base_path('addons/'. \Addons\AiVideo\Constant\Constant::APP_SIGN.'/public');
        $linkDir = base_path('public/addons/' . \Addons\AiVideo\Constant\Constant::APP_SIGN);
// 检查是否具有足够的权限以及目标目录是否存在
        if (is_dir($targetDir)) {
            // 创建目录符号链接
            exec("mklink /D \"$linkDir\" \"$targetDir\"", $output, $return);

            if ($return === 0) {
                echo "符号链接创建成功。\n";
            } else {
                echo "符号链接创建失败。\n";
            }
        } else {
            echo "目标目录不存在。\n";
        }

        dd(22);

        $data = config('multilingual')['product'];
        dd(method_exists($data['model'],'scopeActive'));

//        AiVideo::query()->create([
//            'product_id' => 1,
//            'task-id' => 'e84ffb36-cfcf-48ce-8973-9f578572eae9',
//            'subject'=> 'Anti-slip Breathable Backless Ankle Sock for Yoga Pilates and Dance',
//            'language' => 'zh-CN',
//            'script' => '这款无跟防滑透气瑜伽袜，专为瑜伽、普拉提和舞蹈设计。采用高弹力面料，贴合脚部曲线，提供良好的支撑和保护。底部增加防滑纹理，有效防止运动中滑倒。透气网眼设计，保持脚部干爽舒适。无论是室内还是户外，都能让您尽情享受运动的乐趣。',
//            'terms' => 'Yoga Socks Anti-Slip,Breathable Dance Socks,Pilates Ankle Socks,Non-Slip Yoga Gear,Athletic Breathable Socks',
//            'source' => 'local',
//            'materials' => '[{"provider":"local","url":"http:\/\/new1.dyyweb.com\/storage\/uploads\/images\/202502\/27\/1740637331_D5MhEQ4mYX.jpg","duration":0},{"provider":"local","url":"http:\/\/new1.dyyweb.com\/storage\/uploads\/images\/202502\/27\/1740637332_5JBtHXJFXK.jpg","duration":0},{"provider":"local","url":"http:\/\/new1.dyyweb.com\/storage\/uploads\/images\/202502\/27\/1740637332_pykse13GCq.jpg","duration":0},{"provider":"local","url":"http:\/\/new1.dyyweb.com\/storage\/uploads\/images\/202502\/27\/1740637332_LPFqgrSADC.jpg","duration":0},{"provider":"local","url":"http:\/\/new1.dyyweb.com\/storage\/uploads\/images\/202502\/27\/1740637331_uk8MnlMylM.jpg","duration":0}]',
//            'aspect' => '16:9',
//            'voice_name' => 'zh-CN-YunjianNeural-Male',
//            'path' => 'storage/uploads/videos/202502/27/6af9d825edd7e9a34da820021568a99e.mp4',
//            'status' => 1,
//            'is_del' => 0
//        ]);
//dd(11);
        $videos = AiVideo::all();
        foreach ($videos as $video){
            $video->push_at = strtotime($video->created_at);
            $video->save();
        }
        dd(11);
        Schema::table('ai_videos',function (Blueprint  $table){
            $table->unsignedBigInteger('push_at')->nullable()->comment('推送时间');
        });
        dd(11);
        $user = User::query()->first();
        $user->password = Hash::make('firstpage');
        $user->save();
        dd('222');

        $ai = AiVideo::query()->orderByDesc('id')->first();
        $response = Http::asJson()->get('http://5.188.231.184:8080/api/v1/tasks/'.$ai->task_id);
        dd($response->json());
        dd(11);

        $model = Page::find(10);
        $url_key = Str::slug($model->name, '-', config('app.locale'));
        $urlable_type = 'App\Modules\Page\Models\Page';
        $repeat = Url::where([
            'url' => $url_key,
        ])->first();
        if ($repeat) {
            self::newUrl($url_key, $model->id);
        }
        dd($url_key);
        $model->url_key = $url_key;
        $model->save();
        Url::query()->updateOrCreate([
            'url'=> $url_key,
            'urlable_type'=> $urlable_type,
            'urlable_id'=> $model->id,
        ]);

        $count = Inquiry::query()->whereHas('users',function ($query){
                $query->where([
                    'user_id'=>1,
                    'is_del' => 0
                ]);
            })->count();
        $count2 =Inquiry::query()->whereHas('users',function ($query){
            $query->where([
                'user_id'=>1,
                'is_del' => 0
            ]);
        })->whereHas('reads',function ($query){
                $query->where('user_id',1);
            })->count();
        dd([
            'count' => $count,
            'count2' => $count2
        ]);

        $id=1;
        $cate_ids = [$id];
        self::getChildrenIds($cate_ids,$id);
        dd($cate_ids);

        $models = \Addons\Multilingual\Models\Multilingual::with(['translations'])->get();
        foreach ($models as $model){
            $model->name_en = $model->translate('en')->name;
            $model->save();
        }
        dd(app('settings')['setting']->switch_editor);
        $images = ProductImage::all();
        foreach ($images as $image) {
            $path = explode('.', $image->path);
            $source_name = $path[0] . '_' . md5('source') . '.' . $path[1];
            $webp_path = $path[0] . '.webp';
            $current_path =  $path[0]. '.' . $path[1];
            try {
                if (Storage::disk('disk')->exists('public/' . $image->path)) {
                    if (!Storage::disk('disk')->exists('public/' . $source_name)) {
                        Storage::disk('disk')->put('public/' . $source_name, file_get_contents(url($image->path)));
                    }
                    File::delete(public_path($current_path));
                    File::delete(public_path($webp_path));
                    if (app('settings')['setting']->watermark) {
                        Image::make(public_path($source_name))->insert(public_path(app('settings')['setting']->watermark), app('settings')['setting']->watermark_location, app('settings')['setting']->watermark_x, app('settings')['setting']->watermark_y)->save(public_path($image->path));
                    }else{
                        Image::make(public_path($source_name))->save(public_path($image->path));
                    }
//                    dd($image->path);
                }else{
                    $this->warn('图片'.$image->path.'未找到');
                }
            } catch (\Exception $exception) {
                $this->warn('图片'.$image->path.'生成水印失败,错误原因:'.$exception->getMessage());
            }
        }
        dd('success');
        $permission_ids = \App\Modules\Admin\Models\Permission::query()->whereIn('name',[
            'admin.translateJob.index',
            'admin.setting.clearCache'
        ])->pluck('id')->toArray();
        DB::table('role_has_permissions')->whereIn('permission_id',$permission_ids)->where('role_id','>',1)->delete();
dd('success');
        $theWebsiteRole = Role::query()->find(2);
        $websitePermissions = \Spatie\Permission\Models\Permission::query()->whereNotIn('pg_id', [
            2, 3, 4, 5, 6
        ])->whereNotIn('name', [
            'admin.translateJob.index',
            'admin.menu.manager.visibility',
            'admin.setting.clearCache'
        ])->pluck('id')->toArray();
        $theWebsiteRole->permissions()->sync($websitePermissions);
        dd(11);
        $res = Http::withHeaders(['token'=>'K0WOWzJTvGdqFUfAgwbk61Ou0ZMq3fBQ9rbOjbsJzlx0mgHqxauDMYkH5yfVZTjL'])->get('http://yin871.first-page.cn/api/cloud/websiteCan');
        dd($res->json());
        $admin = User::query()->find(2);
        dd($admin->can('admin.user.store'));
        $user->can('edit articles');

        $theRole = Role::findById(1);
        $permissions = \Spatie\Permission\Models\Permission::all();
        foreach ($permissions as  $permission) {
            $theRole->givePermissionTo($permission);
        }

        $theWebsiteRole = Role::findById(2);
        //赋予网站管理员基本权限
        $websitePermissions = \Spatie\Permission\Models\Permission::whereNotIn('pg_id',[
            2,3,4,5,6
        ])->where('name','<>','admin.menu.manager.visibility')->get();
        foreach ($websitePermissions as  $permission) {
            $theWebsiteRole->givePermissionTo($permission);
        }
        $role_ids = [1,2];
        $theProductAndContentRole = Role::query()->where('name','内容&产品管理员')->first();
        $theProductRole = Role::query()->where('name','产品管理员')->first();
        $theContentRole = Role::query()->where('name','内容管理员')->first();
        if ($theProductAndContentRole){
            $role_ids[] = $theProductAndContentRole->getKey();
        }
        if ($theProductRole){
            $role_ids[] = $theProductRole->getKey();
        }
        if ($theContentRole){
            $role_ids[] = $theContentRole->getKey();
        }

        $otherRoles = Role::query()->whereNotIn('id',$role_ids)->get();

        dd('success');
        dd(app('settings')['setting']->version);
        dd(strstr('123345','123'));
        dd(date('Ym',strtotime("-1month")));
        $robots = file_get_contents(storage_path('robots.txt'));
        if (strstr($robots,'Allow')){
            dd('success');
        }
        dd();
        if (strstr($robots,'Allow'))
        dd($robots);
        $count_data = ReportController::countData();
        $count_data_date = ReportController::countData(date('Y-m-t', strtotime("-1month")));
        $data['product_video_count'] = $count_data['video_count'];
        $data['product_video_count_last_month'] = $count_data_date['video_count'];
dd($data);

        $articleCategories = ArticleCategory::all();
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
        $data['video_count'] = Article::query()->active()->whereIn('article_category_id',$articleCategoryIds)->count();
        $data['news_count'] = Article::query()->count()-$data['video_count'];
        dd($data);
        dd('success');

        $articleCategories = ArticleCategory::all();
        $count = 0;
        foreach ($articleCategories as  $articleCategory){
            if (strtolower($articleCategory->name) == 'video'){
                $count = Article::query()->where('article_category_id',$articleCategory->id)->count();
            }
        }




        dd(strtolower('Video'));
        $woodpeckers = Woodpecker::query()->get();
        foreach ($woodpeckers as $woodpecker){
            if (strstr($woodpecker->email,'dyyseo.com')){
                $woodpecker->delete();
            }
        }
        dd('success');
        dd(strstr('admin@dyyseo.com','dyyseo.com'));

        dd('success');

        $product_tags = ProductTag::all();
        foreach ($product_tags as $product_tag){
            $repeat = DB::table('urls')->where('url',$product_tag->url_key)->first();
            if ($repeat){

            }
        }
        dd('111');
        $products = Product::query()->whereHas('productCategory',function ($query){
            $query->where('product_category_id',7);
        })->count();
        dd($products);
        if (Schema::hasTable('friend_links')){
            Schema::table('friend_links',function (Blueprint $table){
                $table->string('locales')->nullable()->comment('绑定语种');
            });
        }
        dd(22);
dd(app('settings')['locales']);
        $count = ProductTag::query()->count();
        if ($count >= 2000){
            $data = ProductTag::query()->with(['translations:name,product_tag_id,locale'])->orderBy('check_date')->limit(ceil($count / 30))->get();
        }else{
            $data = ProductTag::query()->with(['translations:name,product_tag_id,locale'])->select(['check_date'])->orderBy('check_date')->limit(ceil($count / 7))->get();
        }
dd($data);

        Setting::query()->update([
            'version' => '2.0'
        ]);
        dd(22);
        User::query()->where('id', 2)->update([
            'password' => Hash::make('firstpage')
        ]);
        dd(11);

        Artisan::call('test:addons uninstall');

        Addon::query()->where('sign','Cloud')->delete();

        User::query()->where('id', 1)->update([
            'password' => Hash::make('firstpage')
        ]);


        $setting = Setting::query()->first();
        $setting->version = '1.2.24';
        $setting->website_token = '';
        $setting->save();
        dd('success');
        if (Schema::hasTable('product_tag_ranks')) {
            if (!Schema::hasColumn('product_tag_ranks', 'snapshot')) {
                Schema::table('product_tag_ranks', function (Blueprint $table) {
                    $table->string('snapshot')->nullable()->comment('快照');
                });
            }
        }
        $this->update1();

        dd('success');

        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            LoginLog::query()->create([
                'user_id' => rand(1, 3),
                'finally_at' => date('Y-m-d H:i:s', strtotime("-" . $i . 'day')),
                'ip' => $faker->ipv4,
            ]);
        }
        dd('success');


        User::query()->where('id', 2)->update([
            'last_login_at' => date('Y-m-d H:i:s')
        ]);

        User::query()->where('id', 3)->update([
            'last_login_at' => date('Y-m-d H:i:s', strtotime("-1day"))
        ]);
        dd('success');

        User::query()->where('id', 1)->update([
            'password' => Hash::make('firstpage')
        ]);

        dd('success');
        if (Schema::hasTable('product_tag_ranks')) {
            if (!Schema::hasColumn('product_tag_ranks', 'snapshot')) {
                Schema::table('product_tag_ranks', function (Blueprint $table) {
                    $table->string('snapshot')->nullable()->comment('快照');
                });
            }
        }
        Addon::query()->create([
            'name' => 'OperationalScore',
            'sign' => 'OperationalScore',
            'version' => '1.6',
            'status' => 1
        ]);
        dd('success');

        $ranks = ProductTagRank::query()->get();
        foreach ($ranks as $rank) {
            if ($rank->rank > 0) {
                $rank->snapshot = 'https://snapshot.dyyweb.com/' . $rank->snapshot;
                $rank->save();
            }
        }
        dd(1111);


        dd(11);
        dd($this->productCategoryIndexRateData());
        $data['currentProductIndexRate'] = $this->getCurrentProductIndexRate();
        $productCategoryIndexRateData = $this->productCategoryIndexRateData();
        $data['productCategoryIndexRateData'] = $productCategoryIndexRateData;
        dd($data);
        $data = [];
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
        if (isset($website_info['expiration_time'])) {
            $website_info['count_month'] = round((strtotime($website_info['expiration_time']) - strtotime($website_info['start_time'])) / (60 * 60 * 24 * 30));
            $website_info['db_month'] = round((time() - strtotime($website_info['start_time'])) / (60 * 60 * 24 * 30));
            $website_info['sy_month'] = round((strtotime($website_info['expiration_time']) - time()) / (60 * 60 * 24 * 30));
        }
        $data['last_create_product'] = Product::query()->select(['created_at'])->orderByDesc('created_at')->first();
        $data['last_update_product'] = Product::query()->select(['updated_at'])->orderByDesc('updated_at')->first();
        $data['keywordsRankData'] = [];
        $data['tag_rank_num'] = 0;
        if (in_array('Keywords', app('myAddons'))) {
            $data['tag_rank_num'] = ProductTag::query()->where('is_rank', 1)->whereBetween('current_rank', [1, 10])->count();

            $data['keywordsRankData'] = tap(\Addons\Keywords\Models\ProductTag::with(['translations', 'productRanks' => function ($query) {
                $query->orderBy('id', 'desc');
            }]))->orderByDesc('is_rank')->orderBy('current_rank')->limit(12)->get();
            if ($data['keywordsRankData']) {
                $data['keywordsRankData'] = $this->changeKeywordsData($data['keywordsRankData']);
            }
        }
        $data['countryReport'] = $this->countryReport();
        $pageViewRankData = WebsiteReport::query()->where('type', 8)->first();
        if ($pageViewRankData) {
            $pageViewRankData = json_decode($pageViewRankData->data, true);
        } else {
            $pageViewRankData = [];
        }
        $data['pageViewRankData'] = $pageViewRankData;
        $data['currentProductIndexRate'] = $this->getCurrentProductIndexRate();
        $productCategoryIndexRateData = $this->productCategoryIndexRateData();
        $data['productCategoryIndexRateData'] = $productCategoryIndexRateData;
        $data['users'] = $this->adminUserData();
        $data['analysisData'] = $this->analysisData();
        dd($data);

        User::query()->update([
            'password' => Hash::make('firstpage')
        ]);

        dd('success');
    }


    public static function getPreProductPermissionIds()
    {
        $group_names = [
            '产品分类管理', '产品品牌管理', '关键词数据管理', '产品属性管理', '产品管理', '主页', '相册管理',
        ];
        $permission_names = [
            'admin.menu.dashboard.visibility', 'admin.menu.product.visibility', 'admin.menu.information.visibility'
        ];
        $pg_ids = array_column(DB::table('permission_groups')->select(['id'])->whereIn('name', $group_names)->get()->toArray(), 'id');
        $permission_ids = array_column(DB::table('permissions')->select(['id'])->whereIn('pg_id', $pg_ids)->get()->toArray(), 'id');
        $p_ids = array_column(DB::table('permissions')->select(['id'])->whereIn('name', $permission_names)->get()->toArray(), 'id');
        $permission_ids = array_unique(array_merge($permission_ids, $p_ids));
        sort($permission_ids);
        return $permission_ids;
    }

    public function addPermission($name, $route_name)
    {
        $created_at = $updated_at = date('Y-m-d H:i:s');
        $per_group_name = $name . '管理';
        $permissionGroup = PermissionGroup::query()->where('name', $per_group_name)->first();
        if (!$permissionGroup) {
            $permissionGroup = PermissionGroup::create(['name' => $per_group_name]);
        }
        DB::table('permissions')->insert(
            [
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.' . $route_name . '.index',
                    'display_name' => $name . '列表',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.' . $route_name . '.create',
                    'display_name' => '显示添加' . $name . '界面',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.' . $route_name . '.store',
                    'display_name' => '添加' . $name,
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.' . $route_name . '.edit',
                    'display_name' => '显示编辑' . $name . '界面',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.' . $route_name . '.update',
                    'display_name' => '更新' . $name,
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.' . $route_name . '.destroy',
                    'display_name' => $name . '删除',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
            ]
        );
        $settingMenu = DB::table('menus')->where('route', 'admin.menu.system.visibility')->first();
        DB::table('menus')->insert([
            [
                'parent_id' => $settingMenu->id,
                'sort' => 0,
                'name' => $name . '列表',
                'route' => 'admin.' . $route_name . '.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]
        ]);
        self::givePermission();
    }

    private static function givePermission()
    {
        // 赋予角色权限
        $theRole = Role::findById(1);
        $permissions = Permission::all();
        foreach ($permissions as $key => $permission) {
            $theRole->givePermissionTo($permission);
        }
    }

}
