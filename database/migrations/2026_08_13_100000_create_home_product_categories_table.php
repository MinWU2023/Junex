<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('home_product_categories')) {
            Schema::create('home_product_categories', function (Blueprint $table) {
                $table->id();
                $table->string('path')->nullable()->comment('图片');
                $table->string('button_url')->nullable()->comment('按钮链接');
                $table->unsignedInteger('sort')->default(0)->comment('排序');
                $table->boolean('active')->default(1)->comment('是否启用');
                $table->timestamps();
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
        Schema::dropIfExists('home_product_categories');
    }
}
