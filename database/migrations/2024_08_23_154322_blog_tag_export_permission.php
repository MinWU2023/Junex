<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\PermissionGroup;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BlogTagExportPermission extends Migration
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
            $permission_group = PermissionGroup::query()->where([
                'name' =>  '博客关键词管理'
            ])->first();
            if ($permission_group){
                $permissions = [
                    [
                        'pg_id' => $permission_group->id,
                        'name' => 'admin.blog.tag.export',
                        'display_name' => '导出博客tag',
                        'guard_name' => 'web',
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    ],
                ];
                $role = Role::findById(1);
                foreach ($permissions as $permission) {
                    DB::table('permissions')
                        ->updateOrInsert(['name' => $permission['name'], 'pg_id' => $permission['pg_id']], $permission);
                    $permission = Permission::where('name', $permission['name'])->first();
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
