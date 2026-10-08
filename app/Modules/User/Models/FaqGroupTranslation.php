<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqGroupTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'content',
    ];
}
