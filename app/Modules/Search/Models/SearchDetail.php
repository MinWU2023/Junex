<?php

namespace App\Modules\Search\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'search_id', 'type', 'name', 'active', 'created_at', 'updated_at'
    ];
}
