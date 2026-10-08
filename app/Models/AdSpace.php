<?php

namespace App\Models;

use App\Traits\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdSpace extends Model
{
    use HasFactory,Time;

    protected $fillable = [
        'name','img','url','is_show','sort'
    ];
}
