<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download_category_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('download_category_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['download_category_id', 'locale'],'download_category_id_locale_unique');
            $table->string('name')->nullable()->comment('分类名称');
            $table->string('title')->nullable()->comment('title');
            $table->string('keywords')->nullable()->comment('keywords');
            $table->string('description')->nullable()->comment('description');
            $table->foreign('download_category_id')
                ->references('id')
                ->on('download_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('download_category_translations');
    }
}
