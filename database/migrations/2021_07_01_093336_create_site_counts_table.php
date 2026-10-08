<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_counts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('data')->comment('收录数量');
            $table->date('check_date')->comment('检测日期');
            $table->mediumInteger('add_date')->comment('上传时间');
            $table->char('type')->comment('1权重，2主网站收录，3总网站收录');
            $table->index(['check_date','type']);
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
        Schema::dropIfExists('site_counts');
    }
}
