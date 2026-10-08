<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('download_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['download_id', 'locale']);
            $table->string('name')->nullable()->comment('名称');
            $table->string('content')->nullable()->comment('内容');
            $table->foreign('download_id')
                ->references('id')
                ->on('downloads')
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
        Schema::dropIfExists('download_translations');
    }
}
