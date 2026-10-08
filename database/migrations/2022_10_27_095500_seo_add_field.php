<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeoAddField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_translations',function (Blueprint $table){
            $table->string('seo_product_category_bottom_title')->nullable()->comment('产品分类title模板');
            $table->string('seo_product_category_bottom_description',500)->nullable()->comment('产品分类description模板');
            $table->string('seo_product_category_bottom_keywords')->nullable()->comment('产品分类keyword模板');
        });

        Schema::table('articles',function (Blueprint $table){
            $table->bigInteger('admin_user_id')->comment('用户id');
        });

        Schema::table('blogs',function (Blueprint $table){
            $table->bigInteger('admin_user_id')->comment('用户id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
