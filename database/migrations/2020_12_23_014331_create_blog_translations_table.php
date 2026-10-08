<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('blog_translations')){
            Schema::create('blog_translations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('blog_id')->unsigned();
                $table->string('locale')->index();
                $table->unique(['blog_id', 'locale']);
                $table->string('name')->nullable()->comment('博客标题');
                $table->text('content')->nullable()->comment('博客内容');
                $table->string('title')->nullable()->comment('标题');
                $table->string('keywords')->nullable()->comment('关键词');
                $table->string('description')->nullable()->comment('描述');
                $table->foreign('blog_id')
                    ->references('id')
                    ->on('blogs')
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
//        Schema::dropIfExists('blog_translations');
    }
}
