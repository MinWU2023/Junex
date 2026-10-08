<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (!Schema::hasTable('blog_categories')){
           Schema::create('blog_categories', function (Blueprint $table) {
               $table->id();
               $table->unsignedInteger('parent_id')->default(0)->comment('上级id');
               $table->unsignedInteger('sort')->default(0)->comment('排序，数字越大越靠前');
               $table->string('path')->nullable()->comment('图片路径');
               $table->string('url_key')->comment('自定义url链接');
               $table->timestamps();
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
//        Schema::dropIfExists('blog_categories');
    }
}
