<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTagTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_tag_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_tag_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['product_tag_id', 'locale']);
            $table->string('name')->nullable()->comment('tag名称');
            $table->foreign('product_tag_id')
                ->references('id')
                ->on('product_tags')
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
        Schema::dropIfExists('product_tag_translations');
    }
}
