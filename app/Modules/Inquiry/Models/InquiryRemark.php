<?php

namespace App\Modules\Inquiry\Models;

use App\Modules\Admin\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryRemark extends Model
{
    use HasFactory;
    protected $fillable = [

        'admin_user_id', 'inquiry_id', 'content'

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'admin_user_id', 'id');
    }

    public function getCreatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }
}
