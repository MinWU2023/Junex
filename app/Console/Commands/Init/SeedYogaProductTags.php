<?php

namespace App\Console\Commands\Init;

use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductTag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeedYogaProductTags extends Command
{
    protected $signature = 'seed:yoga-product-tags {--min=3 : Min tags per product} {--max=5 : Max tags per product} {--force : Update translations if tag already exists}';
    protected $description = 'Seed product tags with en translations and bind 3-5 tags per product.';

    public function handle(): int
    {
        $min = (int)$this->option('min');
        $max = (int)$this->option('max');
        if ($min <= 0 || $max <= 0 || $min > $max) {
            $this->error('Invalid min/max values.');
            return 1;
        }

        $force = (bool)$this->option('force');

        $products = Product::query()->get();
        if ($products->isEmpty()) {
            $this->error('No products found. Please seed products first.');
            return 1;
        }

        $tagNames = $this->tagNames();
        $tags = [];

        DB::beginTransaction();
        try {
            foreach ($tagNames as $index => $tagName) {
                $urlKey = $this->slug($tagName);
                $tag = ProductTag::query()->where('url_key', $urlKey)->first();

                if (!$tag) {
                    $tag = new ProductTag();
                    $tag->sort = $index + 1;
                    $tag->url_key = $urlKey;
                    $tag->is_hot = ($index % 4 === 0) ? 1 : 0;
                    $tag->is_translate = 0;
                }

                $translation = $tag->translateOrNew('en');
                if ($force || !$translation->name) {
                    $translation->name = $tagName;
                    $translation->title = $tagName.' | Yoga Apparel';
                    $translation->keywords = $tagName.', yoga apparel, activewear';
                    $translation->description = 'Shop '.$tagName.' for yoga and fitness with premium fabrics and comfort.';
                }

                $tag->save();
                $tag->saveUrl();
                $tags[] = $tag;
            }

            $tagCount = count($tags);
            foreach ($products as $product) {
                $needed = rand($min, $max);
                $selected = $this->pickTags($tags, $needed, $product->id, $tagCount);
                $tagIds = array_map(function ($tag) {
                    return $tag->id;
                }, $selected);

                $product->productTags()->syncWithoutDetaching($tagIds);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Seed failed: '.$e->getMessage());
            return 1;
        }

        $this->info('Product tags seeded and bound successfully.');
        $this->info('Use --force to refresh translations on existing tags.');

        return 0;
    }

    private function tagNames(): array
    {
        return [
            'Yoga Apparel',
            'Yoga Set',
            'Sports Bra',
            'Seamless Leggings',
            'High Waist',
            'Moisture Wicking',
            'Breathable Fabric',
            'Stretch Fit',
            'Compression Wear',
            'Quick Dry',
            'Eco Friendly',
            'Soft Touch',
            'Four-Way Stretch',
            'Training Outfit',
            'Yoga Tops',
            'Yoga Bottoms',
            'Yoga Shorts',
            'Yoga Hoodie',
            'Activewear',
            'Fitness Wear',
            'Gym Outfit',
            'Pilates Wear',
            'Custom Logo',
            'OEM Service',
            'ODM Service',
            'Wholesale',
            'New Arrival',
            'Hot Sale',
            'Lightweight',
            'Athleisure',
        ];
    }

    private function pickTags(array $tags, int $needed, int $seed, int $tagCount): array
    {
        $picked = [];
        if ($tagCount === 0) {
            return $picked;
        }

        $offset = $seed % $tagCount;
        $index = $offset;

        while (count($picked) < $needed) {
            $picked[$tags[$index]->id] = $tags[$index];
            $index = ($index + 1) % $tagCount;
        }

        return array_values($picked);
    }

    private function slug(string $value): string
    {
        $slug = Str::slug($value, '-');
        return $slug ?: Str::random(8);
    }
}
