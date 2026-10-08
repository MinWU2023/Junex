<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Modules\Admin\Models\PermissionGroup;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreatePhotoAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_albums', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('相册名称');
//            $table->string('path')->nullable()->comment('相册封面');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        Schema::table('file_infos',function (Blueprint $table){
            $table->unsignedBigInteger('photo_album_id')->default(0)->comment('相册id');
        });

        $permissionGroup = PermissionGroup::query()->count();
        if ($permissionGroup>10){
            $this->addPermission('相册','photoAlbum');
            $this->addOnePermission('相册管理', 'admin.photo.visibility', '相册');
            $this->addOnePermission('相册管理', 'admin.picture.index', '所有图片');
            $this->addOnePermission('相册管理','admin.picture.multipleMoveAlbumShow','显示图片转移');
            $this->addOnePermission('相册管理','admin.picture.multipleMoveAlbum','图片转移操作');
            $this->addOnePermission('相册管理', 'admin.picture.multipleMoveRemove', '批量删除图片');
            $this->addOnePermission('相册管理', 'admin.picture.pop', '弹出相册');
            $this->addOnePermission('相册管理', 'admin.picture.destroy', '删除图片');
            $photoMenu = \App\Modules\Menu\Models\Menu::query()->create([
                'parent_id' => 0,
                'sort' => 0,
                'name' => '相册',
                'route' => 'admin.photo.visibility',
                'icon' => '',
            ]);
            DB::table('menus')->insert([
                [
                    'parent_id' => $photoMenu->id,
                    'sort' => 0,
                    'name' => '图片管理',
                    'route' => 'admin.picture.index',
                    'icon' => '',
                    'created_at' => now()->getTimestamp(),
                    'updated_at' => now()->getTimestamp(),
                ],
                [
                    'parent_id' => $photoMenu->id,
                    'sort' => 0,
                    'name' => '相册管理',
                    'route' => 'admin.photoAlbum.index',
                    'icon' => '',
                    'created_at' => now()->getTimestamp(),
                    'updated_at' => now()->getTimestamp(),
                ]
            ]);
            self::givePermission();

            $add_permissions = [
                'admin.photoAlbum.index','admin.photoAlbum.create','admin.photoAlbum.store',
                'admin.photoAlbum.edit','admin.photoAlbum.update','admin.photoAlbum.destroy',
                'admin.photo.visibility','admin.picture.index','admin.picture.multipleMoveAlbumShow',
                'admin.picture.multipleMoveAlbum','admin.picture.multipleMoveRemove','admin.picture.pop',
                'admin.picture.destroy'
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
        Schema::dropIfExists('photo_albums');
    }
}
