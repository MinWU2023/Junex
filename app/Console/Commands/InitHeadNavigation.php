<?php

namespace App\Console\Commands;

use App\Modules\Navigation\Models\Navigation;
use App\Modules\Product\Models\ProductCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitHeadNavigation extends Command
{
    protected $signature = 'init:head-nav {--fresh : Delete existing head navigations first}';

    protected $description = 'Seed default header navigations (with Product as category link)';

    public function handle()
    {
        if ($this->option('fresh')) {
            $ids = Navigation::query()->area(Navigation::AREA_HEAD)->pluck('id');
            if ($ids->isNotEmpty()) {
                DB::table('navigation_product_category')->whereIn('navigation_id', $ids)->delete();
                Navigation::query()->area(Navigation::AREA_HEAD)->delete();
            }
            $this->info('Existing head navigations cleared.');
        }

        $exists = Navigation::query()->area(Navigation::AREA_HEAD)->where('parent_id', 0)->exists();
        if ($exists && !$this->option('fresh')) {
            $this->warn('Head navigations already exist. Use --fresh to recreate.');
            return 0;
        }

        $items = [
            ['name' => 'Home', 'url' => '/', 'sort' => 70, 'link_type' => 'normal'],
            ['name' => 'About Us', 'url' => '/about-us', 'sort' => 60, 'link_type' => 'normal'],
            ['name' => 'Product', 'url' => '/products', 'sort' => 50, 'link_type' => 'category'],
            ['name' => 'Custom Service', 'url' => '/customer-services', 'sort' => 40, 'link_type' => 'normal'],
            ['name' => 'Catalog', 'url' => '/newstyle', 'sort' => 30, 'link_type' => 'normal', 'is_new' => 1],
            ['name' => 'Blogs', 'url' => '/blogs', 'sort' => 20, 'link_type' => 'normal'],
            ['name' => 'Contact Us', 'url' => '/contact-us', 'sort' => 10, 'link_type' => 'normal'],
        ];

        $categoryIds = ProductCategory::query()
            ->where('parent_id', 0)
            ->orderByDesc('sort')
            ->pluck('id')
            ->all();

        // Also include second-level under those roots for menu depth
        $childIds = ProductCategory::query()
            ->whereIn('parent_id', $categoryIds ?: [0])
            ->pluck('id')
            ->all();
        $allCatIds = array_values(array_unique(array_merge($categoryIds, $childIds)));

        foreach ($items as $row) {
            $nav = Navigation::create([
                'parent_id' => 0,
                'url' => $row['url'],
                'sort' => $row['sort'],
                'is_show' => 1,
                'is_new' => (int)($row['is_new'] ?? 0),
                'is_nofollow' => 0,
                'area' => Navigation::AREA_HEAD,
                'link_type' => $row['link_type'],
                'en' => ['name' => $row['name']],
            ]);

            if ($row['link_type'] === Navigation::LINK_CATEGORY && !empty($allCatIds)) {
                $sync = [];
                $sort = count($allCatIds) * 10;
                foreach ($allCatIds as $cid) {
                    $sync[$cid] = ['sort' => $sort];
                    $sort -= 10;
                }
                $nav->categories()->sync($sync);
            }

            $this->line("Created: {$row['name']}");
        }

        // Ensure existing footer items marked as 底部
        Navigation::query()
            ->where(function ($q) {
                $q->whereNull('area')->orWhere('area', '')->orWhereNotIn('area', [Navigation::AREA_HEAD, Navigation::AREA_FOOT]);
            })
            ->update(['area' => Navigation::AREA_FOOT]);

        $this->info('Head navigation seeded.');
        return 0;
    }
}
