<?php

namespace App\Modules\Admin\Models;

use App\Models\LoginLog;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\LaraPersonate\Models\Impersonate;
use App\Modules\Product\Models\Product;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Impersonate;


    protected $guard_name = 'web';

    const ALLOW_ADMIN_ID = [1,2];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'is_send',
        'login_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        //   'profile_photo_url',
    ];


    public function liveChatSession()
    {
        return $this->hasOne(LiveChatSession::class);
    }

    public function inquiries(){
        return $this->belongsToMany(Inquiry::class);
    }

    public function canImpersonate(): bool
    {
        // example usage with laratrust package
        return in_array($this->id, [1]);
    }

    public function logs(){
        return $this->hasMany(LoginLog::class,'user_id','id');
    }

    public function products(){
        return $this->hasMany(Product::class,'admin_user_id','id');
    }


}
