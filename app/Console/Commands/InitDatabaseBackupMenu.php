<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class InitDatabaseBackupMenu extends Command
{
    protected $signature = 'init:database-backup';

    protected $description = 'Initialize 数据备份 menu and permissions under 后台管理';

    public function handle(): int
    {
        $this->info('Initializing Database Backup Menu and Permissions...');

        $createdAt = date('Y-m-d H:i:s');

        $parentMenu = Menu::query()
            ->where(function ($q) {
                $q->where('route', 'admin.menu.manager.visibility')
                    ->orWhere(function ($q2) {
                        $q2->where('name', '后台管理')->where('parent_id', 0);
                    });
            })
            ->first();

        if (!$parentMenu) {
            $this->error("Parent menu '后台管理' not found.");
            return 1;
        }

        $route = 'admin.databaseBackup.index';
        $menuName = '数据备份';

        $menu = Menu::query()->where('route', $route)->first();
        if (!$menu) {
            Menu::query()->create([
                'parent_id' => $parentMenu->id,
                'name' => $menuName,
                'route' => $route,
                'sort' => 99,
                'icon' => '',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
            $this->info("Menu '{$menuName}' created under '{$parentMenu->name}'.");
        } else {
            if ((int) $menu->parent_id !== (int) $parentMenu->id || $menu->name !== $menuName) {
                $menu->parent_id = $parentMenu->id;
                $menu->name = $menuName;
                $menu->save();
                $this->info("Menu '{$menuName}' updated.");
            } else {
                $this->warn("Menu '{$menuName}' already exists.");
            }
        }

        $group = PermissionGroup::query()->where('name', '管理员管理')->first();
        if (!$group) {
            $group = PermissionGroup::query()->firstOrCreate(['name' => '数据备份']);
            $this->info("Permission Group '{$group->name}' ready.");
        } else {
            $this->info("Using Permission Group '{$group->name}'.");
        }

        $permissions = [
            'admin.databaseBackup.index' => '数据备份列表',
            'admin.databaseBackup.store' => '手动创建备份',
            'admin.databaseBackup.download' => '下载备份',
            'admin.databaseBackup.destroy' => '删除备份',
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
                if ((int) $permission->pg_id !== (int) $group->id || $permission->display_name !== $displayName) {
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

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->info('Permission cache cleared.');
        $this->info('Initialization complete!');

        return 0;
    }
}
