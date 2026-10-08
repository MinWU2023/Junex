<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGibberishScoreToInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->integer('gibberish_score')->default(0)->comment('垃圾指数评分');
            $table->text('gibberish_details')->nullable()->comment('垃圾检测详情');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('gibberish_threshold')->default(60)->comment('垃圾指数阈值分，超过此分不显示询盘且不转发邮件');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['gibberish_score', 'gibberish_details']);
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('gibberish_threshold');
        });
    }
}
