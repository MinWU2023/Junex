<?php

namespace App\Console\Commands\Init;

use App\Modules\Product\Models\ProductCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeedYogaProductCategories extends Command
{
    protected $signature = 'seed:yoga-categories {--force : Update translations if category already exists}';
    protected $description = 'Seed 3 top-level and 9 second-level yoga apparel product categories with en translations and urls.';

    public function handle(): int
    {
        $force = (bool)$this->option('force');

        $parents = [
            [
                'name' => 'Yoga Tops',
                'children' => [
                    'Sports Bras',
                    'Tank Tops',
                    'Long Sleeve Tops',
                ],
            ],
            [
                'name' => 'Yoga Bottoms',
                'children' => [
                    'Leggings',
                    'Yoga Shorts',
                    'Joggers',
                ],
            ],
            [
                'name' => 'Yoga Outerwear',
                'children' => [
                    'Hoodies',
                    'Lightweight Jackets',
                    'Warm-Up Sweaters',
                ],
            ],
        ];

        $created = 0;
        $updated = 0;

        DB::beginTransaction();
        try {
            foreach ($parents as $index => $parent) {
                $parentSlug = $this->slug($parent['name']);
                $parentCategory = $this->upsertCategory(
                    $parent['name'],
                    $parentSlug,
                    0,
                    ($index + 1) * 10,
                    $force
                );

                $parentCategory->saveUrl();

                $children = $parent['children'];
                foreach ($children as $childIndex => $childName) {
                    $childSlug = $this->slug($parentSlug.'-'.$childName);
                    $childCategory = $this->upsertCategory(
                        $childName,
                        $childSlug,
                        $parentCategory->id,
                        ($index + 1) * 10 + ($childIndex + 1),
                        $force
                    );

                    $childCategory->saveUrl();
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Seed failed: '.$e->getMessage());
            return 1;
        }

        $this->info('Yoga categories seeded successfully.');
        $this->info('If categories already existed, use --force to refresh translations.');

        return 0;
    }

    private function upsertCategory(
        string $name,
        string $urlKey,
        int $parentId,
        int $sort,
        bool $force
    ): ProductCategory {
        $category = ProductCategory::query()->where('url_key', $urlKey)->first();

        if (!$category) {
            $category = new ProductCategory();
            $category->parent_id = $parentId;
            $category->sort = $sort;
            $category->is_show = 1;
            $category->is_menu = 1;
            $category->path = null;
            $category->url_key = $urlKey;
            $category->logo = null;
            $category->admin_user_id = 0;
            $category->is_translate = 0;
        } else {
            $category->parent_id = $parentId;
            $category->sort = $sort;
            if (!$category->is_show) {
                $category->is_show = 1;
            }
            if (!$category->is_menu) {
                $category->is_menu = 1;
            }
            if (!$category->url_key) {
                $category->url_key = $urlKey;
            }
        }

        $translation = $category->translateOrNew('en');
        if ($force || !$translation->name) {
            $translation->name = $name;
            $translation->content = $this->contentFor($name);
            $translation->title = $name.' | Yoga Apparel';
            $translation->keywords = $this->keywordsFor($name);
            $translation->description = $this->descriptionFor($name);
        }

        $category->save();

        return $category;
    }

    private function slug(string $value): string
    {
        $slug = Str::slug($value, '-');
        return $slug ?: Str::random(8);
    }

    private function contentFor(string $name): string
    {
        return 'Discover our '.$name.' designed for comfort, stretch, and everyday studio performance.';
    }

    private function keywordsFor(string $name): string
    {
        $base = strtolower($name);
        return $base.', yoga apparel, yoga clothing, breathable, stretch, workout wear';
    }

    private function descriptionFor(string $name): string
    {
        return $name.' for yoga practice and everyday wear, featuring soft fabrics, flexible fit, and clean silhouettes.';
    }
}
