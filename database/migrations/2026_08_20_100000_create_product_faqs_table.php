<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFaqsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('product_faqs')) {
            Schema::create('product_faqs', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('sort')->default(0)->comment('排序，越大越靠前');
                $table->unsignedBigInteger('source_faq_id')->nullable()->comment('同步自 faqs.id');
                $table->tinyInteger('active')->default(1)->comment('1启用 0禁用');
                $table->timestamps();

                $table->index('sort');
                $table->index('source_faq_id');
                $table->index('active');
            });
        }

        if (!Schema::hasTable('product_faq_translations')) {
            Schema::create('product_faq_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_faq_id');
                $table->string('locale', 10);
                $table->string('subject')->nullable();
                $table->text('content')->nullable();

                $table->unique(['product_faq_id', 'locale'], 'product_faq_translations_unique');
                $table->index('product_faq_id');
            });
        }

        if (!Schema::hasTable('product_faq_product')) {
            Schema::create('product_faq_product', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_faq_id');
                $table->unsignedBigInteger('product_id');
                $table->unsignedInteger('sort')->default(0);
                $table->timestamps();

                $table->unique(['product_faq_id', 'product_id'], 'product_faq_product_unique');
                $table->index('product_faq_id');
                $table->index('product_id');
            });
        }

        if (!Schema::hasTable('product_faq_product_category')) {
            Schema::create('product_faq_product_category', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_faq_id');
                $table->unsignedBigInteger('product_category_id');
                $table->unsignedInteger('sort')->default(0);
                $table->timestamps();

                $table->unique(['product_faq_id', 'product_category_id'], 'product_faq_category_unique');
                $table->index('product_faq_id');
                $table->index('product_category_id');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('product_faq_product_category');
        Schema::dropIfExists('product_faq_product');
        Schema::dropIfExists('product_faq_translations');
        Schema::dropIfExists('product_faqs');
    }
}
