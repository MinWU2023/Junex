<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhyChooseCardsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('why_choose_cards')) {
            Schema::create('why_choose_cards', function (Blueprint $table) {
                $table->id();
                $table->string('image_mobile')->nullable()->comment('移动端图片');
                $table->string('background_desktop')->nullable()->comment('桌面端背景图');
                $table->string('url')->nullable()->comment('链接');
                $table->unsignedInteger('sort')->default(0)->comment('排序');
                $table->boolean('active')->default(1)->comment('是否启用');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('why_choose_cards');
    }
}
