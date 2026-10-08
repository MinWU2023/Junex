<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('area')->comment('banner位');
            $table->string('path')->comment('图片路径');
//            $table->string('name')->nullable()->comment('名称');
            $table->unsignedInteger('sort')->default(0)->comment('排序，数字越大越靠前');
            $table->string('url')->nullable()->comment('链接');
//            $table->string('description')->nullable()->comment('描述');
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
        Schema::dropIfExists('banners');
    }
}
