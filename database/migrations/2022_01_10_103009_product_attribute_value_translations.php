<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductAttributeValueTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_value_translations',function (Blueprint $table){
            $table->id();
            $table->bigInteger('product_attribute_value_id')->unsigned();
            $table->string('locale')->index();
//            $table->string('name')->nullable()->comment('属性名');
            $table->string('name')->nullable()->comment('属性值');
            $table->unique(['product_attribute_value_id', 'locale'],'product_attribute_value_id_locale_unique');
            $table->foreign('product_attribute_value_id','product_attribute_value_id_foreign')
                ->references('id')
                ->on('product_attribute_values')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute_value_translations');
    }
}
