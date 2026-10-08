<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemovePermissionWebsite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::table('settings')->first()) {
            $permission_ids = \App\Modules\Admin\Models\Permission::query()->whereIn('name',[
                'admin.translateJob.index',
                'admin.setting.clearCache'
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
