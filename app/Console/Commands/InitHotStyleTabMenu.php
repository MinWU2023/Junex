<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use App\Modules\Setting\Models\HotStyleTab;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitHotStyleTabMenu extends Command
{
    protected $signature = 'init:hot-style-tab {--fresh : Truncate and re-seed tabs}';

    protected $description = 'Initialize Hot Style Tabs menu, permissions and seed homepage tabs';

    public function handle()
    {
        $this->info('Initializing Hot Style Tab Menu and Permissions...');

        $createdAt = date('Y-m-d H:i:s');

        $parentMenu = Menu::query()->where('name', '内容相关')->first();
        if (!$parentMenu) {
            $this->error("Parent menu '内容相关' not found.");
            return 1;
        }

        $route = 'admin.hotStyleTab.index';
        $menuName = '热门款式Tab';

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

        $groupName = '热门款式Tab';
        $group = PermissionGroup::query()->where('name', $groupName)->first();
        if (!$group) {
            $group = PermissionGroup::query()->create(['name' => $groupName]);
            $this->info("Permission Group '{$groupName}' created.");
        }

        $permissions = [
            'admin.hotStyleTab.index' => '热门款式Tab列表',
            'admin.hotStyleTab.create' => '热门款式Tab新增页面',
            'admin.hotStyleTab.store' => '热门款式Tab新增',
            'admin.hotStyleTab.edit' => '热门款式Tab编辑页面',
            'admin.hotStyleTab.update' => '热门款式Tab编辑',
            'admin.hotStyleTab.destroy' => '热门款式Tab删除',
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

        $this->seedTabs();

        $this->info('Initialization complete!');
        return 0;
    }

    protected function seedTabs(): void
    {
        $count = HotStyleTab::query()->count();
        if ($count > 0 && !$this->option('fresh')) {
            $this->warn("Hot style tabs already exist ({$count}), skip seeding. Use --fresh to re-seed.");
            return;
        }

        if ($this->option('fresh') && $count > 0) {
            HotStyleTab::query()->each(function (HotStyleTab $item) {
                $item->delete();
            });
            $this->info('Existing hot style tabs cleared.');
        }

        $tabs = [
            [
                'tab_key' => 'new',
                'product_source' => 'new',
                'sort' => 30,
                'active' => 1,
                'en' => ['label' => 'New Arrivals'],
            ],
            [
                'tab_key' => 'best',
                'product_source' => 'hot',
                'sort' => 20,
                'active' => 1,
                'en' => ['label' => 'Best Sellers'],
            ],
            [
                'tab_key' => 'bundles',
                'product_source' => 'recommend',
                'sort' => 10,
                'active' => 1,
                'en' => ['label' => 'Bundles & Save'],
            ],
        ];

        foreach ($tabs as $tab) {
            $en = $tab['en'];
            unset($tab['en']);
            HotStyleTab::create(array_merge($tab, ['en' => $en]));
        }

        $this->info('Seeded ' . count($tabs) . ' hot style tabs.');
    }
}
