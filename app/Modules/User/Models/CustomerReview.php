<?php

namespace App\Modules\User\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = [
        'subject',
        'content',
    ];

    protected $casts = [
        'imgs' => 'array',
    ];

    protected $fillable = [
        'product',
        'subject',
        'email',
        'username',
        'content',
        'imgs',
        'score',
    ];
}
