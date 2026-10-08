<?php

namespace App\Modules\Menu\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [

        'name', 'parent_id', 'sort', 'route', 'icon'
    ];

    public function children()
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }
}
