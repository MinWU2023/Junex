<?php

namespace App\Models;

use App\Modules\Admin\Models\User;
use App\Traits\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id','finally_at','ip'
    ];

    public static function login(){
        User::query()->where('id',auth()->user()->id)->update([
            'last_login_at' =>  date('Y-m-d H:i:s')
        ]);
        LoginLog::query()->create([
            'user_id' => \auth()->user()->id,
            'finally_at' => date('Y-m-d H:i:s'),
            'ip' => GetUserIP()
        ]);
    }

}
