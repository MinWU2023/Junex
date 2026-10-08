<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_category_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['product_category_id', 'locale']);
            $table->string('name')->nullable()->comment('分类名称');
            $table->text('content')->nullable()->comment('分类简介');
            $table->string('title')->nullable()->comment('标题');
            $table->string('keywords')->nullable()->comment('关键词');
            $table->text('description')->nullable()->comment('描述');
            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')
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
        Schema::dropIfExists('product_category_translations');
    }
}
