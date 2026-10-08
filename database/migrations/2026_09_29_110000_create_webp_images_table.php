<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebpImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webp_images', function (Blueprint $table) {
            $table->id();
            $table->string('path', 500)->comment('原图站点相对路径，如 /front/imgs/a.png');
            $table->unsignedTinyInteger('status')->default(0)->comment('0待转换 1已完成 2失败');
            $table->string('path_webp', 500)->nullable()->comment('webp 路径，如 /webps/front/imgs/a.webp');
            $table->timestamps();

            $table->unique('path');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webp_images');
    }
}
