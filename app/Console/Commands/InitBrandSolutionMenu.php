<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitBrandSolutionMenu extends Command
{
    protected $signature = 'init:brand-solution';

    protected $description = 'Initialize Brand Solutions (homepage carousel) menu and permissions';

    public function handle()
    {
        $this->info('Initializing Brand Solution Menu and Permissions...');

        $createdAt = date('Y-m-d H:i:s');

        $parentMenu = Menu::query()->where('name', '内容相关')->first();
        if (!$parentMenu) {
            $this->error("Parent menu '内容相关' not found.");
            return 1;
        }

        $route = 'admin.brandSolution.index';
        $menuName = '品牌解决方案';

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

        $groupName = '品牌解决方案';
        $group = PermissionGroup::query()->where('name', $groupName)->first();
        if (!$group) {
            $group = PermissionGroup::query()->create(['name' => $groupName]);
            $this->info("Permission Group '{$groupName}' created.");
        }

        $permissions = [
            'admin.brandSolution.index' => '品牌解决方案列表',
            'admin.brandSolution.create' => '品牌解决方案新增页面',
            'admin.brandSolution.store' => '品牌解决方案新增',
            'admin.brandSolution.edit' => '品牌解决方案编辑页面',
            'admin.brandSolution.update' => '品牌解决方案编辑',
            'admin.brandSolution.destroy' => '品牌解决方案删除',
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

        $this->info('Initialization complete!');
        return 0;
    }
}
