<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LeftAlignFullCusIntroSubtitles extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_translations')) {
            return;
        }

        $blockId = DB::table('static_blocks')->where('sign', 'full_cus_intro')->value('id');
        if (!$blockId) {
            return;
        }

        $rows = DB::table('static_block_translations')
            ->where('static_block_id', $blockId)
            ->get(['id', 'content']);

        foreach ($rows as $row) {
            $content = (string) ($row->content ?? '');
            if ($content === '') {
                continue;
            }

            $updated = $this->leftAlignIntroCopy($content);
            if ($updated !== $content) {
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

    private function leftAlignIntroCopy(string $content): string
    {
        // Keep title + red bar centered; move following <p> out of the centered wrapper and left-align them.
        $pattern = '/(<div class="flex flex-col items-center text-center">\s*)'
            . '(<div class="text-f32[\s\S]*?<\/div>\s*'
            . '<div class="mx-auto mt-3 h-\[7px\][\s\S]*?<\/div>)\s*'
            . '((?:<p[\s\S]*?<\/p>\s*)+)'
            . '(<\/div>)/i';

        $result = preg_replace_callback($pattern, function ($m) {
            $paras = $m[3];
            $paras = preg_replace('/\s*mx-auto\s*/', ' ', $paras);
            $paras = preg_replace('/\s*max-w-\[[^\]]+\]\s*/', ' w-full ', $paras);
            $paras = preg_replace('/<p class="/i', '<p class="text-left ', $paras);

            return $m[1] . $m[2] . "\n        </div>\n\n        " . trim($paras) . "\n";
        }, $content, 1);

        return is_string($result) ? $result : $content;
    }
}
