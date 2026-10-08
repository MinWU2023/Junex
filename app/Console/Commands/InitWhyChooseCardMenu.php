<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use App\Modules\Setting\Models\WhyChooseCard;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitWhyChooseCardMenu extends Command
{
    protected $signature = 'init:why-choose-card {--fresh : Truncate and re-seed cards}';

    protected $description = 'Initialize Why Choose cards menu, permissions and seed homepage cards';

    public function handle()
    {
        $this->info('Initializing Why Choose Card Menu and Permissions...');

        $createdAt = date('Y-m-d H:i:s');

        $parentMenu = Menu::query()->where('name', '内容相关')->first();
        if (!$parentMenu) {
            $this->error("Parent menu '内容相关' not found.");
            return 1;
        }

        $route = 'admin.whyChooseCard.index';
        $menuName = '为何选择我们';

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

        $groupName = '为何选择我们';
        $group = PermissionGroup::query()->where('name', $groupName)->first();
        if (!$group) {
            $group = PermissionGroup::query()->create(['name' => $groupName]);
            $this->info("Permission Group '{$groupName}' created.");
        }

        $permissions = [
            'admin.whyChooseCard.index' => '为何选择我们列表',
            'admin.whyChooseCard.create' => '为何选择我们新增页面',
            'admin.whyChooseCard.store' => '为何选择我们新增',
            'admin.whyChooseCard.edit' => '为何选择我们编辑页面',
            'admin.whyChooseCard.update' => '为何选择我们编辑',
            'admin.whyChooseCard.destroy' => '为何选择我们删除',
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
        $count = WhyChooseCard::query()->count();
        if ($count > 0 && !$this->option('fresh')) {
            $this->warn("Why choose cards already exist ({$count}), skip seeding. Use --fresh to re-seed.");
            return;
        }

        if ($this->option('fresh') && $count > 0) {
            WhyChooseCard::query()->each(function (WhyChooseCard $item) {
                $item->delete();
            });
            $this->info('Existing why choose cards cleared.');
        }

        $cards = [
            [
                'image_mobile' => '/front/imgs/index_wc_l02.png',
                'background_desktop' => '/front/imgs/index_wc_l02.jpg',
                'url' => '#',
                'sort' => 40,
                'active' => 1,
                'en' => [
                    'label' => 'Annual Output',
                    'value' => '45',
                    'value_suffix' => 'Millions Items',
                    'description' => 'High Production Volume, Ensuring Both Quantity And Quality.',
                ],
            ],
            [
                'image_mobile' => '/front/imgs/index_wc_h02.png',
                'background_desktop' => '/front/imgs/index_wc_h02.png',
                'url' => '#',
                'sort' => 30,
                'active' => 1,
                'en' => [
                    'label' => 'Spot Reserves',
                    'value' => '800',
                    'value_suffix' => 'Millions Items',
                    'description' => 'Rapid Response Supply, Protecting Your Business Every Step of the Way.',
                ],
            ],
            [
                'image_mobile' => '/front/imgs/index_wc_h01.png',
                'background_desktop' => '/front/imgs/index_wc_h01.png',
                'url' => '#',
                'sort' => 20,
                'active' => 1,
                'en' => [
                    'label' => 'Number Of Customers',
                    'value' => '100+',
                    'value_suffix' => 'Millions Of Customers',
                    'description' => 'Professionalism Earns Greater Trust.',
                ],
            ],
            [
                'image_mobile' => '/front/imgs/index_wc_l02.png',
                'background_desktop' => '/front/imgs/index_wc_l01.png',
                'url' => '#',
                'sort' => 10,
                'active' => 1,
                'en' => [
                    'label' => 'Production Line',
                    'value' => '50+',
                    'value_suffix' => 'Items',
                    'description' => 'A Powerful Production Capacity Of 150,000~200,000 Units Per Day.',
                ],
            ],
        ];

        foreach ($cards as $card) {
            $en = $card['en'];
            unset($card['en']);
            WhyChooseCard::create(array_merge($card, ['en' => $en]));
        }

        $this->info('Seeded ' . count($cards) . ' why choose cards.');
    }
}
