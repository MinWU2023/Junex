<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVideoTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_video_translations')) {
            Schema::create('product_video_translations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('product_video_id')->unsigned();
                $table->string('locale')->index();
                $table->unique(['product_video_id', 'locale']);
                $table->string('name')->nullable()->comment('名称');
                $table->text('content')->nullable()->comment('内容');
                $table->foreign('product_video_id')
                    ->references('id')
                    ->on('product_videos')
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
        Schema::dropIfExists('product_video_translations');
    }
}
