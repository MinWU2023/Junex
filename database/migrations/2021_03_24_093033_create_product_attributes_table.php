<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
//            $table->string('category_name')->nullable()->comment('分类名');
            //            $table->foreign('product_attribute_category_id')
//                ->references('id')
//                ->on('product_attribute_categories')
//                ->onUpdate('cascade')->onDelete('cascade');
//            $table->string('mark')->unique()->comment('标记');
            $table->unsignedInteger('sort')->default(0)->comment('排序，数字越大越靠前');
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
        Schema::dropIfExists('product_attributes');
    }
}
