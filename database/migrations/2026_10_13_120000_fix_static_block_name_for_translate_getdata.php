<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Translate GetDataCollection 读取的是模型顶层 name。
 * 静态块业务正文在 title/content，把可稳定读取的 name 放在主表（=sign），
 * 翻译表保留可空 name 列满足云端表结构校验；不改写 title/content。
 */
class FixStaticBlockNameForTranslateGetdata extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('static_blocks')) {
            return;
        }

        if (!Schema::hasColumn('static_blocks', 'name')) {
            Schema::table('static_blocks', function (Blueprint $table) {
                $table->string('name')->nullable()->after('sign')->comment('Translate拉取展示名(默认=sign)');
            });
        }

        if (!Schema::hasColumn('static_blocks', 'is_translate')) {
            Schema::table('static_blocks', function (Blueprint $table) {
                $table->unsignedTinyInteger('is_translate')->default(0)->comment('0未翻译,1成功,2失败,3进行中');
            });
        }

        if (Schema::hasTable('static_block_translations') && !Schema::hasColumn('static_block_translations', 'name')) {
            Schema::table('static_block_translations', function (Blueprint $table) {
                $table->string('name')->nullable()->comment('名称(云端翻译表结构兼容)');
            });
        }

        // 主表 name：仅填空，默认用 sign
        DB::table('static_blocks')
            ->where(function ($q) {
                $q->whereNull('name')->orWhere('name', '');
            })
            ->orderBy('id')
            ->chunkById(200, function ($rows) {
                foreach ($rows as $row) {
                    $name = mb_substr(trim((string)$row->sign), 0, 255);
                    if ($name === '') {
                        $name = 'static_block_' . $row->id;
                    }
                    DB::table('static_blocks')->where('id', $row->id)->update(['name' => $name]);
                }
            });

        if (!Schema::hasTable('static_block_translations') || !Schema::hasColumn('static_block_translations', 'name')) {
            return;
        }

        // 翻译表 name：仅填空，不碰 title/content
        $signMap = DB::table('static_blocks')->pluck('sign', 'id');
        DB::table('static_block_translations')
            ->where(function ($q) {
                $q->whereNull('name')->orWhere('name', '');
            })
            ->orderBy('id')
            ->chunkById(200, function ($rows) use ($signMap) {
                foreach ($rows as $row) {
                    $fromTitle = mb_substr(trim(strip_tags((string)($row->title ?? ''))), 0, 255);
                    $fromSign = mb_substr(trim((string)($signMap[$row->static_block_id] ?? '')), 0, 255);
                    $name = $fromTitle !== '' ? $fromTitle : ($fromSign !== '' ? $fromSign : ('static_block_' . $row->static_block_id));
                    DB::table('static_block_translations')
                        ->where('id', $row->id)
                        ->where(function ($q) {
                            $q->whereNull('name')->orWhere('name', '');
                        })
                        ->update(['name' => $name]);
                }
            });
    }

    public function down()
    {
        if (Schema::hasTable('static_blocks') && Schema::hasColumn('static_blocks', 'name')) {
            Schema::table('static_blocks', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }
}
