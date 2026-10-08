<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionTitlesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('section_titles')) {
            Schema::create('section_titles', function (Blueprint $table) {
                $table->id();
                $table->string('sign', 64)->unique()->comment('板块标识');
                $table->string('name')->comment('后台显示名称');
                $table->unsignedInteger('sort')->default(0)->comment('排序');
                $table->boolean('active')->default(1)->comment('是否启用');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('section_titles');
    }
}
