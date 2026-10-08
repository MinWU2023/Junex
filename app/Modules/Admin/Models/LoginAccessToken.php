<?php

namespace App\Modules\Admin\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAccessToken extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','access_token','deadline_time','status'];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
