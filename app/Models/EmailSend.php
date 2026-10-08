<?php

namespace App\Models;

use App\Traits\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSend extends Model
{
    use HasFactory,Time;

    protected $fillable = ['subject','content','to_email','cc_emails','reply_to','fail_num',
        'from_email','error_message','status','type','source_id',
        'is_fail_send'
    ];

}
