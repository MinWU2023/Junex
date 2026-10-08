<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductAttributeValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_values',function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('产品id');
//            $table->string('name')->comment('属性');
            $table->unsignedBigInteger('product_attribute_id')->comment('属性id');
            $table->foreign('product_id')->references('id')
                ->on('products')->onUpdate('cascade');
            $table->foreign('product_attribute_id')->references('id')
                ->on('product_attributes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('product_attribute_values');
    }
}
