<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PreviewField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs',function (Blueprint  $table){
            $table->boolean('is_temp')->default(0)->after('id')->comment('临时博客');
        });

        Schema::table('articles',function (Blueprint  $table){
            $table->boolean('is_temp')->default(0)->after('id')->comment('临时文章');
        });

        Schema::table('pages',function (Blueprint  $table){
            $table->boolean('is_temp')->default(0)->after('id')->comment('临时单页面');
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
