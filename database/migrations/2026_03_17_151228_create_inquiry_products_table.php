<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_products', function (Blueprint $table) {
            $table->unsignedBigInteger('inquiry_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('quantity')->default(1);

            $table->index(['inquiry_id']);
            $table->index(['product_id']);
            $table->primary(['inquiry_id', 'product_id']);

            $table->foreign('inquiry_id')
                ->references('id')
                ->on('inquiries')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('inquiry_products');
    }
}
