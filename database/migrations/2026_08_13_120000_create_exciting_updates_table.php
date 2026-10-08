<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcitingUpdatesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('exciting_updates')) {
            Schema::create('exciting_updates', function (Blueprint $table) {
                $table->id();
                $table->string('path')->nullable()->comment('封面图');
                $table->string('button_url')->nullable()->comment('按钮/详情链接');
                $table->date('published_at')->nullable()->comment('展示日期');
                $table->unsignedInteger('sort')->default(0)->comment('排序');
                $table->boolean('active')->default(1)->comment('是否启用');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('exciting_updates');
    }
}
