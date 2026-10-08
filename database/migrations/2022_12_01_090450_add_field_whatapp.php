<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldWhatapp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('settings',function (Blueprint $table){
          $table->boolean('whatsapp_float_active')->default(0)->comment('whatsapp浮动');
          $table->text('whatsapp_float_data')->nullable()->comment('whatsapp信息');
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
