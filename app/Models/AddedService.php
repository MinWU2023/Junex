<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Time;
class AddedService extends Model
{
    use HasFactory,Time;

    protected $fillable = [
        'name',
        'description',
        'price',
        'active',
        'is_show',
        'source_id',
    ];
}
