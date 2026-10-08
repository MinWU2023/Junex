<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('article_category_id')->unsigned();
            $table->foreign('article_category_id')
                ->references('id')
                ->on('article_categories')
                ->onUpdate('cascade');
            $table->unsignedInteger('sort')->default(0)->comment('排序，数字越大越靠前');
            $table->string('path')->nullable()->comment('图片路径');
            $table->boolean('active')->default(1)->comment('0，被删除。1，正常显示。');
            $table->boolean('is_show')->default(0)->comment('是否显示');
            $table->boolean('is_menu')->default(0)->comment('是否导航');
            $table->string('url_key')->comment('自定义url链接');
            $table->mediumInteger('add_date')->comment('上传时间');
            $table->timestamp('customer_at')->nullable()->comment('自定义时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
