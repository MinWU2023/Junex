<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parent_id')->default(0)->comment('上级id');
            $table->unsignedInteger('sort')->default(0)->comment('排序，数字越大越靠前');
            $table->string('name')->comment('名称');
            $table->string('route')->comment('路由标识');
            $table->string('icon')->nullable()->comment('图标');
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
        Schema::dropIfExists('menus');
    }
}
