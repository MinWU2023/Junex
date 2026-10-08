<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('download_category_id')->comment('分类id');
            $table->bigInteger('sort')->default(0)->comment('排序');
            $table->string('img')->nullable()->comment('图片');
            $table->string('url')->nullable()->comment('自定义url');
            $table->string('filepath')->nullable()->comment('附件');
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
        Schema::dropIfExists('downloads');
    }
}
