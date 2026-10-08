<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->comment('操作账号');
            $table->string('ip')->comment('ip');
            $table->string('name')->nullable()->comment('操作名');
            $table->string('path')->comment('操作路由');
            $table->string('browser')->comment('浏览器');
            $table->text('content')->comment('日志');
            $table->dateTime('created_at')->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_logs');
    }
}
