<?php

namespace App\Modules\Inquiry\Models;

use App\Modules\Admin\Models\User;
use App\Traits\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory,Time;

    protected $fillable = [
        'email'
    ];

    public function reads(){
        return $this->belongsToMany(User::class);
    }

}
