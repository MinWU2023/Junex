<?php

use Illuminate\Database\Migrations\Migration;
use App\Modules\Admin\Models\PermissionGroup;
use Spatie\Permission\Models\Role;
use App\Modules\Admin\Models\Permission;
use Illuminate\Support\Facades\DB;

class AlbumAddUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissionGroup = PermissionGroup::query()->count();
        if ($permissionGroup>10){

            $this->addOnePermission('相册管理', 'admin.photoAlbum.uploadShow', '相册批量上传图片');
            $this->addOnePermission('相册管理', 'admin.photoAlbum.upload', '相册批量上传');

            self::givePermission();
            $add_permissions = [
                'admin.photoAlbum.uploadShow','admin.photoAlbum.upload'
            ];
            $addRoles = [
                2,3,4
            ];
            foreach ($addRoles as $addRole){
                $theRole = Role::findById($addRole);
                foreach ($add_permissions as $key => $add_permission) {
                    $theRole->givePermissionTo($add_permission);
                }
            }
        }

        DB::statement("ALTER TABLE `admin_logs` CHANGE `content` `content` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '日志内容';");
    }

    public function addOnePermission($parent_name, $name, $display_name)
    {
        $created_at = $updated_at = date('Y-m-d H:i:s');
        $permissionGroup = PermissionGroup::query()->where('name', $parent_name)->first();
        if (!$permissionGroup) {
            $permissionGroup = PermissionGroup::create(['name' => $parent_name]);
        }
        DB::table('permissions')->insert(
            [
                [
                    'pg_id' => $permissionGroup->id,
                    'name' => $name,
                    'display_name' => $display_name,
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
            ]
        );

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
