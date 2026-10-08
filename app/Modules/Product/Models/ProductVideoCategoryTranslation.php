<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVideoCategoryTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'content', 'content2', 'title', 'keywords', 'description'];
}
