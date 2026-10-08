<?php

namespace App\Console\Commands;

use App\Modules\Navigation\Models\Navigation;
use App\Modules\Navigation\Models\NavigationTranslation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitFooterNavigation extends Command
{
    protected $signature = 'init:footer-nav';
    protected $description = 'Initialize footer navigation data based on static HTML structure';

    public function handle()
    {
        $locales = ['en', 'zh-CN']; // 默认初始化英中两语
        
        $footerData = [
            [
                'name' => 'Our Services',
                'sort' => 100,
                'children' => [
                    ['name' => 'FAQs', 'url' => '/faqs.html'],
                    ['name' => 'Support', 'url' => '/customerservices.html'],
                    ['name' => 'Catalog', 'url' => '/productcategory.html'],
                    ['name' => 'Our Story', 'url' => '/aboutus.htmlq'],
                    ['name' => 'Blogs', 'url' => '/blogs.html'],
                ]
            ],
            [
                'name' => 'Product Categories',
                'sort' => 90,
                'children' => [
                    ['name' => 'Activewear Manufacture', 'url' => '#'],
                    ['name' => 'Gym Clothing Wholesale', 'url' => '#'],
                    ['name' => 'Fitness Wear Wholesale', 'url' => '#'],
                    ['name' => 'Gym Clothing Supplier', 'url' => '#'],
                    ['name' => 'Gym Clothes Manufacturer', 'url' => '#'],
                ]
            ],
            [
                'name' => 'Follow Us',
                'sort' => 80,
                'children' => [
                    ['name' => 'Home', 'url' => '/'],
                    ['name' => 'Products', 'url' => '/products.html'],
                    ['name' => 'Contact Us', 'url' => '/contactus.html'],
                    ['name' => 'Privacy Policy', 'url' => '/singlepage.html'],
                    ['name' => 'New Style Display', 'url' => '#'],
                ]
            ],
            [
                'name' => 'Hot Tags',
                'sort' => 70,
                'children' => [
                    ['name' => 'Activewear Manufacture', 'url' => '#'],
                    ['name' => 'Gym Clothing Wholesale', 'url' => '#'],
                    ['name' => 'Fitness Wear Wholesale', 'url' => '#'],
                    ['name' => 'Gym Clothing Supplier', 'url' => '#'],
                    ['name' => 'Gym Clothes Manufacturer', 'url' => '#'],
                ]
            ],
        ];

        DB::beginTransaction();
        try {
            foreach ($footerData as $group) {
                // 创建一级菜单
                $nav = Navigation::create([
                    'parent_id' => 0,
                    'url' => '',
                    'is_show' => 1,
                    'sort' => $group['sort'],
                    'area' => Navigation::AREA_FOOT,
                    'link_type' => Navigation::LINK_NORMAL,
                ]);

                foreach ($locales as $locale) {
                    NavigationTranslation::create([
                        'navigation_id' => $nav->id,
                        'locale' => $locale,
                        'name' => $group['name'],
                    ]);
                }

                // 创建二级菜单
                foreach ($group['children'] as $index => $child) {
                    $childNav = Navigation::create([
                        'parent_id' => $nav->id,
                        'url' => $child['url'],
                        'is_show' => 1,
                        'sort' => 100 - $index,
                        'area' => Navigation::AREA_FOOT,
                        'link_type' => Navigation::LINK_NORMAL,
                    ]);

                    foreach ($locales as $locale) {
                        NavigationTranslation::create([
                            'navigation_id' => $childNav->id,
                            'locale' => $locale,
                            'name' => $child['name'],
                        ]);
                    }
                }
            }
            DB::commit();
            $this->info('Footer navigation initialized successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error initializing footer navigation: ' . $e->getMessage());
        }
    }
}
