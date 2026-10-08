<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_videos')) {
            Schema::create('product_videos', function (Blueprint $table) {
                $table->id();
                $table->string('path')->comment('封面图');
                $table->string('video_url')->comment('视频地址');
                $table->unsignedInteger('sort')->default(0)->comment('排序');
                $table->boolean('is_recommend')->default(0)->comment('是否推荐');
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
        Schema::dropIfExists('product_videos');
    }
}
