<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CenterFullCusCardDescriptions extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_translations')) {
            return;
        }

        $blockId = DB::table('static_blocks')->where('sign', 'full_cus')->value('id');
        if (!$blockId) {
            return;
        }

        $rows = DB::table('static_block_translations')
            ->where('static_block_id', $blockId)
            ->get(['id', 'content']);

        foreach ($rows as $row) {
            $content = (string) ($row->content ?? '');
            if ($content === '' || stripos($content, 'grid') === false) {
                continue;
            }

            // Ensure card description paragraphs are text-center (not left by prior CSS conflict).
            $updated = preg_replace_callback(
                '/(<div class="[^"]*text-center[^"]*ring-1 ring-black\/10"[^>]*>[\s\S]*?<p class=")([^"]*)("[^>]*>)/i',
                function ($m) {
                    $cls = $m[2];
                    $cls = preg_replace('/\s*(?:text-left|align-center|full-cus-subtitle)\s*/', ' ', $cls);
                    if (stripos($cls, 'text-center') === false) {
                        $cls = 'text-center ' . trim($cls);
                    }
                    $cls = trim(preg_replace('/\s+/', ' ', $cls));
                    return $m[1] . $cls . $m[3];
                },
                $content
            );

            // Also strip any inline text-align:left on card paragraphs
            if (is_string($updated)) {
                $updated = preg_replace_callback(
                    '/(<div class="[^"]*ring-1 ring-black\/10"[^>]*>[\s\S]*?<p[^>]*)(style="[^"]*")/i',
                    function ($m) {
                        $style = $m[2];
                        $style = preg_replace('/text-align\s*:\s*left\s*!important;?/i', 'text-align:center !important;', $style);
                        return $m[1] . $style;
                    },
                    $updated
                );
            }

            if (is_string($updated) && $updated !== $content) {
                DB::table('static_block_translations')->where('id', $row->id)->update([
                    'content' => $updated,
                ]);
            }
        }
    }

    public function down()
    {
        // no-op
    }
}
