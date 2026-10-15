<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        if (!DB::table('settings')->exists()) {
            return;
        }

        $createdAt = now()->toDateTimeString();
        $parent = DB::table('menus')->where('route', 'admin.translateWorkbench.index')->first()
            ?: DB::table('menus')->where('route', 'admin.menu.system.visibility')->first();
        if (!$parent) {
            return;
        }

        $parentId = DB::table('menus')->where('route', 'admin.translateWorkbench.index')->value('parent_id')
            ?: $parent->id;

        DB::table('menus')->updateOrInsert(
            ['route' => 'admin.imageWorkbench.index'],
            [
                'parent_id' => $parentId,
                'sort' => 0,
                'name' => '图片工作台',
                'icon' => '',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]
        );

        DB::table('permissions')->updateOrInsert(
            ['name' => 'admin.imageWorkbench.index'],
            [
                'pg_id' => 16,
                'display_name' => '图片工作台',
                'guard_name' => 'web',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]
        );

        $role = Role::findById(1);
        $permission = \App\Modules\Admin\Models\Permission::where('name', 'admin.imageWorkbench.index')->first();
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }
    }

    public function down(): void
    {
        DB::table('menus')->where('route', 'admin.imageWorkbench.index')->delete();
        DB::table('permissions')->where('name', 'admin.imageWorkbench.index')->delete();
    }
};
