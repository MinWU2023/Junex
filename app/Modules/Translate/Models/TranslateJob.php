<?php

namespace App\Modules\Translate\Models;

use App\Traits\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslateJob extends Model
{
    use HasFactory,Time;

    protected $fillable = [
        'source_id','model','default_locale','translate_locales',
        'content','result_content','status',
        'error_msg','error_at','model_type','field',
    ];

}
