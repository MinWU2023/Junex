<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVideoCategoryTranslationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('product_video_category_translations')) {
            Schema::create('product_video_category_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_video_category_id');
                $table->string('locale')->index();
                $table->unique(['product_video_category_id', 'locale'], 'pvct_cat_locale_unique');
                $table->string('name')->nullable()->comment('名称');
                $table->text('content')->nullable()->comment('简介');
                $table->longText('content2')->nullable()->comment('详情');
                $table->string('title')->nullable()->comment('SEO标题');
                $table->string('keywords')->nullable()->comment('SEO关键词');
                $table->text('description')->nullable()->comment('SEO描述');
                $table->foreign('product_video_category_id', 'pvct_cat_fk')
                    ->references('id')
                    ->on('product_video_categories')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('product_video_category_translations');
    }
}
