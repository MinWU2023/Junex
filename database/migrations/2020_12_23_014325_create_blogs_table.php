<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('blogs')){
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('blog_category_id')->unsigned();
                $table->foreign('blog_category_id')
                    ->references('id')
                    ->on('blog_categories')
                    ->onUpdate('cascade');
                $table->unsignedInteger('sort')->default(0)->comment('排序，数字越大越靠前');
                $table->string('path')->nullable()->comment('图片路径');
                $table->boolean('active')->default(1)->comment('0，被删除。1，正常显示。');
                $table->string('url_key')->comment('自定义url链接');
                $table->timestamp('customer_at')->nullable()->comment('自定义时间');
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
//        Schema::dropIfExists('blogs');
    }
}
