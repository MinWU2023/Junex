<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('blog_category_translations')){
            Schema::create('blog_category_translations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('blog_category_id')->unsigned();
                $table->string('locale')->index();
                $table->unique(['blog_category_id', 'locale']);
                $table->string('name')->nullable()->comment('分类名称');
                $table->string('content')->nullable()->comment('分类简介');
                $table->string('title')->nullable()->comment('标题');
                $table->string('keywords')->nullable()->comment('关键词');
                $table->string('description')->nullable()->comment('描述');
                $table->foreign('blog_category_id')
                    ->references('id')
                    ->on('blog_categories')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('blog_category_translations');
    }
}
