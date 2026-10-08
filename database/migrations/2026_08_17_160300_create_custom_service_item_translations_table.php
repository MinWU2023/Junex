<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomServiceItemTranslationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('custom_service_item_translations')) {
            Schema::create('custom_service_item_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('custom_service_item_id');
                $table->string('locale')->index();
                $table->string('title')->nullable()->comment('卡片标题');
                $table->unique(['custom_service_item_id', 'locale'], 'cs_item_locale_unique');
                $table->foreign('custom_service_item_id', 'cs_item_trans_fk')
                    ->references('id')
                    ->on('custom_service_items')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('custom_service_item_translations');
    }
}
