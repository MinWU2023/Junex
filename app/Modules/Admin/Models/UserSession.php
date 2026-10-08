<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'token', 'deadline_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
