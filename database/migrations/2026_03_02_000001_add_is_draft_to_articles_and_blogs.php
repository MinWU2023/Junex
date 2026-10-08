<?php

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class AddIsDraftToArticlesAndBlogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('is_draft')->default(0)->comment('是否为草稿：0-否，1-是')->after('is_temp');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->boolean('is_draft')->default(0)->comment('是否为草稿：0-否，1-是')->after('is_temp');
        });
        
        Schema::create('article_scheduled_publishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id')->comment('文章ID');
            $table->timestamp('publish_at')->comment('计划发布时间');
            $table->timestamps();

            $table->foreign('article_id')
                  ->references('id')
                  ->on('articles')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->index('publish_at');
            $table->unique('article_id');
        });
        
        Schema::create('blog_scheduled_publishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_id')->comment('博客ID');
            $table->timestamp('publish_at')->comment('计划发布时间');
            $table->timestamps();

            $table->foreign('blog_id')
                  ->references('id')
                  ->on('blogs')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->index('publish_at');
            $table->unique('blog_id');
        });

        if (DB::table('settings')->first()) {
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            // 创建文章草稿箱权限组
            $add = [];
            $add['name'] = '文章草稿箱';
            $articlePermissionGroup = PermissionGroup::where('name', '文章草稿箱')->first();
            if (empty($articlePermissionGroup)) {
                $articlePermissionGroup = PermissionGroup::create($add);
            }

            // 文章草稿箱权限
            $articlePermissions = [
                [
                    'pg_id' => $articlePermissionGroup->id,
                    'name' => 'admin.article.draft.index',
                    'display_name' => '文章草稿列表',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $articlePermissionGroup->id,
                    'name' => 'admin.article.draft.edit',
                    'display_name' => '显示文章草稿界面',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $articlePermissionGroup->id,
                    'name' => 'admin.article.draft.update',
                    'display_name' => '更新文章草稿',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $articlePermissionGroup->id,
                    'name' => 'admin.article.draft.destroy',
                    'display_name' => '文章草稿删除',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $articlePermissionGroup->id,
                    'name' => 'admin.article.draft.schedule',
                    'display_name' => '设置定时发布',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $articlePermissionGroup->id,
                    'name' => 'admin.article.draft.schedule.delete',
                    'display_name' => '删除定时发布',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
            ];

            // 创建博客草稿箱权限组
            $add['name'] = '博客草稿箱';
            $blogPermissionGroup = PermissionGroup::where('name', '博客草稿箱')->first();
            if (empty($blogPermissionGroup)) {
                $blogPermissionGroup = PermissionGroup::create($add);
            }

            // 博客草稿箱权限
            $blogPermissions = [
                [
                    'pg_id' => $blogPermissionGroup->id,
                    'name' => 'admin.blog.draft.index',
                    'display_name' => '博客草稿列表',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $blogPermissionGroup->id,
                    'name' => 'admin.blog.draft.edit',
                    'display_name' => '显示博客草稿界面',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $blogPermissionGroup->id,
                    'name' => 'admin.blog.draft.update',
                    'display_name' => '更新博客草稿',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $blogPermissionGroup->id,
                    'name' => 'admin.blog.draft.destroy',
                    'display_name' => '博客草稿删除',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $blogPermissionGroup->id,
                    'name' => 'admin.blog.draft.schedule',
                    'display_name' => '设置定时发布',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
                [
                    'pg_id' => $blogPermissionGroup->id,
                    'name' => 'admin.blog.draft.schedule.delete',
                    'display_name' => '删除定时发布',
                    'guard_name' => 'web',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ],
            ];

            // 添加文章草稿箱菜单
            $articleMenu = Menu::where('route', 'admin.article.index')->first();
            if ($articleMenu) {
                DB::table('menus')->insert([
                    'parent_id' => $articleMenu->parent_id,
                    'sort' => $articleMenu->sort + 1,
                    'name' => '文章草稿箱',
                    'route' => 'admin.article.draft.index',
                    'icon' => '',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ]);
            }

            // 添加博客草稿箱菜单
            $blogMenu = Menu::where('route', 'admin.blog.index')->first();
            if ($blogMenu) {
                DB::table('menus')->insert([
                    'parent_id' => $blogMenu->parent_id,
                    'sort' => $blogMenu->sort + 1,
                    'name' => '博客草稿箱',
                    'route' => 'admin.blog.draft.index',
                    'icon' => '',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ]);
            }

            // 为角色分配权限
            $roles = Role::whereIn('id', [1, 2, 3, 4, 5])->get();
            
            // 插入文章权限
            foreach ($articlePermissions as $permission) {
                DB::table('permissions')
                    ->updateOrInsert(['name' => $permission['name'], 'pg_id' => $permission['pg_id']], $permission);
                $permissionModel = Permission::where('name', $permission['name'])->first();
                foreach ($roles as $role) {
                    $role->givePermissionTo($permissionModel);
                }
            }

            // 插入博客权限
            foreach ($blogPermissions as $permission) {
                DB::table('permissions')
                    ->updateOrInsert(['name' => $permission['name'], 'pg_id' => $permission['pg_id']], $permission);
                $permissionModel = Permission::where('name', $permission['name'])->first();
                foreach ($roles as $role) {
                    $role->givePermissionTo($permissionModel);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_scheduled_publishes');
        Schema::dropIfExists('blog_scheduled_publishes');

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('is_draft');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('is_draft');
        });

        // 删除权限和菜单
        $roles = Role::whereIn('id', [1, 2, 3, 4, 5])->get();
        
        // 删除文章草稿箱权限
        $articlePermissions = Permission::whereIn('name', [
            'admin.article.draft.index',
            'admin.article.draft.edit',
            'admin.article.draft.update',
            'admin.article.draft.destroy',
            'admin.article.draft.schedule',
            'admin.article.draft.schedule.delete',
        ])->get();
        
        foreach ($articlePermissions as $permission) {
            foreach ($roles as $role) {
                $role->revokePermissionTo($permission->name);
            }
            $permission->delete();
        }

        // 删除博客草稿箱权限
        $blogPermissions = Permission::whereIn('name', [
            'admin.blog.draft.index',
            'admin.blog.draft.edit',
            'admin.blog.draft.update',
            'admin.blog.draft.destroy',
            'admin.blog.draft.schedule',
            'admin.blog.draft.schedule.delete',
        ])->get();
        
        foreach ($blogPermissions as $permission) {
            foreach ($roles as $role) {
                $role->revokePermissionTo($permission->name);
            }
            $permission->delete();
        }

        // 删除菜单
        DB::table('menus')->where('route', 'admin.article.draft.index')->delete();
        DB::table('menus')->where('route', 'admin.blog.draft.index')->delete();
        
        // 删除权限组
        DB::table('permission_groups')->where('name', '文章草稿箱')->delete();
        DB::table('permission_groups')->where('name', '博客草稿箱')->delete();
    }
}

