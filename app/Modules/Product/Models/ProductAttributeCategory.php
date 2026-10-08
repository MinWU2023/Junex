<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function attributes(){
        return $this->belongsToMany(ProductAttribute::class);
    }

}
