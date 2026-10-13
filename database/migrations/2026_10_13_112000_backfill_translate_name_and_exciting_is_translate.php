<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackfillTranslateNameAndExcitingIsTranslate extends Migration
{
    public function up()
    {
        if (Schema::hasTable('exciting_updates') && !Schema::hasColumn('exciting_updates', 'is_translate')) {
            Schema::table('exciting_updates', function (Blueprint $table) {
                $table->unsignedTinyInteger('is_translate')->default(0)->comment('0未翻译,1成功,2失败,3进行中');
            });
        }

        // 确保翻译表 name 列存在（兼容未跑上一迁移的环境）
        $translationTables = [
            'brand_solution_translations' => 'title',
            'home_product_category_translations' => 'title',
            'hot_style_tab_translations' => 'label',
            'exciting_update_translations' => 'title',
            'why_choose_card_translations' => 'label',
            'custom_service_translations' => 'title_prefix',
            'custom_service_item_translations' => 'title',
            'section_title_translations' => 'title',
            'sns_icon_translations' => 'alt',
            'why_choose_setting_translations' => 'title',
        ];

        foreach ($translationTables as $table => $sourceColumn) {
            if (!Schema::hasTable($table)) {
                continue;
            }
            if (!Schema::hasColumn($table, 'name')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->string('name')->nullable()->comment('名称(云端翻译必填兼容字段)');
                });
            }
            if (!Schema::hasColumn($table, $sourceColumn) || !Schema::hasColumn($table, 'name')) {
                continue;
            }

            DB::table($table)
                ->where(function ($q) {
                    $q->whereNull('name')->orWhere('name', '');
                })
                ->whereNotNull($sourceColumn)
                ->where($sourceColumn, '<>', '')
                ->orderBy('id')
                ->chunkById(200, function ($rows) use ($table, $sourceColumn) {
                    foreach ($rows as $row) {
                        $raw = (string)($row->{$sourceColumn} ?? '');
                        $name = mb_substr(trim(strip_tags($raw)), 0, 255);
                        if ($name === '') {
                            continue;
                        }
                        DB::table($table)->where('id', $row->id)->update(['name' => $name]);
                    }
                });
        }

        // SNS：alt 为空时用主表 sign 回填
        if (Schema::hasTable('sns_icon_translations') && Schema::hasTable('sns_icons') && Schema::hasColumn('sns_icon_translations', 'name')) {
            $icons = DB::table('sns_icons')->select('id', 'sign')->get();
            foreach ($icons as $icon) {
                $sign = mb_substr(trim((string)$icon->sign), 0, 255);
                if ($sign === '') {
                    continue;
                }
                DB::table('sns_icon_translations')
                    ->where('sns_icon_id', $icon->id)
                    ->where(function ($q) {
                        $q->whereNull('name')->orWhere('name', '');
                    })
                    ->update(['name' => $sign]);
            }
        }

        // section_title：用主表 name 回填翻译表 name（仅作云端兼容，不进 translatedAttributes）
        if (Schema::hasTable('section_title_translations') && Schema::hasTable('section_titles') && Schema::hasColumn('section_title_translations', 'name')) {
            $sections = DB::table('section_titles')->select('id', 'name')->get();
            foreach ($sections as $section) {
                $name = mb_substr(trim((string)$section->name), 0, 255);
                if ($name === '') {
                    continue;
                }
                DB::table('section_title_translations')
                    ->where('section_title_id', $section->id)
                    ->where(function ($q) {
                        $q->whereNull('name')->orWhere('name', '');
                    })
                    ->update(['name' => $name]);
            }
        }

        // exciting_update：从关联博客 name 回填
        if (Schema::hasTable('exciting_update_translations')
            && Schema::hasTable('exciting_updates')
            && Schema::hasTable('blog_translations')
            && Schema::hasColumn('exciting_update_translations', 'name')
        ) {
            $rows = DB::table('exciting_updates as eu')
                ->join('blog_translations as bt', function ($join) {
                    $join->on('bt.blog_id', '=', 'eu.blog_id')
                        ->where('bt.locale', '=', config('app.locale', 'en'));
                })
                ->whereNotNull('eu.blog_id')
                ->select('eu.id as exciting_update_id', 'bt.name as blog_name', 'bt.locale')
                ->get();

            foreach ($rows as $row) {
                $name = mb_substr(trim(strip_tags((string)$row->blog_name)), 0, 255);
                if ($name === '') {
                    continue;
                }
                DB::table('exciting_update_translations')->updateOrInsert(
                    [
                        'exciting_update_id' => $row->exciting_update_id,
                        'locale' => $row->locale ?: config('app.locale', 'en'),
                    ],
                    [
                        'name' => $name,
                    ]
                );
            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('exciting_updates') && Schema::hasColumn('exciting_updates', 'is_translate')) {
            Schema::table('exciting_updates', function (Blueprint $table) {
                $table->dropColumn('is_translate');
            });
        }
    }
}
