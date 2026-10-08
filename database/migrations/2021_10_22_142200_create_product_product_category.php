<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProductCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product_category',function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('product_category_id')->comment('产品分类id');
            $table->unsignedBigInteger('product_id')->comment('产品id');
            $table->foreign('product_id')->on('products')->references('id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_category_id')->on('product_categories')
                ->references('id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['product_category_id','product_id']);
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
        Schema::dropIfExists('product_product_category');
    }
}
