<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parent_id')->index()->default(0)->comment('上级id');
            $table->unsignedInteger('sort')->default(0)->comment('排序，数字越大越靠前');
            $table->boolean('is_show')->default(0)->comment('是否显示');
            $table->boolean('is_menu')->default(0)->comment('是否在导航显示');
            $table->string('path')->nullable()->comment('图片路径');
            $table->string('url_key')->comment('自定义url链接');
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
        Schema::dropIfExists('product_categories');
    }
}
