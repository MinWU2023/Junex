<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsTranslateToCustomSettingTables extends Migration
{
    protected array $tables = [
        'brand_solutions',
        'home_product_categories',
        'hot_style_tabs',
        'why_choose_cards',
        'why_choose_settings',
        'custom_services',
        'custom_service_items',
        'section_titles',
        'sns_icons',
    ];

    public function up()
    {
        foreach ($this->tables as $table) {
            if (!Schema::hasTable($table) || Schema::hasColumn($table, 'is_translate')) {
                continue;
            }
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->unsignedTinyInteger('is_translate')->default(0)->comment('0未翻译,1成功,2失败,3进行中');
            });
        }
    }

    public function down()
    {
        foreach ($this->tables as $table) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'is_translate')) {
                continue;
            }
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropColumn('is_translate');
            });
        }
    }
}
