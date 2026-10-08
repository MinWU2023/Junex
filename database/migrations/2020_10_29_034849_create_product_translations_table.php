<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['product_id', 'locale']);
            $table->string('name')->nullable()->comment('产品名称');
            $table->text('brief_content')->nullable()->comment('产品简介');
            $table->longText('content')->nullable()->comment('产品详情');
            $table->longText('m_content')->nullable()->comment('产品详情（手机端）');
            $table->text('attribute')->nullable()->comment('产品属性');
            $table->string('title')->nullable()->comment('标题');
            $table->string('keywords')->nullable()->comment('关键词');
            $table->text('description')->nullable()->comment('描述');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
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
        Schema::dropIfExists('product_translations');
    }
}
