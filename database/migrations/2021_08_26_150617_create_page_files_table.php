<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('page_id')->unsigned()->comment('关联pages');
            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name')->comment('附件名称');
            $table->string('path')->comment('附件路径');
            $table->unsignedInteger('sort')->default(0)->comment('排序，数字越大越靠前');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_files');
    }
}
