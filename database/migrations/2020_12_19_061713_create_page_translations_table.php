<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('page_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['page_id', 'locale']);
            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name')->nullable()->comment('页面名称');
            $table->longText('content')->nullable()->comment('页面内容');
            $table->text('brief_content')->nullable()->comment('产品简介');
            $table->string('title')->nullable()->comment('标题');
            $table->string('keywords')->nullable()->comment('关键词');
            $table->string('description')->nullable()->comment('描述');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_translations');
    }
}
