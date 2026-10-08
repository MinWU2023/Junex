<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitCustomServiceMenu extends Command
{
    protected $signature = 'init:custom-service';

    protected $description = 'Initialize Custom Service (Junex Custom Service) menu and permissions';

    public function handle()
    {
        $this->info('Initializing Custom Service Menu and Permissions...');

        $createdAt = date('Y-m-d H:i:s');

        $parentMenu = Menu::query()->where('name', '内容相关')->first();
        if (!$parentMenu) {
            $this->error("Parent menu '内容相关' not found.");
            return 1;
        }

        $route = 'admin.customService.index';
        $menuName = '定制服务';

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

        $groupName = '定制服务';
        $group = PermissionGroup::query()->where('name', $groupName)->first();
        if (!$group) {
            $group = PermissionGroup::query()->create(['name' => $groupName]);
            $this->info("Permission Group '{$groupName}' created.");
        }

        $permissions = [
            'admin.customService.index' => '定制服务列表',
            'admin.customService.create' => '定制服务新增页面',
            'admin.customService.store' => '定制服务新增',
            'admin.customService.edit' => '定制服务编辑页面',
            'admin.customService.update' => '定制服务编辑',
            'admin.customService.destroy' => '定制服务删除',
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
