<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_category_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('article_category_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['article_category_id', 'locale']);
            $table->string('name')->nullable()->comment('分类名称');
            $table->string('content')->nullable()->comment('分类简介');
            $table->string('title')->nullable()->comment('标题');
            $table->string('keywords')->nullable()->comment('关键词');
            $table->string('description')->nullable()->comment('描述');
            $table->foreign('article_category_id')
                ->references('id')
                ->on('article_categories')
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
        Schema::dropIfExists('article_category_translations');
    }
}
