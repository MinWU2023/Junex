<?php

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class ProductAddIsDraft extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint  $table) {
            $table->boolean('is_draft')->default(0)->after('is_temp')->comment('是否为草稿');
        });
        if (DB::table('settings')->first()) {
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            $add = [];
            $add['name'] = '产品草稿箱';
            $permissionGroup = PermissionGroup::where('name', '产品草稿箱')->first();
            if (empty($permissionGroup)) {
                $permissionGroup = PermissionGroup::create($add);
            }

            $permissions =
                [
                    [
                        'pg_id' => $permissionGroup->id,
                        'name' => 'admin.product.draft.index',
                        'display_name' => '产品草稿列表',
                        'guard_name' => 'web',
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    ],
                    [
                        'pg_id' => $permissionGroup->id,
                        'name' => 'admin.product.draft.edit',
                        'display_name' => '显示产品草稿界面',
                        'guard_name' => 'web',
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    ],
                    [
                        'pg_id' => $permissionGroup->id,
                        'name' => 'admin.product.draft.update',
                        'display_name' => '更新产品草稿',
                        'guard_name' => 'web',
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    ],
                    [
                        'pg_id' => $permissionGroup->id,
                        'name' => 'admin.product.draft.destroy',
                        'display_name' => '产品草稿删除',
                        'guard_name' => 'web',
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    ],
                    [
                        'pg_id' => $permissionGroup->id,
                        'name' => 'admin.product.draft.schedule',
                        'display_name' => '设置定时发布',
                        'guard_name' => 'web',
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    ],
                    [
                        'pg_id' => $permissionGroup->id,
                        'name' => 'admin.product.draft.schedule.delete',
                        'display_name' => '删除定时发布',
                        'guard_name' => 'web',
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    ],

                ];

            $productMenu = Menu::where('route', 'admin.menu.product.visibility')->first();
            DB::table('menus')->insert([
                [
                    'parent_id' => $productMenu->id,
                    'sort' => 0,
                    'name' => '产品草稿箱',
                    'route' => 'admin.product.draft.index',
                    'icon' => '',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ]
            ]);
            $roles = Role::whereIn('id', [1, 2, 3, 4, 5])->get();
            foreach ($permissions as $permission) {
                DB::table('permissions')
                    ->updateOrInsert(['name' => $permission['name'], 'pg_id' => $permission['pg_id']], $permission);
                $permission = Permission::where('name', $permission['name'])->first();
                foreach ($roles as $role) {
                    $role->givePermissionTo($permission);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint  $table) {
            $table->dropColumn('is_draft');
        });
        $roles = Role::whereIn('id', [1, 2, 3, 4, 5])->get();
        $permissions = Permission::whereIn('name', [
            'admin.product.draft.index',
            'admin.product.draft.edit',
            'admin.product.draft.update',
            'admin.product.draft.destroy',
            'admin.product.draft.schedule',
            'admin.product.draft.schedule.delete',
        ])->get();
        foreach ($permissions as $permission) {
            foreach ($roles as $role) {
                $role->revokePermissionTo($permission->name);
            }
            $permission->delete();
        }
        DB::table('menus')->where('route', 'admin.product.draft.index')->delete();
        DB::table('permission_groups')->where('name', '产品草稿箱')->delete();
    }
}
