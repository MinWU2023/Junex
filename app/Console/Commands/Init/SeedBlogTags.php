<?php

namespace App\Console\Commands\Init;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogTag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeedBlogTags extends Command
{
    protected $signature = 'seed:blog-tags {--min=3 : Min tags per blog} {--max=5 : Max tags per blog} {--force : Update translations if tag already exists}';
    protected $description = 'Seed blog tags with en translations and bind 3-5 tags per blog.';

    public function handle(): int
    {
        $min = (int)$this->option('min');
        $max = (int)$this->option('max');
        if ($min <= 0 || $max <= 0 || $min > $max) {
            $this->error('Invalid min/max values.');
            return 1;
        }

        $force = (bool)$this->option('force');

        $blogs = Blog::query()->get();
        if ($blogs->isEmpty()) {
            $this->error('No blogs found. Please seed blogs first.');
            return 1;
        }

        $tagNames = $this->tagNames();
        $tags = [];

        DB::beginTransaction();
        try {
            foreach ($tagNames as $index => $tagName) {
                $urlKey = $this->slug($tagName);
                $tag = BlogTag::query()->where('url_key', $urlKey)->first();

                if (!$tag) {
                    $tag = new BlogTag();
                    $tag->sort = $index + 1;
                    $tag->url_key = $urlKey;
                }

                $translation = $tag->translateOrNew('en');
                if ($force || !$translation->name) {
                    $translation->name = $tagName;
                }

                $tag->save();
                $tag->saveUrl();
                $tags[] = $tag;
            }

            $tagCount = count($tags);
            foreach ($blogs as $blog) {
                $needed = rand($min, $max);
                $selected = $this->pickTags($tags, $needed, $blog->id, $tagCount);
                $tagIds = array_map(function ($tag) {
                    return $tag->id;
                }, $selected);

                $blog->blogTags()->syncWithoutDetaching($tagIds);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Seed failed: '.$e->getMessage());
            return 1;
        }

        $this->info('Blog tags seeded and bound successfully.');
        $this->info('Use --force to refresh translations on existing tags.');

        return 0;
    }

    private function tagNames(): array
    {
        return [
            'Yoga Lifestyle',
            'Yoga Practice',
            'Breathwork',
            'Mindful Movement',
            'Activewear Tips',
            'Studio Routine',
            'Recovery',
            'Stretching',
            'Flexibility',
            'Wellness',
            'Sustainable Fabrics',
            'Product Guides',
            'Yoga Basics',
            'Athleisure',
            'Training Advice',
            'Comfort Fit',
            'Seasonal Layers',
            'Yoga Community',
            'Flow Series',
            'Calm Focus',
            'Daily Movement',
            'Soft Touch',
            'Breathable Fabric',
            'Workout Essentials',
            'New Arrivals',
            'Care Tips',
            'Sizing Guide',
            'Pilates',
            'Studio Stories',
            'Brand Updates',
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
