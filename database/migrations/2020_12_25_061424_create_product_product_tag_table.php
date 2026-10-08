<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProductTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('关联products');
            $table->unsignedBigInteger('product_tag_id')->comment('关联product_tags');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade');
            $table->foreign("product_tag_id")->references('id')->on('product_tags')->onUpdate('cascade');
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
        Schema::dropIfExists('product_product_tag');
    }
}
