<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class InitProductVideoMenu extends Command
{
    protected $signature = 'init:product-video';
    protected $description = 'Initialize product video menu tree and permissions under 产品管理 > 视频管理';

    public function handle()
    {
        $productMenu = Menu::query()
            ->where('name', '产品管理')
            ->where('parent_id', 0)
            ->first();

        if (!$productMenu) {
            $this->error('Parent menu 产品管理 not found.');
            return 1;
        }

        $group = PermissionGroup::firstOrCreate(['name' => '产品视频管理']);

        $videoRoot = Menu::query()
            ->where('route', 'admin.menu.productVideo.visibility')
            ->first();

        if (!$videoRoot) {
            $videoRoot = Menu::query()
                ->where('parent_id', $productMenu->id)
                ->whereIn('name', ['视频管理', '产品视频', '产品视频管理'])
                ->first();
        }

        if ($videoRoot) {
            $videoRoot->update([
                'name' => '视频管理',
                'route' => 'admin.menu.productVideo.visibility',
                'parent_id' => $productMenu->id,
                'sort' => 20,
                'icon' => '',
            ]);
        } else {
            $videoRoot = Menu::create([
                'name' => '视频管理',
                'route' => 'admin.menu.productVideo.visibility',
                'parent_id' => $productMenu->id,
                'sort' => 20,
                'icon' => '',
            ]);
        }

        $children = [
            ['name' => '视频分类', 'route' => 'admin.productVideoCategory.index', 'sort' => 10],
            ['name' => '视频列表', 'route' => 'admin.productVideo.index', 'sort' => 20],
        ];

        foreach ($children as $row) {
            $menu = Menu::query()->where('route', $row['route'])->first();
            if ($menu) {
                $menu->update([
                    'name' => $row['name'],
                    'parent_id' => $videoRoot->id,
                    'sort' => $row['sort'],
                ]);
            } else {
                Menu::create([
                    'name' => $row['name'],
                    'route' => $row['route'],
                    'parent_id' => $videoRoot->id,
                    'sort' => $row['sort'],
                    'icon' => '',
                ]);
            }
        }

        // Remove legacy flat entries under 产品管理
        Menu::query()
            ->where('parent_id', $productMenu->id)
            ->whereIn('route', [
                'admin.productVideo.index',
                'admin.productVideoCategory.index',
                'admin.menu.productVideo.visibility',
            ])
            ->where('id', '<>', $videoRoot->id)
            ->delete();

        Menu::query()
            ->where('parent_id', $productMenu->id)
            ->whereIn('name', ['产品视频管理', '产品视频'])
            ->where('id', '<>', $videoRoot->id)
            ->delete();

        $permissions = [
            'admin.menu.productVideo.visibility' => '视频管理',
            'admin.productVideo.index' => '视频列表',
            'admin.productVideo.create' => '视频新增页面',
            'admin.productVideo.store' => '视频新增',
            'admin.productVideo.edit' => '视频编辑页面',
            'admin.productVideo.update' => '视频编辑',
            'admin.productVideo.destroy' => '视频删除',
            'admin.productVideo.searchProducts' => '视频搜索关联产品',
            'admin.productVideoCategory.index' => '视频分类列表',
            'admin.productVideoCategory.create' => '视频分类新增页面',
            'admin.productVideoCategory.store' => '视频分类新增',
            'admin.productVideoCategory.edit' => '视频分类编辑页面',
            'admin.productVideoCategory.update' => '视频分类编辑',
            'admin.productVideoCategory.destroy' => '视频分类删除',
        ];

        foreach ($permissions as $name => $label) {
            $permission = Permission::findOrCreate($name, 'web');
            $permission->pg_id = $group->id;
            $permission->display_name = $label;
            $permission->save();
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::query()->where('name', '超级管理员')->first();
        if ($role) {
            $role->givePermissionTo(array_keys($permissions));
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->info('Product video menu initialized under 产品管理 > 视频管理 > (视频分类 / 视频列表).');
        return 0;
    }
}
