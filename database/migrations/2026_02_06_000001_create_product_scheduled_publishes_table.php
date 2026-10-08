<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductScheduledPublishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_scheduled_publishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('产品ID');
            $table->timestamp('publish_at')->comment('计划发布时间');
            $table->timestamps();

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->index('publish_at');
            $table->unique('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_scheduled_publishes');
    }
}
