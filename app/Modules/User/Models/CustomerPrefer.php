<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPrefer extends Model
{
    use HasFactory;

    protected $table = 'customer_prefers';

    protected $fillable = [
        'customer_id',
        'product_id',
    ];
}
