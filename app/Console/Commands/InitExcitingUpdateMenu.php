<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Blog\Models\Blog;
use App\Modules\Menu\Models\Menu;
use App\Modules\Setting\Models\ExcitingUpdate;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitExcitingUpdateMenu extends Command
{
    protected $signature = 'init:exciting-update {--fresh : Truncate and re-seed blog associations}';

    protected $description = 'Initialize Exciting Updates menu, permissions and seed blog associations';

    public function handle()
    {
        $this->info('Initializing Exciting Update Menu and Permissions...');

        $createdAt = date('Y-m-d H:i:s');

        $parentMenu = Menu::query()->where('name', '内容相关')->first();
        if (!$parentMenu) {
            // fallback: 数据管理 nested parent if regrouped
            $parentMenu = Menu::query()->where('name', '数据管理')->first();
        }
        if (!$parentMenu) {
            $this->error("Parent menu not found.");
            return 1;
        }

        $route = 'admin.excitingUpdate.index';
        $menuName = '精彩动态';

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

        $groupName = '精彩动态';
        $group = PermissionGroup::query()->where('name', $groupName)->first();
        if (!$group) {
            $group = PermissionGroup::query()->create(['name' => $groupName]);
            $this->info("Permission Group '{$groupName}' created.");
        }

        $permissions = [
            'admin.excitingUpdate.index' => '精彩动态列表',
            'admin.excitingUpdate.create' => '精彩动态新增页面',
            'admin.excitingUpdate.store' => '精彩动态新增',
            'admin.excitingUpdate.edit' => '精彩动态编辑页面',
            'admin.excitingUpdate.update' => '精彩动态编辑',
            'admin.excitingUpdate.destroy' => '精彩动态删除',
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
        $count = ExcitingUpdate::query()->count();
        if ($count > 0 && !$this->option('fresh')) {
            $this->warn("Exciting updates already exist ({$count}), skip seeding. Use --fresh to re-seed.");
            return;
        }

        if ($this->option('fresh') && $count > 0) {
            ExcitingUpdate::query()->delete();
            $this->info('Existing exciting updates cleared.');
        }

        $blogs = Blog::query()
            ->active()
            ->orderByDesc('id')
            ->limit(6)
            ->get(['id']);

        if ($blogs->isEmpty()) {
            $this->warn('No active blogs found, skip seeding associations.');
            return;
        }

        $sort = 60;
        foreach ($blogs as $blog) {
            ExcitingUpdate::create([
                'blog_id' => $blog->id,
                'sort' => $sort,
                'active' => 1,
            ]);
            $this->line("Linked blog #{$blog->id}");
            $sort -= 10;
        }

        $this->info('Exciting update blog associations seeded: ' . $blogs->count());
    }
}
