<?php

namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{

    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'brief_content', 'content', 'title', 'keywords', 'description'];
}
