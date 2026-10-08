<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_sends', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->comment('邮件标题')->charset('utf8mb4');;
            $table->text('content')->comment('邮件内容')->charset('utf8mb4');;
            $table->string('to_email')->comment('接收者邮箱');
            $table->string('cc_emails')->nullable()->comment('抄送邮箱');
            $table->string('from_email')->comment('发件人');
            $table->string('reply_to')->nullable()->comment('回复人邮箱');
            $table->text('error_message')->nullable()->comment('失败返回');
            $table->string('type')->comment('邮件类型');
            $table->unsignedTinyInteger('status')->default(0)->comment('0待发送，1发送成功，2发送失败,3暂停发送');
            $table->unsignedBigInteger('source_id')->default(0)->comment('源ID');
            $table->boolean('is_fail_send')->default(0)->comment('失败后已推送云平台');
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
        Schema::dropIfExists('email_sends');
    }
}
