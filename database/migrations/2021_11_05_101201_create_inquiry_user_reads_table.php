<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryUserReadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_user_reads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inquiry_id')->unsigned()->comment('询盘id');
            $table->bigInteger('user_id')->unsigned()->comment('用户id');
            $table->foreign('inquiry_id')->on('inquiries')
                ->references('id')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('user_id')->on('users')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unique(['inquiry_id','user_id']);
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
        Schema::dropIfExists('inquiry_user_reads');
    }
}
