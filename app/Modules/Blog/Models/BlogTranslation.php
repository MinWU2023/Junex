<?php
namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name','content', 'title', 'keywords', 'description'];
}
