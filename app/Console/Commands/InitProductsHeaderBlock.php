<?php

namespace App\Console\Commands;

use App\Modules\Page\Models\StaticBlock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class InitProductsHeaderBlock extends Command
{
    protected $signature = 'init:products-header-block {--force : Overwrite existing content}';

    protected $description = 'Create /products page title+description static block and bind to products page key';

    public function handle(): int
    {
        if (!Schema::hasTable('static_blocks')) {
            $this->error('static_blocks table missing.');
            return 1;
        }

        $force = (bool)$this->option('force');
        $sign = 'products_header';

        $titleHtml = 'JUNEX SPORTSWEAR | PROVIDE EXCELLENT PRODUCTS AND SERVICE,'
            . '<br class="hidden sm6:block" />'
            . 'EMPOWERING ACTIVEWEAR BRAND TO GROW';

        $subtitle = "JUNEXSPORT, As A Mature Sportswear / Yoga Wear/Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focus On Offering Eco-friendly & Recycled & Sustainable Fabric Activewear. The Products Include Sports Bras, Leggings, Shorts, Tennis Wear, Kids' Sportswear, Yoga Suits, Sustainable & Recycled Wear, T-Shirts & Crop Tops, And Men's Gym Wear.";

        $html = view('static_block_templates.products_header', [
            'title_html' => $titleHtml,
            'subtitle' => $subtitle,
        ])->render();

        $locales = $this->resolveLocales();
        $block = StaticBlock::query()->where('sign', $sign)->first();

        if ($block && !$force) {
            $this->warn("Static block [{$sign}] already exists. Use --force to overwrite content.");
        } else {
            $payload = [
                'sign' => $sign,
                'sort' => 55,
                'active' => 1,
                'remark' => 'Products 列表页：主标题 + 描述',
            ];

            foreach ($locales as $locale) {
                $payload[$locale] = [
                    'title' => 'Products Header',
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
            $exists = $block->pageKeys()->where('page_key', 'products')->exists();
            if (!$exists) {
                $block->pageKeys()->create(['page_key' => 'products']);
                $this->info('Bound products_header -> page_key: products.');
            } else {
                $this->line('page_key [products] already bound.');
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
