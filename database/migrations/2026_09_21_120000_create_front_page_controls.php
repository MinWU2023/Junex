<?php

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('front_page_controls')) {
            Schema::create('front_page_controls', function (Blueprint $table) {
                $table->id();
                $table->string('path', 255)->unique()->comment('前台路径，首页为空字符串');
                $table->string('name', 255)->default('')->comment('展示名称');
                $table->boolean('sitemap_on')->default(1)->comment('是否加入 sitemap');
                $table->boolean('access_on')->default(1)->comment('是否允许前台访问');
                $table->timestamps();
            });
        }

        $this->installMenu();
    }

    public function down(): void
    {
        Schema::dropIfExists('front_page_controls');
    }

    private function installMenu(): void
    {
        if (!Schema::hasTable('menus')) {
            return;
        }

        $parent = Menu::query()
            ->where(function ($q) {
                $q->where('route', 'admin.menu.page.visibility')
                    ->orWhere('name', '页面');
            })
            ->first();

        if ($parent) {
            $route = 'admin.frontPageList.index';
            $menu = Menu::query()->where('route', $route)->first();
            if (!$menu) {
                Menu::query()->create([
                    'parent_id' => $parent->id,
                    'name' => '页面列表',
                    'route' => $route,
                    'sort' => 1,
                    'icon' => '',
                ]);
            } else {
                $menu->parent_id = $parent->id;
                $menu->name = '页面列表';
                $menu->save();
            }
        }

        if (!Schema::hasTable('permissions')) {
            return;
        }

        $group = PermissionGroup::query()->firstOrCreate(['name' => '页面列表']);
        $permissions = [
            'admin.frontPageList.index' => '页面列表',
            'admin.frontPageList.batch' => '页面列表批量设置',
            'admin.frontPageList.toggle' => '页面列表单项设置',
            'admin.frontPageList.sitemap' => '生成 sitemap',
        ];
        $now = now();
        foreach ($permissions as $name => $displayName) {
            $permission = Permission::query()->where('name', $name)->first();
            if (!$permission) {
                Permission::query()->create([
                    'name' => $name,
                    'display_name' => $displayName,
                    'guard_name' => 'web',
                    'pg_id' => $group->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $role = Role::query()->where('name', '超级管理员')->first();
        if ($role) {
            $role->givePermissionTo(array_keys($permissions));
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
