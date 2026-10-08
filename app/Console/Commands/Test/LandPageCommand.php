<?php

namespace App\Console\Commands\Test;

use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Article\Models\Article;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Product\Models\Product;
use App\Modules\SiteCount\Models\SiteCount;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LandPageCommand extends Command
{
    /**
     * The name and signature of the console command.123
     *
     * @var string
     */
    protected $signature = 'land:page';

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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('生成落地页数据');
        Artisan::call('db:seed LandPageSeeder');
        $this->info('落地页数据生成成功');
        $this->info('--------生成落地页权限---------');
        $this->addPermission('落地页','landPage');
        $this->info('--------落地页权限生成成功---------');
        $this->info('--------success---------');
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


    public function addPermission($name,$route_name){

        $created_at = $updated_at = date('Y-m-d H:i:s');
        $per_group_name = $name.'管理';
        $permissionGroup = PermissionGroup::query()->where('name',$per_group_name)->first();
        if ($permissionGroup){
           return;
        }
        $permissionGroup = PermissionGroup::create(['name'=>$per_group_name]);
        DB::table('permissions')->insert(
            [
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.'.$route_name.'.index',
                    'display_name' => $name.'列表',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.'.$route_name.'.create',
                    'display_name' => '显示添加'.$name.'界面',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.'.$route_name.'.store',
                    'display_name' => '添加'.$name,
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.'.$route_name.'.edit',
                    'display_name' => '显示编辑'.$name.'界面',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.'.$route_name.'.update',
                    'display_name' => '更新'.$name,
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.'.$route_name.'.destroy',
                    'display_name' => $name.'删除',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
            ]
        );
        $settingMenu = DB::table('menus')->where('route','admin.menu.system.visibility')->first();
        DB::table('menus')->insert([
            [
                'parent_id' => $settingMenu->id,
                'sort' => 0,
                'name' => $name.'列表',
                'route' => 'admin.'.$route_name.'.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]
        ]);
        self::givePermission();
    }


}
