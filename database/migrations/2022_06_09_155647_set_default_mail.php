<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetDefaultMail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $setting = \App\Modules\Setting\Models\Setting::query()->first();
        if ($setting){
            $setting->mail_mailer = 'smtp';
            $setting->mail_host = 'mx.dyyservice.com';
            $setting->mail_port = '443';
            $setting->mail_encryption = 'ssl';
            $setting->mail_username = 'website@dyyseo.com';
            $setting->mail_password = 'diyiye35246';
            $setting->mail_from_address = 'talk23@dyyservice.com';
            $setting->mail_from_name = 'talk23@dyyservice.com';
            $setting->mail_addressee = 'talk23@dyyservice.com';
            $setting->save();
        }
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
