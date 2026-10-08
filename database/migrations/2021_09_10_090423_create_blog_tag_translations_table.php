<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTagTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('blog_tag_translations')){
            Schema::create('blog_tag_translations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('blog_tag_id')->unsigned()->comment('博客tag');
                $table->string("locale")->comment("语言");
                $table->unique(['blog_tag_id','locale']);//创建联合索引
                $table->string("name")->nullable()->comment("关键词名");

                $table->foreign('blog_tag_id')
                    ->references('id')
                    ->on('blog_tags')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                //设置外键约束
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
    }
}
