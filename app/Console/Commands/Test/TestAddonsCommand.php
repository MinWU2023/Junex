<?php

namespace App\Console\Commands\Test;

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Menu\Models\Menu;
use App\Services\AddonsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class TestAddonsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:addons {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test addons';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(AddonsService $addonService)
    {
        $addon_name = 'ArticleSync';
        switch ($this->argument('action')) {
            case 'install':
                $addonService->enabled($addon_name);
                $addonService->install($addon_name);
                break;
            case 'uninstall':
                $addonService->disabled($addon_name);
                $addonService->uninstall($addon_name);
                break;
        }
    }


    public static function addPermissions($menu_data, $permissions)
    {
        foreach ($menu_data as $menu_datum) {
            if ($menu_datum['parent_name']) {
                $parent_menu =   Menu::query()->where('name', $menu_datum['parent_name'])->first();
                if ($parent_menu) {
                    $menu_datum['parent_id'] = $parent_menu->getKey();
                }
            }
            unset($menu_datum['parent_name']);
            Menu::query()->create($menu_datum);
        }

        foreach ($permissions as $permission) {
            $permission['pg_id'] = 0;
            if ($permission['pg_name']) {
                $pg_permission = PermissionGroup::query()->where('name', $permission['pg_name'])->first();
                if ($pg_permission) {
                    $permission['pg_id'] = $pg_permission->getKey();
                } else {
                    $pg_permission = PermissionGroup::query()->create([
                        'name' => $permission['pg_name'],
                    ]);
                    $permission['pg_id'] = $pg_permission->getKey();
                }
            }
            unset($permission['pg_name']);
            $add_permission = Permission::query()->create($permission);
            $roles = Role::whereIn('id', [1, 2])->get();
            foreach ($roles as $role) {
                $role->givePermissionTo($add_permission);
            }
        }
    }
}
