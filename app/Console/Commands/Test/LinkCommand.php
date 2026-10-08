<?php

namespace App\Console\Commands\Test;

use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:init';

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
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $add = [];
        $add['name'] = '友情链接管理';
        $permissionGroup = PermissionGroup::create($add);
        DB::table('permissions')->insert(
            [
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.friendLink.index',
                    'display_name' => 'friendLink列表',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],

                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.friendLink.create',
                    'display_name' => '新增friendLink页面',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],


                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.friendLink.store',
                    'display_name' => '新增friendLink',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],

                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.friendLink.edit',
                    'display_name' => '修改friendLink页面',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],

                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.friendLink.update',
                    'display_name' => '修改friendLink',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],


                [
                    'pg_id' => $permissionGroup->id,
                    'name' => 'admin.friendLink.destroy',
                    'display_name' => 'friendLink删除',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
            ]
        );
        //营销列表
        $marketingMenu = Menu::where('route','admin.menu.marketing.visibility')->first();
        DB::table('menus')->insert([
            [
                'parent_id' => $marketingMenu->id,
                'sort' => 0,
                'name' => '友情链接列表',
                'route' => 'admin.friendLink.index',
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
