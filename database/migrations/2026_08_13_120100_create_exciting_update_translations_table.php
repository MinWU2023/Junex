<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcitingUpdateTranslationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('exciting_update_translations')) {
            Schema::create('exciting_update_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('exciting_update_id');
                $table->string('locale')->index();
                $table->string('title')->nullable()->comment('标题');
                $table->string('button_text')->nullable()->comment('按钮文案');
                $table->string('alt')->nullable()->comment('图片alt');
                $table->unique(['exciting_update_id', 'locale'], 'exciting_update_trans_unique');
                $table->foreign('exciting_update_id', 'exciting_update_trans_fk')
                    ->references('id')
                    ->on('exciting_updates')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('exciting_update_translations');
    }
}
