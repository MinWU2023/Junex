<?php

namespace App\Modules\Admin\Models;

use Spatie\Permission\Models\Permission as PermissionBase;

class Permission extends PermissionBase
{
    public function permissionGroup()
    {
        return $this->belongsTo(PermissionGroup::class, 'pg_id');
    }
}
