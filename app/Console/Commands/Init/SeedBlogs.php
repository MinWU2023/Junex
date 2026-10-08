<?php

namespace App\Console\Commands\Init;

use App\Modules\Admin\Models\User;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeedBlogs extends Command
{
    protected $signature = 'seed:blogs {--count=100 : Number of blogs to create} {--force : Update translations if blog already exists}';
    protected $description = 'Seed blogs with en translations, urls, and cover image.';

    public function handle(): int
    {
        $count = (int)$this->option('count');
        if ($count <= 0) {
            $this->error('Count must be greater than 0.');
            return 1;
        }

        $force = (bool)$this->option('force');

        $category = BlogCategory::query()->where('parent_id', 0)->first();
        if (!$category) {
            $this->error('No top-level Blog category found. Please seed blog category first.');
            return 1;
        }

        $adminId = (int)(User::query()->value('id') ?? 1);

        DB::beginTransaction();
        try {
            for ($i = 1; $i <= $count; $i++) {
                $title = $this->titleWords();
                $urlKey = $this->slug($title.' '.$i);

                $blog = Blog::query()->where('url_key', $urlKey)->first();
                if (!$blog) {
                    $blog = new Blog();
                    $blog->blog_category_id = $category->id;
                    $blog->sort = $count - $i;
                    $blog->path = '/front/data/blog.png';
                    $blog->active = 1;
                    $blog->url_key = $urlKey;
                    $blog->customer_at = now();
                    $blog->is_temp = 0;
                    $blog->admin_user_id = $adminId;
                    $blog->is_draft = 0;
                }

                $translation = $blog->translateOrNew('en');
                if ($force || !$translation->name) {
                    $translation->name = $title;
                    $translation->content = $this->contentWords(400, 800);
                    $translation->title = $title;
                    $translation->keywords = $this->keywords($title);
                    $translation->description = $this->description($title);
                }

                $blog->save();
                $blog->saveUrl();
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Seed failed: '.$e->getMessage());
            return 1;
        }

        $this->info('Blogs seeded successfully.');
        $this->info('Use --force to refresh translations on existing blogs.');

        return 0;
    }

    private function titleWords(): string
    {
        $words = [
            'Elevate','Your','Yoga','Practice','With','Comfort','Stretch','Breathable','Fabrics',
            'Designed','For','Everyday','Movement','And','Studio','Performance','Activewear','Essentials',
            'Lightweight','Layers','For','All','Seasons','Supportive','Fit','And','Clean','Silhouette',
            'Sustainable','Materials','For','Modern','Athleisure','Lifestyle',
        ];

        $count = rand(8, 12);
        $picked = [];
        while (count($picked) < $count) {
            $picked[] = $words[array_rand($words)];
        }

        return implode(' ', $picked);
    }

    private function contentWords(int $min, int $max): string
    {
        $base = [
            'yoga','apparel','design','comfort','stretch','breathable','fabric','fit','movement','studio',
            'performance','activewear','support','soft','lightweight','durable','seamless','training','daily',
            'routine','balance','focus','quality','details','craft','style','flexibility','wellness','practice',
            'lifestyle','material','sustainable','premium','experience','designs','collection','season','color',
            'range','ease','care','innovation','supportive','layers','versatile','modern','touch','feel',
        ];

        $target = rand($min, $max);
        $words = [];
        for ($i = 0; $i < $target; $i++) {
            $words[] = $base[array_rand($base)];
        }

        $text = implode(' ', $words);
        return ucfirst($text).'.';
    }

    private function keywords(string $title): string
    {
        $parts = array_slice(explode(' ', strtolower($title)), 0, 6);
        $parts[] = 'yoga';
        $parts[] = 'activewear';
        $parts[] = 'blog';
        return implode(', ', array_unique($parts));
    }

    private function description(string $title): string
    {
        return 'Read about '.$title.' and discover tips on yoga apparel, comfort, and daily movement.';
    }

    private function slug(string $value): string
    {
        $slug = Str::slug($value, '-');
        return $slug ?: Str::random(8);
    }
}
