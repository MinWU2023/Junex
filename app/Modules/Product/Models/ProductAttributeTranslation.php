<?php


namespace App\Modules\Product\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeTranslation  extends Model
{
    use HasFactory;

    protected $table = 'product_attr_translations';

    public $timestamps = false;

    protected $fillable = ['name'];
}
