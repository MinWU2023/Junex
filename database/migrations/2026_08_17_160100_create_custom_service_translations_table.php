<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomServiceTranslationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('custom_service_translations')) {
            Schema::create('custom_service_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('custom_service_id');
                $table->string('locale')->index();
                $table->string('title_prefix')->nullable()->comment('标题前缀，如 ODM');
                $table->string('title_suffix')->nullable()->comment('标题后缀');
                $table->string('subtitle')->nullable()->comment('副标题');
                $table->unique(['custom_service_id', 'locale']);
                $table->foreign('custom_service_id')
                    ->references('id')
                    ->on('custom_services')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('custom_service_translations');
    }
}
