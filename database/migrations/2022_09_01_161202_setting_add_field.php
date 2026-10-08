<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingAddField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings',function (Blueprint $table){
            $table->boolean('home_lock')->default(0)->comment('是否开启禁止国内访问');
            $table->text('allow_ips')->nullable()->comment('允许访问ip');
            $table->string('home_lock_password')->nullable()->comment('访问密码');
            $table->string('nocaptcha_sitkey')->nullable()->comment('网站密钥');
            $table->string('nocaptcha_secret')->nullable()->comment('密钥');
        });

        Schema::table('products',function (Blueprint $table){
            $table->string('video')->nullable()->comment('主图视频');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('settings',['home_lock','allow_ips','home_lock_password','nocaptcha_sitkey','nocaptcha_secret']);
        Schema::dropColumns('products',['video']);
    }
}
