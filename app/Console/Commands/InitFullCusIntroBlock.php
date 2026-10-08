<?php

namespace App\Console\Commands;

use App\Modules\Page\Models\Page;
use App\Modules\Page\Models\StaticBlock;
use Illuminate\Console\Command;

class InitFullCusIntroBlock extends Command
{
    protected $signature = 'init:full-cus-intro-block {--force : Overwrite existing intro block content}';

    protected $description = 'Copy full_cus into a title/subtitle-only block for customer-services, and bind the original to About Us';

    public function handle(): int
    {
        $source = StaticBlock::query()->with('translations')->where('sign', 'full_cus')->first();
        if (!$source) {
            $this->error('Static block full_cus not found.');
            return 1;
        }

        $aboutPage = $this->findPageByUrlKey('about-us');
        $customerPage = $this->findPageByUrlKey('customer-services');
        if (!$aboutPage || !$customerPage) {
            $this->error('Required CMS pages not found (about-us / customer-services).');
            return 1;
        }

        $intro = StaticBlock::query()->where('sign', 'full_cus_intro')->first();
        $force = (bool)$this->option('force');

        if ($intro && !$force) {
            $this->warn('full_cus_intro already exists. Use --force to overwrite content.');
        } else {
            $payload = [
                'sign' => 'full_cus_intro',
                'sort' => (int)$source->sort,
                'active' => 1,
                'remark' => 'Customer Services：仅主标题和副标题',
            ];

            foreach ($source->translations as $translation) {
                $payload[$translation->locale] = [
                    'title' => trim((string)$translation->title) !== ''
                        ? (string)$translation->title . '（简介）'
                        : '全定制服务（简介）',
                    'content' => $this->stripFeatureGrid((string)$translation->content),
                ];
            }

            if (!$intro) {
                $intro = StaticBlock::create($payload);
                $this->info('Created static block full_cus_intro.');
            } else {
                $intro->update($payload);
                $this->info('Updated static block full_cus_intro.');
            }
        }

        $source->pages()->sync([$aboutPage->id]);
        $intro->pages()->sync([$customerPage->id]);

        $this->info('Bound full_cus -> about-us, full_cus_intro -> customer-services.');

        return 0;
    }

    private function findPageByUrlKey(string $urlKey): ?Page
    {
        return Page::query()
            ->where(function ($q) use ($urlKey) {
                $q->where('url_key', $urlKey)->orWhere('url_key', '/' . $urlKey);
            })
            ->first();
    }

    private function stripFeatureGrid(string $html): string
    {
        $marker = '<div class="mt-10 grid';
        $pos = strpos($html, $marker);
        if ($pos === false) {
            return $html;
        }

        $prefix = rtrim(substr($html, 0, $pos));
        if (!preg_match('/<\/section>\s*$/i', $prefix)) {
            $prefix .= "\n    </div>\n    </div>\n</section>";
        }

        return $prefix . "\n";
    }
}
