<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitSnsIconMenu extends Command
{
    protected $signature = 'init:sns-icon';

    protected $description = 'Initialize SNS Icons menu and permissions under 数据管理';

    public function handle()
    {
        $this->info('Initializing SNS Icon Menu and Permissions...');

        $createdAt = date('Y-m-d H:i:s');

        $parentMenu = Menu::query()
            ->where('name', '数据管理')
            ->where('parent_id', '>', 0)
            ->orderByDesc('id')
            ->first();

        if (!$parentMenu) {
            $brandMenu = Menu::query()->where('route', 'admin.brandSolution.index')->first();
            if ($brandMenu && $brandMenu->parent_id) {
                $parentMenu = Menu::query()->find($brandMenu->parent_id);
            }
        }

        if (!$parentMenu) {
            $parentMenu = Menu::query()->where('name', '数据管理')->where('parent_id', 0)->first();
        }

        if (!$parentMenu) {
            $parentMenu = Menu::query()->where('name', '内容相关')->first();
        }

        if (!$parentMenu) {
            $this->error("Parent menu '数据管理' / '内容相关' not found.");
            return 1;
        }

        $route = 'admin.snsIcon.index';
        $menuName = 'SNS图标';

        $menu = Menu::query()->where('route', $route)->first();
        if (!$menu) {
            Menu::query()->create([
                'parent_id' => $parentMenu->id,
                'name' => $menuName,
                'route' => $route,
                'sort' => 75,
                'icon' => '',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
            $this->info("Menu '{$menuName}' created under '{$parentMenu->name}'(#{$parentMenu->id}).");
        } else {
            $menu->parent_id = $parentMenu->id;
            $menu->name = $menuName;
            if ((int)$menu->sort === 0) {
                $menu->sort = 75;
            }
            $menu->save();
            $this->info("Menu '{$menuName}' updated under '{$parentMenu->name}'(#{$parentMenu->id}).");
        }

        $groupName = 'SNS图标';
        $group = PermissionGroup::query()->where('name', $groupName)->first();
        if (!$group) {
            $group = PermissionGroup::query()->create(['name' => $groupName]);
            $this->info("Permission Group '{$groupName}' created.");
        }

        $permissions = [
            'admin.snsIcon.index' => 'SNS图标列表',
            'admin.snsIcon.create' => 'SNS图标新增页面',
            'admin.snsIcon.store' => 'SNS图标新增',
            'admin.snsIcon.edit' => 'SNS图标编辑页面',
            'admin.snsIcon.update' => 'SNS图标编辑',
            'admin.snsIcon.destroy' => 'SNS图标删除',
            'admin.snsIcon.toggleStatus' => 'SNS图标状态切换',
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
