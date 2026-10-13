<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameToCustomSettingTranslationTables extends Migration
{
    protected array $tables = [
        'brand_solution_translations',
        'home_product_category_translations',
        'hot_style_tab_translations',
        'exciting_update_translations',
        'why_choose_card_translations',
        'custom_service_translations',
        'custom_service_item_translations',
        'section_title_translations',
        'sns_icon_translations',
        'why_choose_setting_translations',
    ];

    public function up()
    {
        foreach ($this->tables as $table) {
            if (!Schema::hasTable($table) || Schema::hasColumn($table, 'name')) {
                continue;
            }
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->string('name')->nullable()->comment('名称(云端翻译必填兼容字段)');
            });
        }
    }

    public function down()
    {
        foreach ($this->tables as $table) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'name')) {
                continue;
            }
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropColumn('name');
            });
        }
    }
}
