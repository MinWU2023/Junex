<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandSolutionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('brand_solution_translations')) {
            Schema::create('brand_solution_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('brand_solution_id');
                $table->string('locale')->index();
                $table->string('title')->nullable()->comment('标题');
                $table->text('description')->nullable()->comment('简介');
                $table->string('button_text')->nullable()->comment('按钮文案');
                $table->json('features')->nullable()->comment('文案列表项');
                $table->unique(['brand_solution_id', 'locale']);
                $table->foreign('brand_solution_id')
                    ->references('id')
                    ->on('brand_solutions')
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
        Schema::dropIfExists('brand_solution_translations');
    }
}
