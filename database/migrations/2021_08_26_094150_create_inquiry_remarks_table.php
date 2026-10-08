<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_remarks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_user_id')->comment('用户id');
            $table->bigInteger('inquiry_id')->unsigned()->comment('关联inquiries');
            $table->foreign('inquiry_id')
                ->references('id')
                ->on('inquiries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('content')->comment('内容');
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
        Schema::dropIfExists('inquiry_remarks');
    }
}
