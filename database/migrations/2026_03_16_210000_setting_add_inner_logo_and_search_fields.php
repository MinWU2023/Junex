<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingAddInnerLogoAndSearchFields extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'inner_logo')) {
                $table->string('inner_logo')->nullable()->comment('内页logo');
            }
        });

        Schema::table('setting_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('setting_translations', 'search_placeholder')) {
                $table->string('search_placeholder')->nullable()->comment('搜索提示词');
            }
            if (!Schema::hasColumn('setting_translations', 'search_hot_keywords')) {
                $table->string('search_hot_keywords')->nullable()->comment('搜索热门关键词');
            }
            if (!Schema::hasColumn('setting_translations', 'seo_home_title')) {
                $table->string('seo_home_title')->nullable()->comment('首页标题模板');
            }
            if (!Schema::hasColumn('setting_translations', 'seo_home_keywords')) {
                $table->string('seo_home_keywords')->nullable()->comment('首页关键词模板');
            }
            if (!Schema::hasColumn('setting_translations', 'seo_home_description')) {
                $table->string('seo_home_description')->nullable()->comment('首页描述模板');
            }
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'inner_logo')) {
                $table->dropColumn('inner_logo');
            }
        });

        Schema::table('setting_translations', function (Blueprint $table) {
            $columns = [
                'search_placeholder',
                'search_hot_keywords',
                'seo_home_title',
                'seo_home_keywords',
                'seo_home_description',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('setting_translations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
