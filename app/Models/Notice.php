<?php

namespace App\Models;

use App\Traits\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory,Time;

    protected $fillable = [
        'title','content','sort','is_top','is_show','open_show'
    ];
}
