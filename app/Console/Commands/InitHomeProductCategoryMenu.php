<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use App\Modules\Setting\Models\HomeProductCategory;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitHomeProductCategoryMenu extends Command
{
    protected $signature = 'init:home-product-category {--fresh : Truncate and re-seed category cards}';

    protected $description = 'Initialize Home Product Category menu, permissions and seed homepage cards';

    public function handle()
    {
        $this->info('Initializing Home Product Category Menu and Permissions...');

        $createdAt = date('Y-m-d H:i:s');

        $parentMenu = Menu::query()->where('name', '内容相关')->first();
        if (!$parentMenu) {
            $this->error("Parent menu '内容相关' not found.");
            return 1;
        }

        $route = 'admin.homeProductCategory.index';
        $menuName = '首页产品分类';

        $menu = Menu::query()->where('route', $route)->first();
        if (!$menu) {
            Menu::query()->create([
                'parent_id' => $parentMenu->id,
                'name' => $menuName,
                'route' => $route,
                'sort' => 0,
                'icon' => '',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
            $this->info("Menu '{$menuName}' created.");
        } else {
            $this->warn("Menu '{$menuName}' already exists.");
        }

        $groupName = '首页产品分类';
        $group = PermissionGroup::query()->where('name', $groupName)->first();
        if (!$group) {
            $group = PermissionGroup::query()->create(['name' => $groupName]);
            $this->info("Permission Group '{$groupName}' created.");
        }

        $permissions = [
            'admin.homeProductCategory.index' => '首页产品分类列表',
            'admin.homeProductCategory.create' => '首页产品分类新增页面',
            'admin.homeProductCategory.store' => '首页产品分类新增',
            'admin.homeProductCategory.edit' => '首页产品分类编辑页面',
            'admin.homeProductCategory.update' => '首页产品分类编辑',
            'admin.homeProductCategory.destroy' => '首页产品分类删除',
        ];

        foreach ($permissions as $name => $displayName) {
            $permission = Permission::query()->where('name', $name)->first();
            if (!$permission) {
                Permission::query()->create([
                    'name' => $name,
                    'display_name' => $displayName,
                    'guard_name' => 'web',
                    'pg_id' => $group->id,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
                $this->info("Permission '{$name}' created.");
            } else {
                $this->warn("Permission '{$name}' already exists.");
            }
        }

        $role = Role::where('name', '超级管理员')->first();
        if ($role) {
            $role->givePermissionTo(array_keys($permissions));
            $this->info("Permissions assigned to '超级管理员' role.");
        }

        $this->seedCards();

        $this->info('Initialization complete!');
        return 0;
    }

    protected function seedCards(): void
    {
        $count = HomeProductCategory::query()->count();
        if ($count > 0 && !$this->option('fresh')) {
            $this->warn("Home product category cards already exist ({$count}), skip seeding. Use --fresh to re-seed.");
            return;
        }

        if ($this->option('fresh') && $count > 0) {
            HomeProductCategory::query()->each(function (HomeProductCategory $item) {
                $item->delete();
            });
            $this->info('Existing home product category cards cleared.');
        }

        $description = "Custom High Waist Yoga Leggings<br />Set Stretchy Breathable Active-";
        $buttonText = 'Learn More';

        $cards = [
            [
                'path' => '/front/imgs/jpcl001.png',
                'button_url' => '#',
                'sort' => 40,
                'active' => 1,
                'en' => [
                    'title' => '<span class="text-brand-red">Recent</span> New<br />Products',
                    'description' => $description,
                    'button_text' => $buttonText,
                    'alt' => 'Recent new products',
                ],
            ],
            [
                'path' => '/front/imgs/jpcl002.png',
                'button_url' => '#',
                'sort' => 30,
                'active' => 1,
                'en' => [
                    'title' => '<span class="text-brand-red">B</span>estseller<br />Recommendation',
                    'description' => $description,
                    'button_text' => $buttonText,
                    'alt' => 'Bestseller recommendation',
                ],
            ],
            [
                'path' => '/front/imgs/jpcl003.png',
                'button_url' => '#',
                'sort' => 20,
                'active' => 1,
                'en' => [
                    'title' => '<span class="text-brand-red">S</span>ewn Series',
                    'description' => $description,
                    'button_text' => $buttonText,
                    'alt' => 'Sewn series',
                ],
            ],
            [
                'path' => '/front/imgs/jpcl004.png',
                'button_url' => '#',
                'sort' => 10,
                'active' => 1,
                'en' => [
                    'title' => '<span class="text-brand-red">S</span>eamless<br />Shorts Series',
                    'description' => $description,
                    'button_text' => $buttonText,
                    'alt' => 'Seamless shorts series',
                ],
            ],
        ];

        foreach ($cards as $card) {
            $en = $card['en'];
            unset($card['en']);
            HomeProductCategory::create(array_merge($card, [
                'en' => $en,
            ]));
        }

        $this->info('Seeded ' . count($cards) . ' home product category cards.');
    }
}
