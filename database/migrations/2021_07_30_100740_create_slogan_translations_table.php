<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSloganTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slogan_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('slogan_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['slogan_id', 'locale']);
            $table->foreign('slogan_id')
                ->references('id')
                ->on('slogans')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name')->nullable()->comment('标语');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slogan_translations');
    }
}
