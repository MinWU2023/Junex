<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnsIconsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('sns_icons')) {
            Schema::create('sns_icons', function (Blueprint $table) {
                $table->id();
                $table->string('sign', 64)->unique()->comment('标识，如 twitter/linkedin');
                $table->string('path')->nullable()->comment('图标');
                $table->string('link', 1000)->nullable()->comment('链接（资料页/主页）');
                $table->unsignedInteger('sort')->default(0)->comment('排序');
                $table->boolean('active')->default(1)->comment('状态(兼容)');
                $table->boolean('link_active')->default(1)->comment('静态链接展示');
                $table->boolean('share_active')->default(1)->comment('分享功能展示');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('sns_icons');
    }
}
