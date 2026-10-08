<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhyChooseCardTranslationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('why_choose_card_translations')) {
            Schema::create('why_choose_card_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('why_choose_card_id');
                $table->string('locale')->index();
                $table->string('label')->nullable()->comment('标签，如 Annual Output');
                $table->string('value')->nullable()->comment('数值，如 45');
                $table->string('value_suffix')->nullable()->comment('数值后缀');
                $table->text('description')->nullable()->comment('描述');
                $table->unique(['why_choose_card_id', 'locale'], 'why_choose_card_trans_unique');
                $table->foreign('why_choose_card_id', 'why_choose_card_trans_fk')
                    ->references('id')
                    ->on('why_choose_cards')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('why_choose_card_translations');
    }
}
