<?php

namespace App\Modules\SiteCount\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteCount extends Model
{
    use HasFactory;

    protected $fillable = [

        'data', 'check_date','add_date','type'
    ];
}
