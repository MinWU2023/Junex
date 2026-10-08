<?php

namespace Database\Seeders;

use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Admin\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $created_at = date('Y-m-d H:i:s');
        $updated_at = $created_at;
        // 创建角色
        $theRole = Role::create([
            'name' => '超级管理员',
            'guard_name' => 'web',
            'info' => '创始人，拥有最高权限'
        ]);
        // 赋予1号用记超级管理员身份
        $user = User::find(1);
        $user->assignRole($theRole);

        $theWebsiteRole = Role::create([
            'name' => '网站管理员',
            'guard_name' => 'web',
            'info' => '网站管理员'
        ]);
        $websiteUser = User::find(2);
        $websiteUser->assignRole($theWebsiteRole);

        // 创建权限组
        DB::table('permission_groups')->insert([
            [
                'id' => 1,
                'name' => '顶级菜单可见性',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 2,
                'name' => '菜单管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 3,
                'name' => '管理员管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 4,
                'name' => '角色管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 5,
                'name' => '权限组管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 6,
                'name' => '权限管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 7,
                'name' => '产品分类管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 8,
                'name' => '产品品牌管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 9,
                'name' => '关键词数据管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 10,
                'name' => '产品属性管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 11,
                'name' => '产品管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 12,
                'name' => '文章分类管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 13,
                'name' => '文章管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 14,
                'name' => '单页面管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 15,
                'name' => '回收站管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 16,
                'name' => '系统设置管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 17,
                'name' => '应用管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 18,
                'name' => '营销管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'id' => 19,
                'name' => '统计数据管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'id' => 20,
                'name' => 'slogan管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 21,
                'name' => '博客分类管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'id' => 22,
                'name' => '博客管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'id' => 23,
                'name' => '博客关键词管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'id' => 24,
                'name' => 'News Letter管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'id' => 25,
                'name' => '下载相关',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 26,
                'name' => '搜索管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'id' => 27,
                'name' => '主页',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'id' => 28,
                'name' => '自定义导航栏',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'id' => 29,
                'name' => '友情链接管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'id' => 30,
                'name' => '相册管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 31,
                'name' => '数据管家',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 32,
                'name' => '关键词排名',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 33,
                'name' => 'url管理',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 34,
                'name' => '产品草稿箱',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 35,
                'name' => '文章草稿箱',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'id' => 36,
                'name' => '博客草稿箱',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);

        DB::table('permissions')->insert([
            [
                'pg_id' => 1,
                'name' => 'admin.menu.dashboard.visibility',
                'display_name' => '主页',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 1,
                'name' => 'admin.menu.product.visibility',
                'display_name' => '产品相关',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 1,
                'name' => 'admin.menu.content.visibility',
                'display_name' => '内容相关',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 1,
                'name' => 'admin.menu.article.visibility',
                'display_name' => '文章',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 1,
                'name' => 'admin.menu.page.visibility',
                'display_name' => '页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 1,
                'name' => 'admin.menu.blog.visibility',
                'display_name' => '博客相关',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 1,
                'name' => 'admin.menu.download.visibility',
                'display_name' => '下载相关',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 1,
                'name' => 'admin.menu.manager.visibility',
                'display_name' => '后台管理相关',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 1,
                'name' => 'admin.menu.trash.visibility',
                'display_name' => '回收站相关',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 1,
                'name' => 'admin.menu.system.visibility',
                'display_name' => '系统设置',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 1,
                'name' => 'admin.menu.extensionMarket.visibility',
                'display_name' => '应用管理',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 1,
                'name' => 'admin.menu.marketing.visibility',
                'display_name' => '营销管理',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 2,
                'name' => 'admin.menu.index',
                'display_name' => '菜单列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 2,
                'name' => 'admin.menu.create',
                'display_name' => '显示添加菜单界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 2,
                'name' => 'admin.menu.store',
                'display_name' => '添加菜单',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 2,
                'name' => 'admin.menu.edit',
                'display_name' => '显示编辑菜单界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 2,
                'name' => 'admin.menu.update',
                'display_name' => '更新菜单',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 2,
                'name' => 'admin.menu.destroy',
                'display_name' => '删除菜单',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 3,
                'name' => 'admin.user.index',
                'display_name' => '管理员列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 3,
                'name' => 'admin.user.create',
                'display_name' => '显示添加管理员界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 3,
                'name' => 'admin.user.store',
                'display_name' => '添加管理员',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 3,
                'name' => 'admin.user.edit',
                'display_name' => '显示编辑管理员界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 3,
                'name' => 'admin.user.update',
                'display_name' => '更新管理员',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 3,
                'name' => 'admin.user.destroy',
                'display_name' => '删除管理员',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 3,
                'name' => 'admin.log.index',
                'display_name' => '操作日志',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 3,
                'name' => 'admin.databaseBackup.index',
                'display_name' => '数据备份列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 3,
                'name' => 'admin.databaseBackup.store',
                'display_name' => '手动创建备份',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 3,
                'name' => 'admin.databaseBackup.download',
                'display_name' => '下载备份',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 3,
                'name' => 'admin.databaseBackup.restore',
                'display_name' => '恢复备份',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 3,
                'name' => 'admin.databaseBackup.destroy',
                'display_name' => '删除备份',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 4,
                'name' => 'admin.role.index',
                'display_name' => '角色列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 4,
                'name' => 'admin.role.create',
                'display_name' => '显示添加角色界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 4,
                'name' => 'admin.role.store',
                'display_name' => '添加角色',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 4,
                'name' => 'admin.role.edit',
                'display_name' => '显示编辑角色界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 4,
                'name' => 'admin.role.update',
                'display_name' => '更新角色',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 4,
                'name' => 'admin.role.destroy',
                'display_name' => '删除角色',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 4,
                'name' => 'admin.roleHasPermission',
                'display_name' => '获取角色下的所有权限（赋予权限角色必勾）',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 5,
                'name' => 'admin.permissionGroup.index',
                'display_name' => '权限组列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 5,
                'name' => 'admin.permissionGroup.create',
                'display_name' => '显示添加权限组界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 5,
                'name' => 'admin.permissionGroup.store',
                'display_name' => '添加权限组',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 5,
                'name' => 'admin.permissionGroup.edit',
                'display_name' => '显示编辑权限组界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 5,
                'name' => 'admin.permissionGroup.update',
                'display_name' => '更新权限组',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 5,
                'name' => 'admin.permissionGroup.destroy',
                'display_name' => '删除权限组',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 6,
                'name' => 'admin.permission.index',
                'display_name' => '权限列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 6,
                'name' => 'admin.permission.create',
                'display_name' => '显示添加权限界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 6,
                'name' => 'admin.permission.store',
                'display_name' => '添加权限',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 6,
                'name' => 'admin.permission.edit',
                'display_name' => '显示编辑权限界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 6,
                'name' => 'admin.permission.update',
                'display_name' => '更新权限',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 6,
                'name' => 'admin.permission.destroy',
                'display_name' => '删除权限',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 6,
                'name' => 'admin.allPermissions',
                'display_name' => '获取当前所有权限（赋予权限角色必勾）',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 7,
                'name' => 'admin.product.category.changeProperty',
                'display_name' => '分类（是否显示，是否显示导航）快速更改',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 7,
                'name' => 'admin.product.category.index',
                'display_name' => '产品分类列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 7,
                'name' => 'admin.product.category.create',
                'display_name' => '显示添加产品分类界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 7,
                'name' => 'admin.product.category.store',
                'display_name' => '添加产品分类',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 7,
                'name' => 'admin.product.category.edit',
                'display_name' => '显示编辑产品分类界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 7,
                'name' => 'admin.product.category.update',
                'display_name' => '更新产品分类',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 7,
                'name' => 'admin.product.category.destroy',
                'display_name' => '删除产品分类',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 7,
                'name' => 'admin.product.category.getAllCategories',
                'display_name' => '获取所有产品分类',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 8,
                'name' => 'admin.product.brand.index',
                'display_name' => '产品品牌列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 8,
                'name' => 'admin.product.brand.create',
                'display_name' => '显示添加产品品牌界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 8,
                'name' => 'admin.product.brand.store',
                'display_name' => '添加产品品牌',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 8,
                'name' => 'admin.product.brand.edit',
                'display_name' => '显示编辑产品品牌界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 8,
                'name' => 'admin.product.brand.update',
                'display_name' => '更新产品品牌',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 8,
                'name' => 'admin.product.brand.destroy',
                'display_name' => '删除产品品牌',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 9,
                'name' => 'admin.allProductTags',
                'display_name' => '获取所有的产品tag',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 9,
                'name' => 'admin.product.tag.index',
                'display_name' => '产品tag列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 9,
                'name' => 'admin.product.tag.create',
                'display_name' => '显示添加产品tag界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 9,
                'name' => 'admin.product.tag.store',
                'display_name' => '添加产品tag',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 9,
                'name' => 'admin.product.tag.edit',
                'display_name' => '显示编辑产品tag界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 9,
                'name' => 'admin.product.tag.update',
                'display_name' => '更新产品tag',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 9,
                'name' => 'admin.product.tag.show',
                'display_name' => '显示tag关联的所有产品',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 9,
                'name' => 'admin.product.tag.destroy',
                'display_name' => '删除产品tag',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 9,
                'name' => 'admin.product.tag.export',
                'display_name' => '导出产品tag',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 9,
                'name' => 'admin.product.tag.detach',
                'display_name' => '解除与产品之间的关联',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 9,
                'name' => 'admin.product.tag.removes',
                'display_name' => '删除未关联产品的关键词',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 9,
                'name' => 'admin.product.tag.changeProperty',
                'display_name' => '产品tag（是否热门）快速更改',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 10,
                'name' => 'admin.product.attributeCategory.index',
                'display_name' => '产品属性分类列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 10,
                'name' => 'admin.product.attributeCategory.create',
                'display_name' => '产品属性分类添加',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 10,
                'name' => 'admin.product.attributeCategory.store',
                'display_name' => '产品属性分类新增',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 10,
                'name' => 'admin.product.attributeCategory.edit',
                'display_name' => '产品属性分类修改',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 10,
                'name' => 'admin.product.attributeCategory.update',
                'display_name' => '产品属性分类更新',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 10,
                'name' => 'admin.product.attributeCategory.destroy',
                'display_name' => '产品属性分类删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

//            [
//                'pg_id' => 10,
//                'name' => 'admin.product.attributeCategory.getAllCategories',
//                'display_name' => '产品属性分类获取',
//                'guard_name' => 'web',
//                'created_at' => $created_at,
//                'updated_at' => $updated_at
//            ],


            [
                'pg_id' => 10,
                'name' => 'admin.product.attribute.index',
                'display_name' => '产品属性列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 10,
                'name' => 'admin.product.attribute.create',
                'display_name' => '显示添加产品属性界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 10,
                'name' => 'admin.product.attribute.store',
                'display_name' => '添加产品属性',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 10,
                'name' => 'admin.product.attribute.edit',
                'display_name' => '显示编辑产品属性界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 10,
                'name' => 'admin.product.attribute.update',
                'display_name' => '更新产品属性',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 10,
                'name' => 'admin.product.attribute.destroy',
                'display_name' => '删除产品属性',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 10,
                'name' => 'admin.product.attribute.bindValues',
                'display_name' => '逗号绑定产品属性值',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.changeProperty',
                'display_name' => '产品（最新，最热，推荐）快速更改',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 11,
                'name' => 'admin.product.index',
                'display_name' => '产品列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.create',
                'display_name' => '显示添加产品界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.store',
                'display_name' => '添加产品',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.edit',
                'display_name' => '显示编辑产品界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.copy',
                'display_name' => '显示编辑产品复制界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.update',
                'display_name' => '更新产品',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.remove',
                'display_name' => '产品放入回收站',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 11,
                'name' => 'admin.product.multipleMoveCategoryShow',
                'display_name' => '显示产品批量修改界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 11,
                'name' => 'admin.product.multipleMoveCategory',
                'display_name' => '产品批量更改分类',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.multipleMoveBrandShow',
                'display_name' => '显示品牌批量修改界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.multipleMoveBrand',
                'display_name' => '产品批量更改品牌',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.multipleMoveUserShow',
                'display_name' => '显示产品批量移动到子帐户界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.multipleMoveUser',
                'display_name' => '产品批量移动到子帐户',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.multipleMoveTrash',
                'display_name' => '产品批量放入回收站',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 11,
                'name' => 'admin.product.multipleRestore',
                'display_name' => '产品批量恢复',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 11,
                'name' => 'admin.product.multipleDestroy',
                'display_name' => '产品批量删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 12,
                'name' => 'admin.article.category.index',
                'display_name' => '文章分类列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 12,
                'name' => 'admin.article.category.create',
                'display_name' => '显示添加文章分类界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 12,
                'name' => 'admin.article.category.store',
                'display_name' => '添加文章分类',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 12,
                'name' => 'admin.article.category.edit',
                'display_name' => '显示编辑文章分类界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 12,
                'name' => 'admin.article.category.update',
                'display_name' => '更新文章分类',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 12,
                'name' => 'admin.article.category.destroy',
                'display_name' => '删除文章分类',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 13,
                'name' => 'admin.article.index',
                'display_name' => '文章列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 13,
                'name' => 'admin.article.create',
                'display_name' => '显示添加文章界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 13,
                'name' => 'admin.article.store',
                'display_name' => '添加文章',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 13,
                'name' => 'admin.article.edit',
                'display_name' => '显示编辑文章界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 13,
                'name' => 'admin.article.update',
                'display_name' => '更新文章',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 13,
                'name' => 'admin.article.remove',
                'display_name' => '文章放入回收站',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 13,
                'name' => 'admin.article.changeProperty',
                'display_name' => '文章（是否显示）快速更改',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 13,
                'name' => 'admin.article.multipleMoveTrash',
                'display_name' => '文章批量放入回收站',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 13,
                'name' => 'admin.article.multipleRestore',
                'display_name' => '文章批量恢复',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 13,
                'name' => 'admin.article.multipleDestroy',
                'display_name' => '文章批量删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 13,
                'name' => 'admin.article.getAllArticles',
                'display_name' => '获取所有文章',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 14,
                'name' => 'admin.page.index',
                'display_name' => '单页面列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 14,
                'name' => 'admin.page.create',
                'display_name' => '显示添加单页面界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 14,
                'name' => 'admin.page.store',
                'display_name' => '添加单页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 14,
                'name' => 'admin.page.edit',
                'display_name' => '显示编辑单页面界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 14,
                'name' => 'admin.page.update',
                'display_name' => '更新单页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 14,
                'name' => 'admin.page.remove',
                'display_name' => '单页面放入回收站',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 15,
                'name' => 'admin.article.trash',
                'display_name' => '文章列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 15,
                'name' => 'admin.article.restore',
                'display_name' => '文章恢复',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 15,
                'name' => 'admin.article.destroy',
                'display_name' => '文章彻底删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 15,
                'name' => 'admin.product.trash',
                'display_name' => '产品列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 15,
                'name' => 'admin.product.restore',
                'display_name' => '产品恢复',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 15,
                'name' => 'admin.product.destroy',
                'display_name' => '产品彻底删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 11,
                'name' => 'admin.product.getAttribute',
                'display_name' => '获取属性',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 15,
                'name' => 'admin.page.trash',
                'display_name' => '单页面列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 15,
                'name' => 'admin.page.restore',
                'display_name' => '单页面恢复',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 15,
                'name' => 'admin.page.destroy',
                'display_name' => '单页面彻底删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 16,
                'name' => 'admin.setting.index',
                'display_name' => '网站设置页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 16,
                'name' => 'admin.setting.update',
                'display_name' => '网站设置更新',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 16,
                'name' => 'admin.setting.clearCache',
                'display_name' => '清除缓存',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 16,
                'name' => 'admin.translateJob.index',
                'display_name' => '翻译任务',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 16,
                'name' => 'admin.setting.banner.index',
                'display_name' => 'banner列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 16,
                'name' => 'admin.setting.banner.create',
                'display_name' => '显示添加banner界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 16,
                'name' => 'admin.setting.banner.store',
                'display_name' => '添加banner',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 16,
                'name' => 'admin.setting.banner.edit',
                'display_name' => '显示编辑banner界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 16,
                'name' => 'admin.setting.banner.update',
                'display_name' => '更新banner',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 16,
                'name' => 'admin.setting.banner.destroy',
                'display_name' => '删除banner',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 16,
                'name' => 'admin.setting.locale.index',
                'display_name' => '多语言列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 16,
                'name' => 'admin.setting.locale.create',
                'display_name' => '显示添加多语言界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 16,
                'name' => 'admin.setting.locale.store',
                'display_name' => '新增多语言',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 16,
                'name' => 'admin.setting.locale.edit',
                'display_name' => '显示编辑多语言界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 16,
                'name' => 'admin.setting.locale.update',
                'display_name' => '更新多语言',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 16,
                'name' => 'admin.setting.locale.destroy',
                'display_name' => '删除多语言',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 17,
                'name' => 'admin.extensionMarket.index',
                'display_name' => '应用市场列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 17,
                'name' => 'admin.extensionMarket.login',
                'display_name' => '应用市场登陆界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 17,
                'name' => 'admin.extensionMarket.doLogin',
                'display_name' => '应用市场登陆',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 17,
                'name' => 'admin.extensionMarket.install',
                'display_name' => '应用安装',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 17,
                'name' => 'admin.extensionMarket.upgrade',
                'display_name' => '应用更新',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 17,
                'name' => 'admin.extensionMarket.uninstall',
                'display_name' => '应用卸载',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.index',
                'display_name' => '客户询盘列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 18,
                'name' => 'admin.listing.index',
                'display_name' => 'listing列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.show',
                'display_name' => '客户询盘查看',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.destroy',
                'display_name' => '客户询盘删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.remove',
                'display_name' => '客户询盘放入回收站',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.restore',
                'display_name' => '客户询盘回收站收回',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.trash',
                'display_name' => '客户询盘回收站列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.multipleDestroy',
                'display_name' => '客户询盘回收站删除(批量)',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.multipleRestore',
                'display_name' => '客户询盘恢复(批量)',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.multipleMoveTrash',
                'display_name' => '客户询盘删除(批量)',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.remark',
                'display_name' => '客户询盘跟进情况添加',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.export',
                'display_name' => '询盘导出',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

//            [
//                'pg_id' => 18,
//                'name' => 'admin.inquiry.newsletter',
//                'display_name' => '邮箱订阅',
//                'guard_name' => 'web',
//                'created_at' => $created_at,
//                'updated_at' => $updated_at
//            ],

            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.multipleRemove',
                'display_name' => '询盘批量删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.editUser',
                'display_name' => '询盘添加分配管理员页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.updateUser',
                'display_name' => '询盘分配管理员',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 18,
                'name' => 'admin.inquiry.repeat',
                'display_name' => '查看重复ip或邮箱',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 19,
                'name' => 'admin.menu.information.visibility',
                'display_name' => '数据管理',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 27,
                'name' => 'admin.report.index',
                'display_name' => '统计数据类型展示',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 27,
                'name' => 'admin.report.getStatistics',
                'display_name' => '获取网站统计基本信息',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 27,
                'name' => 'admin.report.show',
                'display_name' => '查看网站统计详细信息',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 27,
                'name' => 'admin.setting.getNotice',
                'display_name' => '获取公告',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 20,
                'name' => 'admin.setting.slogan.index',
                'display_name' => 'slogan列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 20,
                'name' => 'admin.setting.slogan.create',
                'display_name' => '显示slogan界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 20,
                'name' => 'admin.setting.slogan.store',
                'display_name' => '添加slogan',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 20,
                'name' => 'admin.setting.slogan.edit',
                'display_name' => '显示编辑slogan',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 20,
                'name' => 'admin.setting.slogan.update',
                'display_name' => '更新slogan',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 20,
                'name' => 'admin.setting.slogan.destroy',
                'display_name' => '删除slogan',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 21,
                'name' => 'admin.blog.category.index',
                'display_name' => '博客分类列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 21,
                'name' => 'admin.blog.category.create',
                'display_name' => '显示添加博客分类界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 21,
                'name' => 'admin.blog.category.store',
                'display_name' => '添加博客分类',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 21,
                'name' => 'admin.blog.category.edit',
                'display_name' => '显示编辑博客分类界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 21,
                'name' => 'admin.blog.category.update',
                'display_name' => '更新博客分类',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 21,
                'name' => 'admin.blog.category.destroy',
                'display_name' => '删除博客分类',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 22,
                'name' => 'admin.blog.multipleMoveTrash',
                'display_name' => '博客批量放入回收站',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 22,
                'name' => 'admin.blog.multipleRestore',
                'display_name' => '博客批量恢复',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 22,
                'name' => 'admin.blog.multipleDestroy',
                'display_name' => '博客批量删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 22,
                'name' => 'admin.blog.index',
                'display_name' => '博客列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 22,
                'name' => 'admin.blog.create',
                'display_name' => '显示添加博客界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 22,
                'name' => 'admin.blog.store',
                'display_name' => '添加博客',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 22,
                'name' => 'admin.blog.edit',
                'display_name' => '显示编辑博客界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 22,
                'name' => 'admin.blog.update',
                'display_name' => '更新博客',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 22,
                'name' => 'admin.blog.remove',
                'display_name' => '博客放入回收站',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 14,
                'name' => 'admin.blog.trash',
                'display_name' => '博客列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 14,
                'name' => 'admin.blog.restore',
                'display_name' => '博客恢复',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 14,
                'name' => 'admin.blog.destroy',
                'display_name' => '博客彻底删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 23,
                'name' => 'admin.blog.tag.index',
                'display_name' => '博客关键词查看',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 23,
                'name' => 'admin.blog.tag.create',
                'display_name' => '博客关键词页面添加',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 23,
                'name' => 'admin.blog.tag.store',
                'display_name' => '博客关键词数据保存',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 23,
                'name' => 'admin.blog.tag.edit',
                'display_name' => '博客关键词数据修改页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 23,
                'name' => 'admin.blog.tag.update',
                'display_name' => '博客关键词数据修改数据',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 23,
                'name' => 'admin.blog.tag.show',
                'display_name' => '显示tag关联的所有博客',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 23,
                'name' => 'admin.blog.tag.destroy',
                'display_name' => '删除博客关键词',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 23,
                'name' => 'admin.blog.tag.detach',
                'display_name' => '解除关键词与博客关联',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 23,
                'name' => 'admin.blog.tag.removes',
                'display_name' => '删除未关联博客的关键词',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 23,
                'name' => 'admin.blog.tag.export',
                'display_name' => '导出博客tag',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 23,
                'name' => 'admin.allBlogTags',
                'display_name' => '获取所有关键词',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 24,
                'name' => 'admin.newsletter.index',
                'display_name' => 'newsletter列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 24,
                'name' => 'admin.newsletter.destroy',
                'display_name' => 'newsletter删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 25,
                'name' => 'admin.download.index',
                'display_name' => '下载列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 25,
                'name' => 'admin.download.create',
                'display_name' => '下载创建',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 25,
                'name' => 'admin.download.store',
                'display_name' => '下载新增',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 25,
                'name' => 'admin.download.edit',
                'display_name' => '下载修改',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 25,
                'name' => 'admin.download.update',
                'display_name' => '下载更新',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 25,
                'name' => 'admin.download.destroy',
                'display_name' => '下载删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 25,
                'name' => 'admin.download.category.index',
                'display_name' => '下载分类列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 25,
                'name' => 'admin.download.category.create',
                'display_name' => '下载分类创建',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 25,
                'name' => 'admin.download.category.store',
                'display_name' => '下载分类新增',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 25,
                'name' => 'admin.download.category.edit',
                'display_name' => '下载分类修改',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 25,
                'name' => 'admin.download.category.update',
                'display_name' => '下载分类更新',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 25,
                'name' => 'admin.download.category.destroy',
                'display_name' => '下载分类删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 26,
                'name' => 'admin.search',
                'display_name' => '搜索列表页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 28,
                'name' => 'admin.navigation.index',
                'display_name' => '自定义导航栏管理',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 28,
                'name' => 'admin.navigation.create',
                'display_name' => '自定义导航栏创建页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 28,
                'name' => 'admin.navigation.store',
                'display_name' => '自定义导航栏新增',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 28,
                'name' => 'admin.navigation.edit',
                'display_name' => '自定义导航栏修改页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 28,
                'name' => 'admin.navigation.update',
                'display_name' => '自定义导航栏更新',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 28,
                'name' => 'admin.navigation.destroy',
                'display_name' => '自定义导航栏删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 28,
                'name' => 'admin.navigation.changeProperty',
                'display_name' => '快速修改',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 29,
                'name' => 'admin.friendLink.index',
                'display_name' => 'friendLink列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 29,
                'name' => 'admin.friendLink.create',
                'display_name' => '新增friendLink页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 29,
                'name' => 'admin.friendLink.store',
                'display_name' => '新增friendLink',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 29,
                'name' => 'admin.friendLink.edit',
                'display_name' => '修改friendLink页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 29,
                'name' => 'admin.friendLink.update',
                'display_name' => '修改friendLink',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 29,
                'name' => 'admin.friendLink.destroy',
                'display_name' => 'friendLink删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 30,
                'name' => 'admin.photoAlbum.index',
                'display_name' => '相册列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 30,
                'name' => 'admin.photoAlbum.create',
                'display_name' => '新增相册页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 30,
                'name' => 'admin.photoAlbum.store',
                'display_name' => '新增相册',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 30,
                'name' => 'admin.photoAlbum.edit',
                'display_name' => '修改相册页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 30,
                'name' => 'admin.photoAlbum.update',
                'display_name' => '修改相册',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 30,
                'name' => 'admin.photoAlbum.destroy',
                'display_name' => '相册删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],


            [
                'pg_id' => 30,
                'name' => 'admin.photo.visibility',
                'display_name' => '相册',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 30,
                'name' => 'admin.picture.index',
                'display_name' => '所有图片',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 30,
                'name' => 'admin.picture.multipleMoveAlbumShow',
                'display_name' => '显示图片转移',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 30,
                'name' => 'admin.picture.multipleMoveAlbum',
                'display_name' => '图片转移操作',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 30,
                'name' => 'admin.picture.multipleMoveRemove',
                'display_name' => '图片批量删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 30,
                'name' => 'admin.picture.pop',
                'display_name' => '弹出相册',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 30,
                'name' => 'admin.picture.destroy',
                'display_name' => '删除图片',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 30,
                'name' => 'admin.photoAlbum.uploadShow',
                'display_name' => '批量上传图片',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 30,
                'name' => 'admin.photoAlbum.upload',
                'display_name' => '批量上传图片(操作)',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 31,
                'name' => 'admin.dataManager.index',
                'display_name' => '数据管家查看',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 31,
                'name' => 'admin.dataManager.data',
                'display_name' => '数据管家数据获取',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 31,
                'name' => 'admin.dataManager.productCategoryRate',
                'display_name' => '数据管家分类统计数据获取',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 32,
                'name' => 'admin.keywordsRank.index',
                'display_name' => '关键词排名',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 32,
                'name' => 'admin.keywordsRank.export',
                'display_name' => '关键词排名导出',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 33,
                'name' => 'admin.url.index',
                'display_name' => 'url管理列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 33,
                'name' => 'admin.url.destroy',
                'display_name' => 'url删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 34,
                'name' => 'admin.product.draft.index',
                'display_name' => '产品草稿列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 34,
                'name' => 'admin.product.draft.edit',
                'display_name' => '显示产品草稿界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 34,
                'name' => 'admin.product.draft.update',
                'display_name' => '更新产品草稿',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 34,
                'name' => 'admin.product.draft.destroy',
                'display_name' => '产品草稿删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 34,
                'name' => 'admin.product.draft.schedule',
                'display_name' => '设置定时发布',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 34,
                'name' => 'admin.product.draft.schedule.delete',
                'display_name' => '删除定时发布',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 35,
                'name' => 'admin.article.draft.index',
                'display_name' => '文章草稿列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 35,
                'name' => 'admin.article.draft.edit',
                'display_name' => '显示文章草稿界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 35,
                'name' => 'admin.article.draft.update',
                'display_name' => '更新文章草稿',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 35,
                'name' => 'admin.article.draft.destroy',
                'display_name' => '文章草稿删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 35,
                'name' => 'admin.article.draft.schedule',
                'display_name' => '设置定时发布',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 35,
                'name' => 'admin.article.draft.schedule.delete',
                'display_name' => '删除定时发布',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 36,
                'name' => 'admin.blog.draft.index',
                'display_name' => '博客草稿列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 36,
                'name' => 'admin.blog.draft.edit',
                'display_name' => '显示博客草稿界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 36,
                'name' => 'admin.blog.draft.update',
                'display_name' => '更新博客草稿',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 36,
                'name' => 'admin.blog.draft.destroy',
                'display_name' => '博客草稿删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 36,
                'name' => 'admin.blog.draft.schedule',
                'display_name' => '设置定时发布',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 36,
                'name' => 'admin.blog.draft.schedule.delete',
                'display_name' => '删除定时发布',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);

        // 赋予角色权限
        $permission_all_ids = Permission::query()->pluck('id')->toArray();
        $theRole->permissions()->sync($permission_all_ids);


        //赋予网站管理员基本权限
        $websitePermission_ids = Permission::query()->whereNotIn('pg_id', [
            2, 3, 4, 5, 6,29,33
        ])->whereNotIn('name', [
            'admin.translateJob.index',
            'admin.menu.manager.visibility',
            'admin.setting.clearCache'
        ])->pluck('id')->toArray();
        $theWebsiteRole->permissions()->sync($websitePermission_ids);
        self::addRole();
    }


    public static function addRole()
    {
        $created_at = $updated_at = date('Y-m-d H:i:s');
        $group = PermissionGroup::query()->create([
            'name' => '管理员账号'
        ]);

        DB::table('permissions')->insert([
            [
                'pg_id' => $group->getKey(),
                'name' => 'admin.manager.index',
                'display_name' => '后台账号列表',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => $group->getKey(),
                'name' => 'admin.manager.create',
                'display_name' => '显示添加后台账号界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => $group->getKey(),
                'name' => 'admin.manager.store',
                'display_name' => '添加后台账号',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => $group->getKey(),
                'name' => 'admin.manager.edit',
                'display_name' => '显示编辑后台账号界面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => $group->getKey(),
                'name' => 'admin.manager.update',
                'display_name' => '更新后台账号',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => $group->getKey(),
                'name' => 'admin.manager.destroy',
                'display_name' => '删除后台账号',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);

//        //产品角色
        $theProductAndContentRole = Role::create([
            'name' => '内容&产品管理员',
            'guard_name' => 'web',
            'info' => '内容&产品管理员'
        ]);
//
//        $bdminUser=User::find(3);
//        $bdminUser->assignRole($theProductAndContentRole);

//        //产品角色
        $theProductRole = Role::create([
            'name' => '产品管理员',
            'guard_name' => 'web',
            'info' => '产品管理员'
        ]);

        //预发布产品角色
        $thePreProductRole = Role::create([
            'name' => '预发布产品管理员',
            'guard_name' => 'web',
            'info' => '预发布产品管理员'
        ]);
        $pre_product_permission_ids = self::getPreProductPermissionIds();
        $thePreProductRole->permissions()->sync($pre_product_permission_ids);
//        $productUser=User::find(4);
//        $productUser->assignRole($theProductRole);

//        //产品角色
        $theContentRole = Role::create([
            'name' => '内容管理员',
            'guard_name' => 'web',
            'info' => '内容管理员'
        ]);
//        $contentUser=User::find(5);
//        $contentUser->assignRole($theContentRole);

        $product_permission_ids = self::getProductPermissionIds();
//        $pre_product_permission_ids = self::getPreProductPermissionIds();
        $content_permission_ids = self::getContentPermissionIds();
        $productAndContentPermission_ids = array_unique(array_merge($product_permission_ids, $content_permission_ids));
        sort($productAndContentPermission_ids);
        //产品+内容管理员权限
        $theProductAndContentRole->permissions()->sync($productAndContentPermission_ids);

        //产品管理员权限
        $theProductRole->permissions()->sync($product_permission_ids);

        //预发布产品管理员权限
//        $preProductPermissions = Permission::whereIn('id',$pre_product_permission_ids)->get();
//        foreach ($preProductPermissions as  $permission) {
//            $thePreProductRole->givePermissionTo($permission);
//        }

//        $websiteUser=User::find(3);
//        $websiteUser->assignRole($thePreProductRole);
        //内容管理员权限
        $theContentRole->permissions()->sync($content_permission_ids);

        $theWebsiteRole = Role::query()->find(2);
        if ($theWebsiteRole) {
            //赋予网站管理员基本权限
            $websitePermission_ids = Permission::query()->whereNotIn('pg_id', [
                2, 3, 4, 5, 6,29,33
            ])->whereNotIn('name', [
                'admin.translateJob.index',
                'admin.menu.manager.visibility',
                'admin.setting.clearCache'
            ])->pluck('id')->toArray();
            $theWebsiteRole->permissions()->sync($websitePermission_ids);
        }
    }


    /**
     * 内容角色对应权限
     * @return array
     */
    public static function getContentPermissionIds()
    {
        $group_names = [
            '文章分类管理', '文章管理', '单页面管理', '系统设置管理', '下载相关', 'slogan管理', '主页',
            '博客分类管理', '博客管理', '博客关键词管理','数据管家', '文章草稿箱', '博客草稿箱'
        ];
        $permission_names = [
            'admin.menu.content.visibility', 'admin.menu.article.visibility', 'admin.menu.page.visibility',
            'admin.menu.blog.visibility', 'admin.menu.download.visibility', 'admin.menu.system.visibility', 'admin.menu.information.visibility'
        ];
        $pg_ids = DB::table('permission_groups')->select(['id'])->whereIn('name', $group_names)->pluck('id')->toArray();
        $permission_ids = DB::table('permissions')->select(['id'])->whereIn('pg_id', $pg_ids)->pluck('id')->toArray();
        $p_ids = DB::table('permissions')->select(['id'])->whereIn('name', $permission_names)->pluck('id')->toArray();
        $permission_ids = array_unique(array_merge($permission_ids, $p_ids));
        sort($permission_ids);
        //去掉系统设置里面的指定权限
        $permission_ids = Permission::query()->whereIn('id',$permission_ids)->whereNotIn('name',[
            'admin.translateJob.index',
            'admin.setting.clearCache'
        ])->pluck('id')->toArray();
        return $permission_ids;
    }


    /**
     * 产品角色对应权限
     * @return array
     */
    public static function getProductPermissionIds()
    {
        $group_names = [
            '产品分类管理', '产品品牌管理', '关键词数据管理', '产品属性管理', '产品管理', '主页', '营销管理', '相册管理','数据管家', '产品草稿箱'
        ];
        $permission_names = [
            'admin.menu.dashboard.visibility', 'admin.menu.product.visibility', 'admin.menu.marketing.visibility', 'admin.menu.information.visibility'
        ];
        $pg_ids = DB::table('permission_groups')->whereIn('name', $group_names)->pluck('id')->toArray();
        $permission_ids = DB::table('permissions')->select(['id'])->whereIn('pg_id', $pg_ids)->pluck('id')->toArray();
        $p_ids = DB::table('permissions')->select(['id'])->whereIn('name', $permission_names)->pluck('id')->toArray();
        $permission_ids = array_unique(array_merge($permission_ids, $p_ids));
        sort($permission_ids);
        return $permission_ids;
    }


    /**
     * 预发布角色对应权限
     * @return array
     */
    public static function getPreProductPermissionIds()
    {
        $group_names = [
            '产品分类管理', '产品品牌管理', '关键词数据管理', '产品属性管理', '产品管理', '主页', '相册管理','数据管家', '产品草稿箱'
        ];
        $permission_names = [
            'admin.menu.dashboard.visibility', 'admin.menu.product.visibility', 'admin.menu.information.visibility'
        ];
        $pg_ids = DB::table('permission_groups')->select(['id'])->whereIn('name', $group_names)->pluck('id')->toArray();
        $permission_ids = DB::table('permissions')->select(['id'])->whereIn('pg_id', $pg_ids)->pluck('id')->toArray();
        $p_ids = DB::table('permissions')->select(['id'])->whereIn('name', $permission_names)->pluck('id')->toArray();
        $permission_ids = array_unique(array_merge($permission_ids, $p_ids));
        sort($permission_ids);
        return $permission_ids;
    }


}
