<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class CreateCsCertAndSampleStagesStaticBlocks extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('static_blocks')
            || !Schema::hasTable('static_block_translations')
            || !Schema::hasTable('static_block_page')
            || !Schema::hasTable('pages')
        ) {
            return;
        }

        $pageId = DB::table('pages')
            ->where(function ($q) {
                $q->where('url_key', 'customer-services')
                    ->orWhere('url_key', '/customer-services');
            })
            ->value('id');

        if (!$pageId) {
            return;
        }

        $locales = $this->resolveLocales();
        $now = now();

        $blocks = [
            [
                'sign' => 'certificates',
                'title' => 'Multiple Certificate Verification',
                'remark' => 'Customer Services：证书展示（Swiper）',
                'sort' => 40,
                'view' => 'static_block_templates.certificates',
            ],
            [
                'sign' => 'sample_stages',
                'title' => 'Four Sample Stages',
                'remark' => 'Customer Services：样品阶段卡片',
                'sort' => 50,
                'view' => 'static_block_templates.sample_stages',
            ],
        ];

        foreach ($blocks as $blockMeta) {
            $html = View::make($blockMeta['view'])->render();

            $blockId = DB::table('static_blocks')->where('sign', $blockMeta['sign'])->value('id');
            if (!$blockId) {
                $blockId = DB::table('static_blocks')->insertGetId([
                    'sign' => $blockMeta['sign'],
                    'sort' => $blockMeta['sort'],
                    'active' => 1,
                    'remark' => $blockMeta['remark'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            } else {
                DB::table('static_blocks')->where('id', $blockId)->update([
                    'sort' => $blockMeta['sort'],
                    'active' => 1,
                    'remark' => $blockMeta['remark'],
                    'updated_at' => $now,
                ]);
            }

            foreach ($locales as $locale) {
                $exists = DB::table('static_block_translations')
                    ->where('static_block_id', $blockId)
                    ->where('locale', $locale)
                    ->exists();

                if ($exists) {
                    DB::table('static_block_translations')
                        ->where('static_block_id', $blockId)
                        ->where('locale', $locale)
                        ->update([
                            'title' => $blockMeta['title'],
                            'content' => $html,
                        ]);
                } else {
                    DB::table('static_block_translations')->insert([
                        'static_block_id' => $blockId,
                        'locale' => $locale,
                        'title' => $blockMeta['title'],
                        'content' => $html,
                    ]);
                }
            }

            $bound = DB::table('static_block_page')
                ->where('static_block_id', $blockId)
                ->where('page_id', $pageId)
                ->exists();

            if (!$bound) {
                DB::table('static_block_page')->insert([
                    'static_block_id' => $blockId,
                    'page_id' => $pageId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down()
    {
        if (!Schema::hasTable('static_blocks')) {
            return;
        }

        $signs = ['certificates', 'sample_stages'];
        $blockIds = DB::table('static_blocks')->whereIn('sign', $signs)->pluck('id')->all();
        if (empty($blockIds)) {
            return;
        }

        if (Schema::hasTable('static_block_page')) {
            DB::table('static_block_page')->whereIn('static_block_id', $blockIds)->delete();
        }
        if (Schema::hasTable('static_block_page_keys')) {
            DB::table('static_block_page_keys')->whereIn('static_block_id', $blockIds)->delete();
        }
        if (Schema::hasTable('static_block_translations')) {
            DB::table('static_block_translations')->whereIn('static_block_id', $blockIds)->delete();
        }
        DB::table('static_blocks')->whereIn('id', $blockIds)->delete();
    }

    /** @return string[] */
    private function resolveLocales(): array
    {
        $locales = config('translatable.locales', []);
        $flat = [];
        foreach ((array)$locales as $key => $value) {
            if (is_array($value)) {
                $flat[] = (string)$key;
                foreach ($value as $child) {
                    $flat[] = is_string($child) ? $child : (string)$key;
                }
            } else {
                $flat[] = (string)$value;
            }
        }

        $flat[] = (string)config('app.locale', 'en');
        $flat[] = (string)config('app.fallback_locale', 'en');
        $flat = array_values(array_unique(array_filter(array_map('strval', $flat))));

        return !empty($flat) ? $flat : ['en'];
    }
}
