<?php

use App\Modules\Menu\Models\Menu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Console\Commands\Test\TestAddonsCommand;
use App\Modules\Inquiry\Models\Inquiry;
use App\Services\GeoLiteService;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('global_color')->default('grey');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('last_login_at')->nullable()->comment('最后登陆时间');
        });

        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('标题');
            $table->longText('content')->comment('内容');
            $table->unsignedBigInteger('sort')->default(0)->comment('排序');
            $table->boolean('is_top')->default(0)->comment('是否置顶');
            $table->boolean('is_show')->default(1)->comment('是否显示');
            $table->timestamps();
        });

        //填充国家数据
        if (Inquiry::query()->first()) {
            $inquiries = Inquiry::all();
            $service = new GeoLiteService();
            foreach ($inquiries as $inquiry) {
                $inquiry->msg_country = $service->getCountry($inquiry->ip);
                $inquiry->add_date = date('Ym', strtotime($inquiry->created_at));
                $inquiry->save();
            }
        }

        Schema::create('ad_spaces', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名称');
            $table->string('img')->comment('广告位图片');
            $table->string('url')->nullable()->comment('广告跳转链接');
            $table->boolean('is_show')->default(1)->comment('是否显示');
            $table->unsignedBigInteger('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('管理员id');
            $table->string('ip')->comment('登陆ip');
            $table->dateTime('finally_at');
        });

        //收录链接表
        Schema::create('index_links', function (Blueprint $table) {
            $table->id();
            $table->text('link')->comment('链接');
            $table->string('type')->comment('链接类型');
            $table->boolean('status')->default(1)->comment('1正常收录,0已失效');
            $table->unsignedBigInteger('collected_date')->comment('收录时间Ymd');
            $table->timestamps();
        });

        //修改图标
        if (Menu::query()->first()) {
            $menu_icons = [
                'admin.report.index' => 'icon-home my-slide-icon',
                'admin.manager.index' => 'icon-users my-slide-icon',
                'admin.menu.product.visibility' => 'icon-shopping my-slide-icon',
                'admin.menu.content.visibility' => 'icon-server my-slide-icon',
                'admin.menu.download.visibility' => 'icon-download my-slide-icon',
                'admin.menu.manager.visibility' => 'icon-layers my-slide-icon',
                'admin.menu.trash.visibility' => 'icon-trash my-slide-icon',
                'admin.menu.system.visibility' => 'icon-settings my-slide-icon',
                'admin.menu.extensionMarket.visibility' => 'icon-box my-slide-icon',
                'admin.menu.marketing.visibility' => 'icon-barchart my-slide-icon',
                'admin.menu.information.visibility' => 'icon-relation  my-slide-icon',
                'admin.photo.visibility' => 'icon-image  my-slide-icon',
            ];
            foreach ($menu_icons as $route_name => $icon) {
                Menu::query()->where('route', $route_name)->update([
                    'icon' => $icon
                ]);
            }
        }

        //给权限
        if (DB::table('settings')->first()) {
            $menu_data = [
                [
                    'parent_name' => '数据管理',
                    'parent_id' => 0,
                    'sort' => 0,
                    'name' => '数据管家',
                    'route' => 'admin.dataManager.index',
                    'icon' => '',
                ],
                [
                    'parent_name' => '数据管理',
                    'parent_id' => 0,
                    'sort' => 0,
                    'name' => '关键词排名',
                    'route' => 'admin.keywordsRank.index',
                    'icon' => '',
                ],
                [
                    'parent_name' => '营销管理',
                    'parent_id' => 0,
                    'sort' => 0,
                    'name' => 'Listing数据',
                    'route' => 'admin.listing.index',
                    'icon' => '',
                ]
            ];
            $permissions = [
                [
                    'pg_name' => '数据管家',
                    'name' => 'admin.dataManager.index',
                    'guard_name' => 'web',
                    'display_name' => '数据管家查看',
                ],
                [
                    'pg_name' => '数据管家',
                    'name' => 'admin.dataManager.data',
                    'guard_name' => 'web',
                    'display_name' => '数据管家数据获取',
                ],
                [
                    'pg_name' => '数据管家',
                    'name' => 'admin.dataManager.productCategoryRate',
                    'guard_name' => 'web',
                    'display_name' => '数据管家分类统计数据获取',
                ],
                [
                    'pg_name' => '关键词排名',
                    'name' => 'admin.keywordsRank.index',
                    'guard_name' => 'web',
                    'display_name' => '关键词排名',
                ],
                [
                    'pg_name' => '关键词排名',
                    'name' => 'admin.keywordsRank.export',
                    'guard_name' => 'web',
                    'display_name' => '关键词排名导出',
                ],


                [
                    'pg_name' => '主页',
                    'name' => 'admin.setting.getNotice',
                    'guard_name' => 'web',
                    'display_name' => '获取公告',
                ],

                [
                    'pg_name' => '数据管家',
                    'name' => 'admin.listing.index',
                    'guard_name' => 'web',
                    'display_name' => 'listing数据',
                ],

            ];
            TestAddonsCommand::addPermissions($menu_data, $permissions);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notices');
    }
}
