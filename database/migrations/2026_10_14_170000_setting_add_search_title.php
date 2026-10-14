<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingAddSearchTitle extends Migration
{
    public function up()
    {
        Schema::table('setting_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('setting_translations', 'search_title')) {
                $table->string('search_title')->nullable()->after('search_placeholder')->comment('搜索框标题');
            }
        });
    }

    public function down()
    {
        Schema::table('setting_translations', function (Blueprint $table) {
            if (Schema::hasColumn('setting_translations', 'search_title')) {
                $table->dropColumn('search_title');
            }
        });
    }
}
