<?php
namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasFactory;

    protected $fillable = ['sort', 'path','name','parent_id'];

    protected $appends = ['product_count'];



    public function getProductCountAttribute($value){
        $id = $this->id;
        return Product::query()->where('product_brand_id',$id)->active()->count();
    }

    public function children()
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id', 'id');
    }

    public function getCreatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

}
