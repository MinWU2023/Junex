<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('faq_translations')) {
            Schema::create('faq_translations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('faq_id')->unsigned();
                $table->string('locale')->index();
                $table->unique(['faq_id', 'locale']);
                $table->string('subject')->nullable()->comment('问题');
                $table->text('content')->nullable()->comment('答案');
                $table->foreign('faq_id')
                    ->references('id')
                    ->on('faqs')
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
        Schema::dropIfExists('faq_translations');
    }
}
