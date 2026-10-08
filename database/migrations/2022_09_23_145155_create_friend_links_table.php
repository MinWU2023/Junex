<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('friend_links')){
            Schema::create('friend_links', function (Blueprint $table) {
                $table->id();
                $table->string('url')->comment("友情链接")->unique();

                $table->string('name')->nullable()->comment("名称");
                $table->string('path')->nullable()->comment("图片");

                $table->integer('type')->default(1)->comment("类型,1友链,2社交媒体");
                $table->timestamps();
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
        Schema::dropIfExists('friend_links');
    }
}
