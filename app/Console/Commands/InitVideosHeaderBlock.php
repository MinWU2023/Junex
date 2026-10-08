<?php

namespace App\Console\Commands;

use App\Modules\Page\Models\StaticBlock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class InitVideosHeaderBlock extends Command
{
    protected $signature = 'init:videos-header-block {--force : Overwrite existing content}';

    protected $description = 'Create /videos page title+subtitle static block and bind to videos page key';

    public function handle(): int
    {
        if (!Schema::hasTable('static_blocks')) {
            $this->error('static_blocks table missing.');
            return 1;
        }

        $force = (bool)$this->option('force');
        $sign = 'videos_header';
        $title = 'Product Videos';
        $subtitle = 'Watch factory showcases, product highlights, and customization workflows from our sportswear production line.';

        $html = view('static_block_templates.videos_header', [
            'title' => $title,
            'subtitle' => $subtitle,
        ])->render();

        $locales = $this->resolveLocales();
        $block = StaticBlock::query()->where('sign', $sign)->first();

        if ($block && !$force) {
            $this->warn("Static block [{$sign}] already exists. Use --force to overwrite content.");
        } else {
            $payload = [
                'sign' => $sign,
                'sort' => 60,
                'active' => 1,
                'remark' => 'Videos 列表页：主标题 + 副标题',
            ];

            foreach ($locales as $locale) {
                $payload[$locale] = [
                    'title' => $title,
                    'content' => $html,
                ];
            }

            if (!$block) {
                $block = StaticBlock::create($payload);
                $this->info("Created static block [{$sign}].");
            } else {
                $block->update($payload);
                $this->info("Updated static block [{$sign}].");
            }
        }

        if (Schema::hasTable('static_block_page_keys')) {
            $exists = $block->pageKeys()->where('page_key', 'videos')->exists();
            if (!$exists) {
                $block->pageKeys()->create(['page_key' => 'videos']);
                $this->info('Bound videos_header -> page_key: videos.');
            } else {
                $this->line('page_key [videos] already bound.');
            }
        } else {
            $this->warn('static_block_page_keys table missing; skip page association.');
        }

        return 0;
    }

    /**
     * @return string[]
     */
    private function resolveLocales(): array
    {
        $locales = config('translatable.locales', []);
        if (!is_array($locales) || $locales === []) {
            $fallback = (string)(config('translatable.fallback_locale') ?: config('app.fallback_locale', 'en'));
            return [$fallback !== '' ? $fallback : 'en'];
        }

        $out = [];
        foreach ($locales as $key => $value) {
            if (is_string($key) && !is_numeric($key)) {
                $out[] = $key;
            } elseif (is_string($value)) {
                $out[] = $value;
            }
        }

        $out = array_values(array_unique(array_filter($out)));
        return $out !== [] ? $out : ['en'];
    }
}
