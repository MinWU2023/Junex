<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('属性分类名');
            $table->timestamps();
        });
        Schema::create('product_attribute_product_attribute_category',function (Blueprint $table){
                $table->id();
                $table->unsignedBigInteger('product_attribute_category_id')->comment('属性分类id');
                $table->unsignedBigInteger('product_attribute_id')->comment('属性id');
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
        Schema::dropIfExists('product_attribute_categories');
        Schema::dropIfExists('product_attribute_product_attribute_category');

    }
}
