<?php


namespace App\Modules\Product\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryTranslation  extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'content', 'content2', 'page_block', 'title', 'keywords', 'description'];
}
