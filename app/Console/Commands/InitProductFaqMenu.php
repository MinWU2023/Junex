<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitProductFaqMenu extends Command
{
    protected $signature = 'init:product-faq';

    protected $description = 'Initialize Product Faqs menu and permissions under Faqs management';

    public function handle()
    {
        $this->info('Initializing Product Faqs Menu and Permissions...');

        $createdAt = date('Y-m-d H:i:s');

        $faqMenu = Menu::query()->where('route', 'admin.faq.index')->first();
        $parentId = $faqMenu ? (int)$faqMenu->parent_id : 0;
        if ($parentId <= 0) {
            $parentMenu = Menu::query()->where('name', '产品相关')->orWhere('name', '内容相关')->first();
            $parentId = $parentMenu ? (int)$parentMenu->id : 0;
        }
        if ($parentId <= 0) {
            $this->error('Parent menu not found.');
            return 1;
        }

        $route = 'admin.productFaq.index';
        $menuName = '产品Faqs';
        $menu = Menu::query()->where('route', $route)->first();
        if (!$menu) {
            Menu::query()->create([
                'parent_id' => $parentId,
                'name' => $menuName,
                'route' => $route,
                'sort' => ((int)($faqMenu->sort ?? 0)) + 1,
                'icon' => '',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
            $this->info("Menu '{$menuName}' created.");
        } else {
            if ((string)$menu->name !== $menuName) {
                $menu->name = $menuName;
                $menu->updated_at = $createdAt;
                $menu->save();
                $this->info("Menu renamed to '{$menuName}'.");
            } else {
                $this->warn("Menu '{$menuName}' already exists.");
            }
        }

        $groupName = '产品Faqs';
        $group = PermissionGroup::query()->where('name', $groupName)->first();
        if (!$group) {
            // migrate old group name if present
            $oldGroup = PermissionGroup::query()->where('name', '产品问答')->first();
            if ($oldGroup) {
                $oldGroup->name = $groupName;
                $oldGroup->save();
                $group = $oldGroup;
                $this->info("Permission Group renamed to '{$groupName}'.");
            } else {
                $group = PermissionGroup::query()->create(['name' => $groupName]);
                $this->info("Permission Group '{$groupName}' created.");
            }
        }

        $permissions = [
            'admin.productFaq.index' => '产品Faqs列表',
            'admin.productFaq.create' => '产品Faqs新增页面',
            'admin.productFaq.store' => '产品Faqs新增',
            'admin.productFaq.edit' => '产品Faqs编辑页面',
            'admin.productFaq.update' => '产品Faqs编辑',
            'admin.productFaq.destroy' => '产品Faqs删除',
            'admin.productFaq.batchDestroy' => '产品Faqs批量删除',
            'admin.productFaq.updateSort' => '产品Faqs修改排序',
            'admin.productFaq.syncFromFaqs' => '产品Faqs同步Faqs',
            'admin.productFaq.export' => '产品Faqs导出',
            'admin.productFaq.import' => '产品Faqs导入',
            'admin.productFaq.searchProducts' => '产品Faqs搜索产品',
            'admin.productFaq.categoryTree' => '产品Faqs分类树',
            'admin.productFaq.syncRelations' => '产品Faqs保存关联',
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
                if ((string)$permission->display_name !== $displayName || (int)$permission->pg_id !== (int)$group->id) {
                    $permission->display_name = $displayName;
                    $permission->pg_id = $group->id;
                    $permission->updated_at = $createdAt;
                    $permission->save();
                }
                $this->warn("Permission '{$name}' already exists.");
            }
        }

        // Faqs 管理批量删除 / 排序权限
        $faqGroup = PermissionGroup::query()->where('name', 'Faqs管理')->first()
            ?: PermissionGroup::query()->where('name', 'like', '%Faq%')->orderBy('id')->first();
        $faqExtraPermissions = [
            'admin.faq.batchDestroy' => 'Faqs批量删除',
            'admin.faq.updateSort' => 'Faqs修改排序',
        ];
        foreach ($faqExtraPermissions as $faqExtraName => $faqExtraDisplay) {
            $faqExtra = Permission::query()->where('name', $faqExtraName)->first();
            if (!$faqExtra) {
                Permission::query()->create([
                    'name' => $faqExtraName,
                    'display_name' => $faqExtraDisplay,
                    'guard_name' => 'web',
                    'pg_id' => $faqGroup ? $faqGroup->id : ($group->id ?? 0),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
                $this->info("Permission '{$faqExtraName}' created.");
            }
        }

        $role = Role::where('name', '超级管理员')->first();
        if ($role) {
            $all = array_merge(array_keys($permissions), array_keys($faqExtraPermissions));
            $role->givePermissionTo($all);
            $this->info("Permissions assigned to '超级管理员' role.");
        }

        $this->info('Initialization complete!');
        return 0;
    }
}
