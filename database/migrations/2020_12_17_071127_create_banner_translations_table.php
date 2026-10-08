<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('banner_id')->comment('banner id');
            $table->foreign('banner_id')->on('banners')->references('id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('locale')->index()->comment('语种');
            $table->string('name')->nullable()->comment('名称');
            $table->string('description')->nullable()->comment('描述');
            $table->string('button_text')->nullable()->comment('按钮文案');
            $table->unique(['banner_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_translations');
    }
}
