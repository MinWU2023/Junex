<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitStaticBlockMenu extends Command
{
    protected $signature = 'init:static-block';

    protected $description = 'Initialize Static Block menu and permissions under 页面';

    public function handle()
    {
        $this->info('Initializing Static Block Menu and Permissions...');

        $createdAt = date('Y-m-d H:i:s');

        $parentMenu = Menu::query()
            ->where(function ($q) {
                $q->where('route', 'admin.menu.page.visibility')
                    ->orWhere('name', '页面');
            })
            ->first();

        if (!$parentMenu) {
            $this->error("Parent menu '页面' not found.");
            return 1;
        }

        $route = 'admin.staticBlock.index';
        $menuName = '静态块管理';

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
            $this->info("Menu '{$menuName}' created under '{$parentMenu->name}'.");
        } else {
            if ((int)$menu->parent_id !== (int)$parentMenu->id) {
                $menu->parent_id = $parentMenu->id;
                $menu->name = $menuName;
                $menu->save();
                $this->info("Menu '{$menuName}' parent updated.");
            } else {
                $this->warn("Menu '{$menuName}' already exists.");
            }
        }

        $group = PermissionGroup::query()->where('name', '单页面管理')->first();
        if (!$group) {
            $group = PermissionGroup::query()->where('name', '静态块管理')->first();
        }
        if (!$group) {
            $group = PermissionGroup::query()->create(['name' => '静态块管理']);
            $this->info("Permission Group '静态块管理' created.");
        } else {
            $this->info("Using Permission Group '{$group->name}'.");
        }

        $permissions = [
            'admin.staticBlock.index' => '静态块列表',
            'admin.staticBlock.create' => '静态块新增页面',
            'admin.staticBlock.store' => '静态块新增',
            'admin.staticBlock.edit' => '静态块编辑页面',
            'admin.staticBlock.update' => '静态块编辑',
            'admin.staticBlock.destroy' => '静态块删除',
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
                if ((int)$permission->pg_id !== (int)$group->id) {
                    $permission->pg_id = $group->id;
                    $permission->display_name = $displayName;
                    $permission->save();
                }
                $this->warn("Permission '{$name}' already exists.");
            }
        }

        $role = Role::where('name', '超级管理员')->first();
        if ($role) {
            $role->givePermissionTo(array_keys($permissions));
            $this->info("Permissions assigned to '超级管理员' role.");
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->info('Permission cache cleared.');

        $this->info('Initialization complete!');
        return 0;
    }
}
