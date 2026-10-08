<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\PermissionGroup;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UrlAddListPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::table('settings')->first()){
            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;
            $permission_group = PermissionGroup::query()->create([
                    'name' =>  'url管理'
            ]);
            $permissions = [
                [
                    'pg_id' => $permission_group->id,
                    'name' => 'admin.url.index',
                    'display_name' => 'url管理列表',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $permission_group->id,
                    'name' => 'admin.url.destroy',
                    'display_name' => 'url删除',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ]
            ];
            $role = Role::findById(1);
            foreach ($permissions as $permission) {
                DB::table('permissions')
                    ->updateOrInsert(['name' => $permission['name'], 'pg_id' => $permission['pg_id']], $permission);
                $permission = Permission::where('name', $permission['name'])->first();
                $role->givePermissionTo($permission);
            }
            $parent_menu = \App\Modules\Menu\Models\Menu::query()->where('name','系统设置')->first();
            if ($parent_menu){
                DB::table('menus')->insert([
                    'parent_id' => $parent_menu->id,
                    'sort'=>  9,
                    'name' => 'url管理',
                    'route' => 'admin.url.index',
                    'icon'=>'',
                    'created_at'=> $created_at,
                    'updated_at'=> $updated_at
                ]);
            }
        }

        \Illuminate\Support\Facades\Schema::table('settings',function (\Illuminate\Database\Schema\Blueprint  $table){
            $table->text('body_code')->after('head_code')->nullable()->comment('body的插入代码');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
