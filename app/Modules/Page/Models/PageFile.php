<?php

namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id', 'name', 'path', 'sort'
    ];
}
