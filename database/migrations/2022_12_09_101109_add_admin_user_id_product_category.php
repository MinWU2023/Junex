<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminUserIdProductCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_categories',function (Blueprint $table){
            $table->bigInteger('admin_user_id')->default(0)->comment('用户id');
        });
        Schema::table('product_brands',function (Blueprint $table){
            $table->bigInteger('admin_user_id')->default(0)->after('name')->comment('用户id');
        });
        Schema::table('product_attributes',function (Blueprint $table){
            $table->bigInteger('admin_user_id')->default(0)->comment('用户id');
        });
        Schema::table('product_tags',function (Blueprint $table){
            $table->bigInteger('admin_user_id')->default(0)->after('is_hot')->comment('用户id');
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
