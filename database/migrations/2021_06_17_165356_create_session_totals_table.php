<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_totals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_website_id')->nullable()->comment("网站id");

            $table->string('sessionMedium',300)->nullable()->comment("流量来源");
            $table->string('sessionSource',300)->nullable()->comment("媒介");
            $table->integer('sessions')->nullable()->comment("流量数");
            $table->integer('newUsers')->nullable()->comment("新用户");
            $table->float('average_time')->nullable()->comment("平均浏览时间");
            $table->float('input_probability')->nullable()->comment("投入率");
            $table->float('average_browse')->nullable()->comment("平均网页浏览");
            $table->integer('conversions')->nullable()->comment("转化次数");
            $table->string("md",500)->nullable()->comment("标识");
            $table->integer('date')->nullable()->comment('创建时间');

            $table->integer('userEngagementDuration')->nullable()->comment("参与时长");
            $table->integer('engagedSessions')->nullable()->comment("参与会话数");
            $table->integer('screenPageViews')->nullable()->comment("页面浏览数");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_totals');
    }
}
