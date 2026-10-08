<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingBottomLogo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings',function (Blueprint  $table){
            $table->string('bottom_logo')->after('logo')->nullable()->comment('网站底部logo');
            $table->string('qr_code_whatsapp')->after('qr_code')->nullable()->comment('whatsapp二维码');
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
