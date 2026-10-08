<?php

namespace App\Modules\Article\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategoryTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name','content', 'title', 'keywords', 'description'];
}
