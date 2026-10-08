<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名称');
            $table->string('sign')->unique()->comment('插件标识');
            $table->string('version')->comment('版本号');
            $table->text('configuration')->nullable()->comment('配置');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态，0，正在安装。1，安装成功，2，安装失败');
            $table->string('error_msg')->nullable()->comment('失败原因');
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
        Schema::dropIfExists('addons');
    }
}
