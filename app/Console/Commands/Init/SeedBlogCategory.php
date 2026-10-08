<?php

namespace App\Console\Commands\Init;

use App\Modules\Blog\Models\BlogCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeedBlogCategory extends Command
{
    protected $signature = 'seed:blog-category {--force : Update translation if category already exists}';
    protected $description = 'Seed a single top-level Blog category with en translation and url.';

    public function handle(): int
    {
        $force = (bool)$this->option('force');
        $name = 'Blog';
        $urlKey = $this->slug($name);

        DB::beginTransaction();
        try {
            $category = BlogCategory::query()->where('url_key', $urlKey)->first();
            if (!$category) {
                $category = new BlogCategory();
                $category->parent_id = 0;
                $category->sort = 1;
                $category->path = null;
                $category->url_key = $urlKey;
            }

            $translation = $category->translateOrNew('en');
            if ($force || !$translation->name) {
                $translation->name = $name;
                $translation->content = 'Latest news, updates, and stories from our yoga apparel brand.';
                $translation->title = 'Blog | Yoga Apparel';
                $translation->keywords = 'blog, yoga, apparel, activewear, news';
                $translation->description = 'Discover product stories, tips, and updates from our yoga apparel team.';
            }

            $category->save();
            $category->saveUrl();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Seed failed: '.$e->getMessage());
            return 1;
        }

        $this->info('Blog category seeded successfully.');
        $this->info('Use --force to refresh translation on existing category.');

        return 0;
    }

    private function slug(string $value): string
    {
        $slug = Str::slug($value, '-');
        return $slug ?: Str::random(8);
    }
}
