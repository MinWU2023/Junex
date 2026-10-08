<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewsletterIsRead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('newsletter_id')->unsigned()->comment('订阅id');
            $table->bigInteger('user_id')->unsigned()->comment('用户id');
            $table->foreign('newsletter_id')->on('newsletters')
                ->references('id')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('user_id')->on('users')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unique(['newsletter_id', 'user_id']);
        });
        Schema::table('friend_links', function (Blueprint $table) {
            $table->string('locales')->nullable()->comment('绑定语种');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
