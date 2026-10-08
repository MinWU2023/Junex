<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WatermarkSwitchField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings',function (Blueprint  $table){
            $table->boolean('product_watermark')->default(0)->comment('产品相关水印是否开启');
            $table->boolean('blog_watermark')->default(0)->comment('博客相关水印是否开启');
            $table->boolean('article_watermark')->default(0)->comment('文章水印是否开启');
            $table->boolean('page_watermark')->default(0)->comment('单页面水印是否开启');
            $table->boolean('download_watermark')->default(0)->comment('下载水印是否开启');
        });

        if (!Schema::hasColumn('inquiries','msg_country1')){
            Schema::table('inquiries',function (Blueprint  $table){
                $table->string('msg_country1')->nullable()->after('msg_country');
            });
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
