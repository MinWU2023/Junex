<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parent_id')->default(0)->comment('上级id');
            $table->unsignedInteger('sort')->default(0)->comment('排序，数字越大越靠前');
            $table->string('img_alt')->nullable()->comment('图片ALT标签');
            $table->string('url_key')->comment('自定义url链接');
            $table->string('img_path')->nullable()->comment('图片');
            $table->boolean('active')->default(1)->comment('0，被删除。1，正常显示。');
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
        Schema::dropIfExists('pages');
    }
}
