<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVideoCategoriesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('product_video_categories')) {
            Schema::create('product_video_categories', function (Blueprint $table) {
                $table->id();
                $table->string('path')->nullable()->comment('封面图');
                $table->string('url_key')->nullable()->index()->comment('URL');
                $table->unsignedInteger('sort')->default(0)->comment('排序');
                $table->boolean('active')->default(1)->comment('是否启用');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('product_video_categories');
    }
}
