<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\PermissionGroup;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddPermissionBlogRemoves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissionGroup = PermissionGroup::query()->where('name','博客关键词管理')->first();
        if ($permissionGroup){
            $created_at = $updated_at = date('Y-m-d H:i:s');
            $per = DB::table('permissions')->where('name','admin.blog.tag.removes')->first();
            if (!$per){
                DB::table('permissions')->insert(
                    [
                        'pg_id' => $permissionGroup->id,
                        'name' => 'admin.blog.tag.removes',
                        'display_name' => '删除未关联博客的关键词',
                        'guard_name' => 'web',
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    ],
                );
                self::givePermission();
            }
        }
    }

    private static function givePermission()
    {
        // 赋予角色权限
        $theRole = Role::findById(1);
        $permissions = Permission::all();
        foreach ($permissions as $key => $permission) {
            $theRole->givePermissionTo($permission);
        }

        $currentPermissions = [
            'admin.blog.tag.removes'
        ];
        $websiteTheRole = Role::findById(2);
        foreach ($currentPermissions as $currentPermission){
            $websiteTheRole->givePermissionTo($currentPermission);
        }

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
