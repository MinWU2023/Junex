<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attr_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_attribute_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['product_attribute_id', 'locale']);
            $table->string('name')->nullable()->comment('属性名称');
            $table->foreign('product_attribute_id')
                ->references('id')
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
        Schema::dropIfExists('product_attribute_translations');
    }
}
