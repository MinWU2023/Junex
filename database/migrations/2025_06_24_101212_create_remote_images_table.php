<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemoteImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('operation_guide')->nullable()->comment('操作指南');
        });

        Schema::create('remote_images', function (Blueprint $table) {
            $table->id();
            $table->string('remote_url')->unique()->comment('远程图片地址');
            $table->string('locale_url')->comment('下载图片地址');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('remote_images');
    }
}
