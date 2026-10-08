<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Modules\Admin\Models\Permission;

class AddPhonePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::table('settings')->first()) {
            $created_at= $updated_at=date('Y-m-d H:i:s');
            $permissions = [
                'admin.photoAlbum.uploadShow',
                'admin.photoAlbum.upload'
            ];
            DB::table('permissions')->updateOrInsert([
                'name' => 'admin.photoAlbum.uploadShow',
            ],[
                'pg_id' => 30,
                'name' => 'admin.photoAlbum.uploadShow',
                'display_name' => '批量上传图片',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
            DB::table('permissions')->updateOrInsert([
                'name' => 'admin.photoAlbum.upload',
            ],[
                'pg_id' => 30,
                'name' => 'admin.photoAlbum.upload',
                'display_name' => '批量上传图片(操作)',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
            $roles = Role::get();
            foreach ($permissions as $name) {
                $permission = Permission::where('name', $name)->first();
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
        //
    }
}
