<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort')->default(0)->comment('排序');
            $table->unsignedBigInteger('parent_id')->index()->default(0)->comment('父级id');
            $table->string('img')->nullable()->comment('封面图');
            $table->string('url_key')->comment('自定义url链接');
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
        Schema::dropIfExists('download_categories');
    }
}
