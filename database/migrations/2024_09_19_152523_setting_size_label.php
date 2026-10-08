<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingSizeLabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings',function (Blueprint  $table){
            $table->double('max_size')->default(4)->after('body_code')->comment('网站最大容量(GB)');
            $table->text('size_label')->after('max_size')->nullable()->comment('容量提示语');
        });

        Schema::table('banner_translations',function (Blueprint $table){
            $table->string('alt')->nullable()->after('name')->comment('alt属性');
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
