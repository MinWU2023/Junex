<?php

namespace App\Modules\Inquiry\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryUserRead extends Model
{
    use HasFactory;

    protected $fillable = ['inquiry_id','user_id'];
}
