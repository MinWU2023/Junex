<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionTitleTranslationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('section_title_translations')) {
            Schema::create('section_title_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('section_title_id');
                $table->string('locale')->index();
                $table->string('title')->nullable()->comment('板块标题');
                $table->text('subtitle')->nullable()->comment('板块副标题');
                $table->unique(['section_title_id', 'locale']);
                $table->foreign('section_title_id')
                    ->references('id')
                    ->on('section_titles')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('section_title_translations');
    }
}
