<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqGroupTranslationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('faq_group_translations')) {
            Schema::create('faq_group_translations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('faq_group_id')->unsigned();
                $table->string('locale')->index();
                $table->unique(['faq_group_id', 'locale']);
                $table->string('name')->nullable()->comment('分组名称');
                $table->text('content')->nullable()->comment('分组描述');

                $table->foreign('faq_group_id')
                    ->references('id')
                    ->on('faq_groups')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('faq_group_translations');
    }
}
