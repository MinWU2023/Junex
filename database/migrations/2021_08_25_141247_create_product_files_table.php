<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned()->comment('关联products');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
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
        Schema::dropIfExists('product_files');
    }
}
