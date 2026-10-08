<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeProductCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('home_product_category_translations')) {
            Schema::create('home_product_category_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('home_product_category_id');
                $table->string('locale')->index();
                $table->text('title')->nullable()->comment('标题(可含HTML)');
                $table->text('description')->nullable()->comment('简介(可含HTML)');
                $table->string('button_text')->nullable()->comment('按钮文案');
                $table->string('alt')->nullable()->comment('图片alt');
                $table->unique(['home_product_category_id', 'locale'], 'home_pc_trans_unique');
                $table->foreign('home_product_category_id', 'home_pc_trans_fk')
                    ->references('id')
                    ->on('home_product_categories')
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
        Schema::dropIfExists('home_product_category_translations');
    }
}
