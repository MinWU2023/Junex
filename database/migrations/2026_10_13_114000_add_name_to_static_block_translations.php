<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddNameToStaticBlockTranslations extends Migration
{
    public function up()
    {
        if (Schema::hasTable('static_blocks') && !Schema::hasColumn('static_blocks', 'is_translate')) {
            Schema::table('static_blocks', function (Blueprint $table) {
                $table->unsignedTinyInteger('is_translate')->default(0)->comment('0未翻译,1成功,2失败,3进行中');
            });
        }

        if (Schema::hasTable('static_block_translations') && !Schema::hasColumn('static_block_translations', 'name')) {
            Schema::table('static_block_translations', function (Blueprint $table) {
                $table->string('name')->nullable()->comment('名称(云端翻译必填兼容字段)');
            });
        }

        if (!Schema::hasTable('static_block_translations') || !Schema::hasColumn('static_block_translations', 'name')) {
            return;
        }

        // 优先用 title 回填 name
        if (Schema::hasColumn('static_block_translations', 'title')) {
            DB::table('static_block_translations')
                ->where(function ($q) {
                    $q->whereNull('name')->orWhere('name', '');
                })
                ->whereNotNull('title')
                ->where('title', '<>', '')
                ->orderBy('id')
                ->chunkById(200, function ($rows) {
                    foreach ($rows as $row) {
                        $name = mb_substr(trim(strip_tags((string)$row->title)), 0, 255);
                        if ($name === '') {
                            continue;
                        }
                        DB::table('static_block_translations')->where('id', $row->id)->update(['name' => $name]);
                    }
                });
        }

        // title 仍为空时用主表 sign
        if (Schema::hasTable('static_blocks')) {
            $blocks = DB::table('static_blocks')->select('id', 'sign')->get();
            foreach ($blocks as $block) {
                $sign = mb_substr(trim((string)$block->sign), 0, 255);
                if ($sign === '') {
                    continue;
                }
                DB::table('static_block_translations')
                    ->where('static_block_id', $block->id)
                    ->where(function ($q) {
                        $q->whereNull('name')->orWhere('name', '');
                    })
                    ->update(['name' => $sign]);
            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('static_block_translations') && Schema::hasColumn('static_block_translations', 'name')) {
            Schema::table('static_block_translations', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
        if (Schema::hasTable('static_blocks') && Schema::hasColumn('static_blocks', 'is_translate')) {
            Schema::table('static_blocks', function (Blueprint $table) {
                $table->dropColumn('is_translate');
            });
        }
    }
}
