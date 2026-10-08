<?php

namespace App\Models;

use App\Traits\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexLink extends Model
{
    use HasFactory,Time;

    protected $fillable = [
        'link','status','collected_date','type'
    ];
}
