<?php

namespace App\Modules\Admin\Models;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function permission()
    {
        return $this->hasMany(Permission::class, 'pg_id');
    }
}
