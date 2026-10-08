<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SettingAddTagNum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings',function (Blueprint $table){
            $table->unsignedTinyInteger('tag_max_num')->default(6)->comment('产品tag数量');
            $table->string('watermark')->nullable()->comment('水印图片');
            $table->string('watermark_location')->default('bottom-right')->comment('水印位置');
            $table->integer('watermark_x')->default(0)->comment('水印位置偏移x');
            $table->integer('watermark_y')->default(0)->comment('水印位置偏移y');

//            $table->boolean('home_lock')->default(0)->comment('开启国内访问锁定');
//            $table->string('home_lock_password')->nullable()->comment('访问密码');
//            $table->text('allow_ips')->nullable()->comment('国内允许访问ip');
        });

        Schema::table('file_infos',function (Blueprint $table){
            $table->boolean('is_watermark')->default(1);
        });

        Schema::table('setting_translations',function (Blueprint $table){
            $table->string('product_alt_template')->nullable()->comment('产品图片alt模板');
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
