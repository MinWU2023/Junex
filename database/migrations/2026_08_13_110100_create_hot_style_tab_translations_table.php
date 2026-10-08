<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotStyleTabTranslationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('hot_style_tab_translations')) {
            Schema::create('hot_style_tab_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('hot_style_tab_id');
                $table->string('locale')->index();
                $table->string('label')->nullable()->comment('Tab文案');
                $table->unique(['hot_style_tab_id', 'locale'], 'hot_style_tab_trans_unique');
                $table->foreign('hot_style_tab_id', 'hot_style_tab_trans_fk')
                    ->references('id')
                    ->on('hot_style_tabs')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('hot_style_tab_translations');
    }
}
