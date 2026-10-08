<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnsIconTranslationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('sns_icon_translations')) {
            Schema::create('sns_icon_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('sns_icon_id');
                $table->string('locale')->index();
                $table->string('alt')->nullable()->comment('Alt 属性（多语言）');
                $table->unique(['sns_icon_id', 'locale']);
                $table->foreign('sns_icon_id')
                    ->references('id')
                    ->on('sns_icons')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('sns_icon_translations');
    }
}
