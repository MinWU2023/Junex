<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * 对齐 Translate 插件 /api/translate/static_block 与 Banner 可用结构：
 * - static_block_translations.name 可空列必须存在
 * - 仅回填空 name，不改写已有 title/content
 * - 缺默认语种翻译行时补最小行（name=sign），不写 title/content
 */
class AlignStaticBlockForTranslatePlugin extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_translations')) {
            return;
        }

        if (!Schema::hasColumn('static_blocks', 'is_translate')) {
            Schema::table('static_blocks', function (Blueprint $table) {
                $table->unsignedTinyInteger('is_translate')->default(0)->comment('0未翻译,1成功,2失败,3进行中');
            });
        }

        if (!Schema::hasColumn('static_block_translations', 'name')) {
            Schema::table('static_block_translations', function (Blueprint $table) {
                $table->string('name')->nullable()->comment('名称(Translate插件/云端必填兼容)');
            });
        }

        $sourceLocale = (string)(config('app.locale') ?: 'en');
        $blocks = DB::table('static_blocks')->select('id', 'sign')->orderBy('id')->get();

        foreach ($blocks as $block) {
            $sign = mb_substr(trim((string)$block->sign), 0, 255);
            $fallbackName = $sign !== '' ? $sign : ('static_block_' . $block->id);

            $translation = DB::table('static_block_translations')
                ->where('static_block_id', $block->id)
                ->where('locale', $sourceLocale)
                ->first();

            if (!$translation) {
                // 仅补拉取所需最小行，不填充业务正文
                DB::table('static_block_translations')->insert([
                    'static_block_id' => $block->id,
                    'locale' => $sourceLocale,
                    'name' => $fallbackName,
                    'title' => null,
                    'content' => null,
                ]);
                continue;
            }

            $currentName = trim((string)($translation->name ?? ''));
            if ($currentName !== '') {
                continue;
            }

            $fromTitle = mb_substr(trim(strip_tags((string)($translation->title ?? ''))), 0, 255);
            $name = $fromTitle !== '' ? $fromTitle : $fallbackName;

            DB::table('static_block_translations')
                ->where('id', $translation->id)
                ->where(function ($q) {
                    $q->whereNull('name')->orWhere('name', '');
                })
                ->update(['name' => $name]);
        }

        // 其它语种空 name：仅回填空值，不覆盖已有 name/title/content
        $signMap = $blocks->pluck('sign', 'id');
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
        // 保留列与回填数据，避免回滚破坏云端兼容
    }
}
