<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminLogDataCreatedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_logs', function (Blueprint $table) {   
            $table->unsignedBigInteger('data_source_id')->after('path')->default(0)->comment('数据原始id');
            $table->dateTime('data_created_at')->nullable()->after('data_source_id')->comment('数据创建时间');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('login_pwd_encrypt')->default(0)->comment('登录密码加密');
            $table->boolean('single_sign_on')->default(0)->comment('单点登陆');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('login_token', 100)->nullable()->after('password')->comment('登录token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
