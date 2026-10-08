<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductTagAddMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_tag_translations',function (Blueprint $table){
            $table->string('title')->nullable()->comment('标题');
            $table->string('keywords')->nullable()->comment('关键词');
            $table->text('description')->nullable()->comment('描述');
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
