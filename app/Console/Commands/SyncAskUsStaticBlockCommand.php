<?php

namespace App\Console\Commands;

use App\Modules\Page\Models\Page;
use App\Modules\Page\Models\StaticBlock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Re-sync ask_us / ask_us_home HTML from blade templates and restore page associations.
 */
class SyncAskUsStaticBlockCommand extends Command
{
    protected $signature = 'static-block:sync-ask-us
                            {--force : Overwrite existing block HTML from templates}';

    protected $description = 'Restore ask_us inquiry form HTML and bind about-us / customer-services / search / reviews (+ product virtual keys)';

    /** @var array<string, string> */
    private array $templateMap = [
        'ask_us' => 'static_block_templates.ask_us',
        'ask_us_home' => 'static_block_templates.ask_us_home',
    ];

    /** @var array<string, string[]> */
    private array $realPageKeys = [
        'ask_us' => [
            'about-us',
            'customer-services',
            'search',
            'reviews',
        ],
        'ask_us_home' => [
            'home',
        ],
    ];

    /** @var array<string, string[]> */
    private array $virtualPageKeys = [
        'ask_us' => [
            'about-us',
            'customer-services',
            'search',
            'reviews',
            'products',
            'product-category',
            'product-tag',
            'product',
        ],
        'ask_us_home' => [
            'home',
        ],
    ];

    public function handle(): int
    {
        if (!Schema::hasTable('static_blocks') || !Schema::hasTable('static_block_translations')) {
            $this->error('static_blocks tables missing.');
            return 1;
        }

        $force = (bool)$this->option('force');
        $now = now();

        foreach ($this->templateMap as $sign => $view) {
            $block = StaticBlock::query()->where('sign', $sign)->first();
            if (!$block) {
                $this->warn("Static block [{$sign}] not found; skip.");
                continue;
            }

            if (!(int)$block->active) {
                $block->active = 1;
                $block->save();
                $this->info("Activated [{$sign}].");
            }

            try {
                $html = view($view, ['askUs' => []])->render();
            } catch (\Throwable $e) {
                $this->error("Render [{$sign}] failed: " . $e->getMessage());
                continue;
            }

            if (trim($html) === '') {
                $this->error("Render [{$sign}] returned empty HTML.");
                continue;
            }

            $locales = $this->resolveLocales($block->id);
            foreach ($locales as $locale) {
                $row = DB::table('static_block_translations')
                    ->where('static_block_id', $block->id)
                    ->where('locale', $locale)
                    ->first();

                $needsWrite = $force
                    || !$row
                    || trim((string)($row->content ?? '')) === ''
                    || stripos((string)($row->content ?? ''), '<form') === false
                    || !preg_match('/\bname\s*=\s*["\']name["\']/i', (string)($row->content ?? ''));

                if (!$needsWrite) {
                    $this->line("[{$sign}/{$locale}] content OK; keep.");
                    continue;
                }

                if ($row) {
                    DB::table('static_block_translations')
                        ->where('id', $row->id)
                        ->update(['content' => $html]);
                } else {
                    DB::table('static_block_translations')->insert([
                        'static_block_id' => $block->id,
                        'locale' => $locale,
                        'title' => $sign === 'ask_us_home' ? 'Tell Us What You Need' : 'To Power Your Brand With Us',
                        'content' => $html,
                    ]);
                }
                $this->info("[{$sign}/{$locale}] form HTML synced from template.");
            }

            $this->unbindWrongAssociations($block, $sign);
            $this->bindRealPages($block, $this->realPageKeys[$sign] ?? [], $now);
            $this->bindVirtualKeys($block, $this->virtualPageKeys[$sign] ?? [], $now);
            $block->touch();
        }

        $this->info('Done. Clear view cache if needed: php artisan view:clear');

        return 0;
    }

    /**
     * 首页只留 ask_us_home；其它页只留 ask_us。清理错误关联。
     */
    private function unbindWrongAssociations(StaticBlock $block, string $sign): void
    {
        $allowed = $this->virtualPageKeys[$sign] ?? [];
        $allowed = array_values(array_unique(array_map(static function ($k) {
            return trim((string)$k, '/');
        }, $allowed)));

        if (Schema::hasTable('static_block_page_keys') && $allowed !== []) {
            $removed = $block->pageKeys()
                ->whereNotIn('page_key', $allowed)
                ->delete();
            if ($removed > 0) {
                $this->warn("[{$sign}] removed {$removed} wrong page_key binding(s).");
            }
        }

        if (!Schema::hasTable('static_block_page') || $allowed === []) {
            return;
        }

        $allowedPageIds = Page::query()
            ->where(function ($q) use ($allowed) {
                $q->whereIn('url_key', $allowed);
                foreach ($allowed as $key) {
                    $q->orWhere('url_key', '/' . $key);
                }
            })
            ->pluck('id')
            ->all();

        $query = DB::table('static_block_page')->where('static_block_id', $block->id);
        if ($allowedPageIds !== []) {
            $removed = (clone $query)->whereNotIn('page_id', $allowedPageIds)->delete();
        } else {
            $removed = $query->delete();
        }
        if ($removed > 0) {
            $this->warn("[{$sign}] removed {$removed} wrong real-page binding(s).");
        }
    }

    /**
     * @param string[] $urlKeys
     */
    private function bindRealPages(StaticBlock $block, array $urlKeys, $now): void
    {
        if (!Schema::hasTable('static_block_page') || $urlKeys === []) {
            return;
        }

        foreach ($urlKeys as $urlKey) {
            $urlKey = trim((string)$urlKey, '/');
            $pageId = Page::query()
                ->where(function ($q) use ($urlKey) {
                    $q->where('url_key', $urlKey)->orWhere('url_key', '/' . $urlKey);
                })
                ->value('id');
            if (!$pageId) {
                $this->warn("Page [{$urlKey}] missing; skip real-page bind for [{$block->sign}].");
                continue;
            }

            $exists = DB::table('static_block_page')
                ->where('static_block_id', $block->id)
                ->where('page_id', $pageId)
                ->exists();
            if ($exists) {
                $this->line("[{$block->sign}] already bound to page [{$urlKey}].");
                continue;
            }

            DB::table('static_block_page')->insert([
                'static_block_id' => $block->id,
                'page_id' => $pageId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $this->info("[{$block->sign}] bound to page [{$urlKey}].");
        }
    }

    /**
     * @param string[] $keys
     */
    private function bindVirtualKeys(StaticBlock $block, array $keys, $now): void
    {
        if (!Schema::hasTable('static_block_page_keys') || $keys === []) {
            return;
        }

        foreach ($keys as $key) {
            $key = trim((string)$key, '/');
            if ($key === '') {
                continue;
            }
            $exists = $block->pageKeys()->where('page_key', $key)->exists();
            if ($exists) {
                continue;
            }
            $block->pageKeys()->create(['page_key' => $key]);
            $this->info("[{$block->sign}] bound page_key [{$key}].");
        }
    }

    /**
     * @return string[]
     */
    private function resolveLocales(int $blockId): array
    {
        $locales = DB::table('static_block_translations')
            ->where('static_block_id', $blockId)
            ->distinct()
            ->pluck('locale')
            ->filter(static fn ($locale) => is_string($locale) && $locale !== '')
            ->values()
            ->all();

        if ($locales === []) {
            $fallback = (string)(config('translatable.fallback_locale') ?: config('app.fallback_locale', 'en'));
            $locales = array_values(array_unique(array_filter([
                (string)config('app.locale', 'en'),
                $fallback,
            ])));
        }

        return $locales ?: ['en'];
    }
}
