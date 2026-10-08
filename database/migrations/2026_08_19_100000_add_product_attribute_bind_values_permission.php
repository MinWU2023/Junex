<?php

use App\Modules\Admin\Models\Permission;
use App\Modules\Admin\Models\PermissionGroup;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

class AddProductAttributeBindValuesPermission extends Migration
{
    public function up()
    {
        $group = PermissionGroup::query()->where('name', '产品属性管理')->first();
        $pgId = $group ? $group->id : 10;

        $permission = Permission::query()->firstOrCreate(
            ['name' => 'admin.product.attribute.bindValues', 'guard_name' => 'web'],
            [
                'display_name' => '逗号绑定产品属性值',
                'pg_id' => $pgId,
            ]
        );

        if ((int)($permission->pg_id ?? 0) === 0) {
            $permission->pg_id = $pgId;
            $permission->save();
        }

        $roleNames = Role::query()
            ->where('name', '超级管理员')
            ->pluck('id')
            ->all();

        $grantFrom = Permission::query()
            ->whereIn('name', [
                'admin.product.getAttribute',
                'admin.product.update',
                'admin.product.edit',
                'admin.product.store',
                'admin.product.attribute.update',
            ])
            ->get();

        foreach ($grantFrom as $source) {
            $roleNames = array_merge($roleNames, $source->roles()->pluck('id')->all());
        }

        Role::query()->whereIn('id', array_unique($roleNames))->get()->each(function ($role) use ($permission) {
            $role->givePermissionTo($permission);
        });

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    public function down()
    {
        $permission = Permission::query()->where('name', 'admin.product.attribute.bindValues')->first();
        if ($permission) {
            $permission->delete();
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        }
    }
}
