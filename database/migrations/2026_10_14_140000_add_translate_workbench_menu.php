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
        $systemMenu = DB::table('menus')->where('route', 'admin.menu.system.visibility')->first();
        if (!$systemMenu) {
            return;
        }

        DB::table('menus')->updateOrInsert(
            ['route' => 'admin.translateWorkbench.index'],
            [
                'parent_id' => $systemMenu->id,
                'sort' => 0,
                'name' => '翻译工作台',
                'icon' => '',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]
        );

        DB::table('permissions')->updateOrInsert(
            ['name' => 'admin.translateWorkbench.index'],
            [
                'pg_id' => 16,
                'display_name' => '翻译工作台',
                'guard_name' => 'web',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]
        );

        $role = Role::findById(1);
        $permission = \App\Modules\Admin\Models\Permission::where('name', 'admin.translateWorkbench.index')->first();
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }
    }

    public function down(): void
    {
        DB::table('menus')->where('route', 'admin.translateWorkbench.index')->delete();
        DB::table('permissions')->where('name', 'admin.translateWorkbench.index')->delete();
    }
};
