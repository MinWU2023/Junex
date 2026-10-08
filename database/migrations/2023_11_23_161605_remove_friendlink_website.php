<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Permission;

class RemoveFriendlinkWebsite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::table('settings')->first()) {
            //去除客户的友情链接相关权限
            $permission_ids = Permission::query()->whereIn('name',[
                'admin.friendLink.index',
                'admin.friendLink.create',
                'admin.friendLink.store',
                'admin.friendLink.edit',
                'admin.friendLink.update',
                'admin.friendLink.destroy'
            ])->pluck('id')->toArray();
            DB::table('role_has_permissions')->whereIn('permission_id',$permission_ids)->where('role_id','>',1)->delete();
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
