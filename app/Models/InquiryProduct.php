<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Product\Models\Product;

class InquiryProduct extends Model
{
    use HasFactory;

    protected $table = 'inquiry_products';

    protected $fillable = [
        'inquiry_id',
        'product_id',
        'quantity',
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
