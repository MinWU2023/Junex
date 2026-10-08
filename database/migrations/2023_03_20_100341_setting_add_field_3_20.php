<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingAddField320 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings',function (Blueprint $table){
            $table->text('facebook_code')->nullable()->comment('facebook代码');
            $table->boolean('setting_seo_show')->default(0)->comment('是否显示系统seo设置');
            $table->boolean('product_list_seo_show')->default(0)->comment('是否显示产品列表seo设置');
            $table->boolean('product_category_seo_show')->default(0)->comment('是否显示产品分类seo设置');
            $table->boolean('product_detail_seo_show')->default(0)->comment('是否显示产品详情seo设置');
            $table->boolean('product_tag_seo_show')->default(0)->comment('是否显示产品tag seo设置');
            $table->boolean('article_list_seo_show')->default(0)->comment('是否显示文章列表seo设置');
            $table->boolean('article_category_seo_show')->default(0)->comment('是否显示文章分类seo设置');
            $table->boolean('article_detail_seo_show')->default(0)->comment('是否显示文章详情seo设置');
            $table->boolean('blog_list_seo_show')->default(0)->comment('是否显示博客列表seo设置');
            $table->boolean('blog_category_seo_show')->default(0)->comment('是否显示博客分类seo设置');
            $table->boolean('blog_detail_seo_show')->default(0)->comment('是否显示博客详情seo设置');
            $table->boolean('blog_tag_seo_show')->default(0)->comment('是否显示博客tag seo设置');
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
