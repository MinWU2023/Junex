<?php

namespace App\Console\Commands\Init;

use App\Modules\Product\Models\ProductVideo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeedProductVideos extends Command
{
    protected $signature = 'seed:product-videos {--count=20 : Number of videos to create}';
    protected $description = 'Seed product videos with en translations and recommended flags.';

    public function handle(): int
    {
        $count = (int)$this->option('count');
        if ($count <= 0) {
            $this->error('Count must be greater than 0.');
            return 1;
        }

        $youtubeLinks = $this->youtubeLinks();
        $linkCount = count($youtubeLinks);
        if ($linkCount === 0) {
            $this->error('No YouTube links available.');
            return 1;
        }

        DB::beginTransaction();
        try {
            for ($i = 1; $i <= $count; $i++) {
                $video = new ProductVideo();
                $video->path = '/front/data/video.png';
                $video->video_url = $youtubeLinks[($i - 1) % $linkCount];
                $video->sort = $count - $i;
                $video->is_recommend = $i <= 10 ? 1 : 0;
                $video->active = 1;

                $translation = $video->translateOrNew('en');
                $translation->name = $this->titleWords();
                $translation->content = $this->contentWords(20, 30);

                $video->save();
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Seed failed: '.$e->getMessage());
            return 1;
        }

        $this->info('Product videos seeded successfully.');
        return 0;
    }

    private function youtubeLinks(): array
    {
        return [
            'https://youtube.com/watch?v=dwUEbh7M1vE',
            'https://youtube.com/watch?v=qHcprRi_hqE',
            'https://youtube.com/watch?v=6HnZnhwOuag',
            'https://youtube.com/watch?v=u65Xr-ANuIM',
            'https://youtube.com/watch?v=6PNBjKJ9hxQ',
            'https://youtube.com/watch?v=S5Rnwp8scxQ',
            'https://youtube.com/watch?v=KNOGTjQcih0',
            'https://youtube.com/watch?v=viBQYTcAPFc',
            'https://youtube.com/watch?v=TqRtdf6p5iM',
            'https://youtube.com/watch?v=zIt-lwpz_nY',
        ];
    }

    private function titleWords(): string
    {
        $words = [
            'Lightweight','Yoga','Apparel','Showcase','For','Daily','Movement',
            'Breathable','Fabrics','And','Studio','Performance','Highlights',
            'Comfort','Stretch','Fit','For','Modern','Activewear','Lifestyle',
            'Crafted','Details','That','Support','Everyday','Training',
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
            'soft','breathable','fabric','supports','movement','and','comfort',
            'designed','for','studio','and','outdoor','training','sessions',
            'clean','lines','durable','stitching','lightweight','feel',
            'stretch','fit','for','daily','practice','and','recovery',
        ];

        $target = rand($min, $max);
        $words = [];
        for ($i = 0; $i < $target; $i++) {
            $words[] = $base[array_rand($base)];
        }

        return ucfirst(implode(' ', $words)).'.';
    }
}
