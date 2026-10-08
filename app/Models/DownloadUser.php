<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Time;

class DownloadUser extends Model
{
    use HasFactory,Time;

    protected $fillable = [
        'download_id',
        'ip',
        'ip_address',
        'download_count',
    ];
    
}
