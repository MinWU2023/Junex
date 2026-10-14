<?php

namespace App\Console\Commands;

use App\Modules\Admin\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class InstallTranslateWorkbenchMenu extends Command
{
    protected $signature = 'translate:install-workbench-menu';

    protected $description = 'Install translate workbench admin menu and permission';

    public function handle(): int
    {
        $systemMenu = DB::table('menus')->where('route', 'admin.menu.system.visibility')->first();
        if (!$systemMenu) {
            $this->error('System menu not found.');
            return 1;
        }

        $now = now()->toDateTimeString();
        DB::table('menus')->updateOrInsert(
            ['route' => 'admin.translateWorkbench.index'],
            [
                'parent_id' => $systemMenu->id,
                'sort' => 0,
                'name' => '翻译工作台',
                'icon' => '',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('permissions')->updateOrInsert(
            ['name' => 'admin.translateWorkbench.index'],
            [
                'pg_id' => 16,
                'display_name' => '翻译工作台',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        $role = Role::findById(1);
        $permission = Permission::where('name', 'admin.translateWorkbench.index')->first();
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $this->info('Translate workbench menu installed.');
        return 0;
    }
}
