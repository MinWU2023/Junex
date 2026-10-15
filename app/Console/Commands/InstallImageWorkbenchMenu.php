<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class InstallImageWorkbenchMenu extends Command
{
    protected $signature = 'translate:install-image-workbench-menu';

    protected $description = 'Install image workbench admin menu and permission';

    public function handle(): int
    {
        $parentId = DB::table('menus')->where('route', 'admin.translateWorkbench.index')->value('parent_id');
        if (!$parentId) {
            $systemMenu = DB::table('menus')->where('route', 'admin.menu.system.visibility')->first();
            if (!$systemMenu) {
                $this->error('System menu not found.');
                return 1;
            }
            $parentId = $systemMenu->id;
        }

        $now = now()->toDateTimeString();
        DB::table('menus')->updateOrInsert(
            ['route' => 'admin.imageWorkbench.index'],
            [
                'parent_id' => $parentId,
                'sort' => 0,
                'name' => '图片工作台',
                'icon' => '',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('permissions')->updateOrInsert(
            ['name' => 'admin.imageWorkbench.index'],
            [
                'pg_id' => 16,
                'display_name' => '图片工作台',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        $role = Role::findById(1);
        $permission = Permission::where('name', 'admin.imageWorkbench.index')->first();
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $this->info('Image workbench menu installed.');
        return 0;
    }
}
