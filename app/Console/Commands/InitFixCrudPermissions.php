<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InitFixCrudPermissions extends Command
{
    protected $signature = 'init:fix-crud-permissions';

    protected $description = 'Fix missing CRUD permissions for admin modules (productVideo, faq, customerReview) and assign to Super Admin role';

    public function handle()
    {
        $this->info('Fixing CRUD permissions...');

        $role = Role::query()->where('name', '超级管理员')->first();
        if (!$role) {
            $this->error("Role '超级管理员' not found.");
            return 1;
        }

        $modules = [
            [
                'group' => '产品视频管理',
                'permissions' => [
                    'admin.menu.productVideo.visibility' => '视频管理',
                    'admin.productVideo.index' => '查看产品视频',
                    'admin.productVideo.create' => '新增产品视频页面',
                    'admin.productVideo.store' => '新增产品视频',
                    'admin.productVideo.edit' => '编辑产品视频页面',
                    'admin.productVideo.update' => '编辑产品视频',
                    'admin.productVideo.destroy' => '删除产品视频',
                    'admin.productVideo.searchProducts' => '视频搜索关联产品',
                    'admin.productVideoCategory.index' => '视频分类列表',
                    'admin.productVideoCategory.create' => '视频分类新增页面',
                    'admin.productVideoCategory.store' => '视频分类新增',
                    'admin.productVideoCategory.edit' => '视频分类编辑页面',
                    'admin.productVideoCategory.update' => '视频分类编辑',
                    'admin.productVideoCategory.destroy' => '视频分类删除',
                ]
            ],
            [
                'group' => 'Faqs管理',
                'permissions' => [
                    'admin.faq.index' => '查看Faq',
                    'admin.faq.create' => '新增Faq页面',
                    'admin.faq.store' => '新增Faq',
                    'admin.faq.edit' => '编辑Faq页面',
                    'admin.faq.update' => '编辑Faq',
                    'admin.faq.destroy' => '删除Faq',
                ]
            ],
            [
                'group' => 'Faqs分组管理',
                'permissions' => [
                    'admin.faqGroup.index' => '查看Faq分组',
                    'admin.faqGroup.create' => '新增Faq分组页面',
                    'admin.faqGroup.store' => '新增Faq分组',
                    'admin.faqGroup.edit' => '编辑Faq分组页面',
                    'admin.faqGroup.update' => '编辑Faq分组',
                    'admin.faqGroup.destroy' => '删除Faq分组',
                ]
            ],
            [
                'group' => '评论管理',
                'permissions' => [
                    'admin.customerReview.index' => '查看评论',
                    'admin.customerReview.create' => '新增评论页面',
                    'admin.customerReview.store' => '新增评论',
                    'admin.customerReview.edit' => '编辑评论页面',
                    'admin.customerReview.update' => '编辑评论',
                    'admin.customerReview.destroy' => '删除评论',
                ]
            ],
            [
                'group' => '产品属性管理',
                'permissions' => [
                    'admin.product.attribute.bindValues' => '逗号绑定产品属性值',
                ]
            ],
        ];

        $all = [];
        foreach ($modules as $module) {
            $groupName = $module['group'];
            $group = PermissionGroup::query()->firstOrCreate(['name' => $groupName]);
            $this->line("Permission group: {$groupName}");

            foreach ($module['permissions'] as $name => $displayName) {
                $perm = Permission::query()->where('name', $name)->first();
                if (!$perm) {
                    Permission::query()->create([
                        'name' => $name,
                        'display_name' => $displayName,
                        'guard_name' => 'web',
                        'pg_id' => $group->id,
                    ]);
                    $this->info("Created: {$name}");
                } else {
                    if ((int)($perm->pg_id ?? 0) === 0) {
                        $perm->pg_id = $group->id;
                        $perm->save();
                    }
                    $this->warn("Exists: {$name}");
                }
                $all[] = $name;
            }
        }

        $role->givePermissionTo($all);
        $this->info("Permissions assigned to '超级管理员' role.");
        $this->info('Done.');
        return 0;
    }
}
