<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ForceLeftAlignFullCusSubtitles extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_translations')) {
            return;
        }

        $ids = DB::table('static_blocks')
            ->whereIn('sign', ['full_cus_intro', 'full_cus'])
            ->pluck('id');

        if ($ids->isEmpty()) {
            return;
        }

        $rows = DB::table('static_block_translations')
            ->whereIn('static_block_id', $ids->all())
            ->get(['id', 'content']);

        foreach ($rows as $row) {
            $content = (string) ($row->content ?? '');
            if ($content === '' || stripos($content, 'FULL CUSTOMIZATION') === false) {
                continue;
            }

            $updated = $this->transform($content);
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

    private function transform(string $content): string
    {
        $pattern = '/(<div class="flex flex-col items-center text-center">\s*)'
            . '(<div class="text-f32[\s\S]*?<\/div>\s*'
            . '<div class="mx-auto mt-3 h-\[7px\][\s\S]*?<\/div>)\s*'
            . '((?:<p[\s\S]*?<\/p>\s*)+)'
            . '(<\/div>)/i';

        $result = preg_replace_callback($pattern, function ($m) {
            return $m[1] . $m[2] . "\n        </div>\n\n        " . $this->markSubtitles($m[3]) . "\n";
        }, $content, 1);

        if (!is_string($result)) {
            $result = $content;
        }

        // Mark existing intro paragraphs (already outside centered wrapper).
        $result = preg_replace_callback(
            '/<p class="([^"]*)">(\s*(?:Our Full Customization|At Inqor)[\s\S]*?<\/p>)/i',
            function ($m) {
                $cls = $m[1];
                $cls = preg_replace('/\s*(?:mx-auto|text-left|full-cus-subtitle|max-w-\[[^\]]+\])\s*/', ' ', $cls);
                $cls = trim(preg_replace('/\s+/', ' ', $cls));
                return '<p class="full-cus-subtitle w-full ' . $cls . '">' . $m[2];
            },
            $result
        );

        return is_string($result) ? $result : $content;
    }

    private function markSubtitles(string $paras): string
    {
        $paras = preg_replace('/\s*(?:mx-auto|text-left|full-cus-subtitle|max-w-\[[^\]]+\])\s*/', ' ', $paras);
        $paras = preg_replace('/<p class="/i', '<p class="full-cus-subtitle w-full ', $paras);
        return trim($paras);
    }
}
