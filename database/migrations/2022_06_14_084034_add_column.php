<?php

use App\Modules\Admin\Models\PermissionGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_categories',function (Blueprint $table){
           $table->string('logo')->nullable()->comment('分类banner');

        });


        Schema::table('settings',function (Blueprint $table){
            $table->string('qr_code')->nullable()->comment('二维码');

            $table->text('gsg_code')->nullable()->comment('gsg代码');

        });

        Schema::table('inquiries',function (Blueprint $table){
            $table->string('msg_name')->nullable()->comment('用户名');
            $table->string('msg_company')->nullable()->comment('公司');
            $table->text('msg_country')->nullable()->comment('国家');
        });


        Schema::create('article_product',function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('关联products');
            $table->unsignedBigInteger('article_id')->comment('关联文章');
            $table->timestamps();
        });
        $permissionGroup = PermissionGroup::query()->where('name','文章管理')->first();
        if ($permissionGroup){
            $created_at = $updated_at = date('Y-m-d H:i:s');
            $per = DB::table('permissions')->where('name','admin.article.getAllArticles')->first();
            if (!$per){
                DB::table('permissions')->insert(
                    [
                        'pg_id' => $permissionGroup->id,
                        'name' => 'admin.article.getAllArticles',
                        'display_name' => '获取所有文章',
                        'guard_name' => 'web',
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    ],
                );
                self::givePermission();
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
        Schema::dropColumns('settings',['qr_code','gsg_code']);

        Schema::dropColumns('product_categories',['logo']);


        Schema::dropIfExists('article_product');

        DB::table('permissions')->where('name','admin.article.getAllArticles')->delete();

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
            'admin.article.getAllArticles'
        ];
        $websiteTheRole = Role::findById(2);
        foreach ($currentPermissions as $currentPermission){
            $websiteTheRole->givePermissionTo($currentPermission);
        }

    }
}
