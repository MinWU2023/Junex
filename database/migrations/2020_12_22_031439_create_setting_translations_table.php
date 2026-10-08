<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('setting_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['setting_id', 'locale']);
            $table->foreign('setting_id')
                ->references('id')
                ->on('settings')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name')->nullable()->comment('网站名');
            $table->string('title')->nullable()->comment('标题');
            $table->string('keywords')->nullable()->comment('关键词');
            $table->string('description',500)->nullable()->comment('描述');

            $table->string('seo_products_title')->nullable()->comment('产品分类title模板');
            $table->string('seo_products_description',500)->nullable()->comment('产品分类description模板');
            $table->string('seo_products_keywords')->nullable()->comment('产品分类keyword模板');

            $table->string('seo_product_title')->nullable()->comment('产品详情title模板');
            $table->string('seo_product_description',500)->nullable()->comment('产品详情description模板');
            $table->string('seo_product_keywords')->nullable()->comment('产品详情关键词keyword模板');

            $table->string('seo_product_category_title')->nullable()->comment('产品分类title模板');
            $table->string('seo_product_category_description',500)->nullable()->comment('产品分类description模板');
            $table->string('seo_product_category_keywords')->nullable()->comment('产品分类keyword模板');

            $table->string('seo_product_tag_title')->nullable()->comment('产品TAG标题模板');
            $table->string('seo_product_tag_description',500)->nullable()->comment('产品TAG描述模板');
            $table->string('seo_product_tag_keywords')->nullable()->comment('产品TAG关键词模板');

            $table->string('seo_articles_title')->nullable()->comment('文章列表title模板');
            $table->string('seo_articles_description',500)->nullable()->comment('文章列表description模板');
            $table->string('seo_articles_keywords')->nullable()->comment('文章列表keywords模板');

            $table->string('seo_article_category_title')->nullable()->comment('文章分类title模板');
            $table->string('seo_article_category_description',500)->nullable()->comment('文章分类description模板');
            $table->string('seo_article_category_keywords')->nullable()->comment('文章分类keywords模板');

            $table->string('seo_article_title')->nullable()->comment('文章title模板');
            $table->string('seo_article_description',500)->nullable()->comment('文章description模板');
            $table->string('seo_article_keywords')->nullable()->comment('文章keywords模板');

            $table->string('seo_blogs_title')->nullable()->comment('博客列表title模板');
            $table->string('seo_blogs_description',500)->nullable()->comment('博客列表description模板');
            $table->string('seo_blogs_keywords')->nullable()->comment('博客列表keywords模板');

            $table->string('seo_blog_category_title')->nullable()->comment('博客分类title模板');
            $table->string('seo_blog_category_description',500)->nullable()->comment('博客分类description模板');
            $table->string('seo_blog_category_keywords')->nullable()->comment('博客分类keywords模板');

            $table->string('seo_blog_title')->nullable()->comment('博客title模板');
            $table->string('seo_blog_description',500)->nullable()->comment('博客description模板');
            $table->string('seo_blog_keywords')->nullable()->comment('博客keywords模板');

            $table->string('seo_blog_tag_title')->nullable()->comment('博客tag title模板');
            $table->string('seo_blog_tag_description',500)->nullable()->comment('博客tag description模板');
            $table->string('seo_blog_tag_keywords')->nullable()->comment('博客tag keywords模板');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_translations');
    }
}
