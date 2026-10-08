<?php

namespace App\Modules\FriendLink\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendLink extends Model
{
    use HasFactory;

    public $casts = [
        'locales' => 'array'
    ];

    protected $fillable = ['url','name','path','type','locales'];
}
