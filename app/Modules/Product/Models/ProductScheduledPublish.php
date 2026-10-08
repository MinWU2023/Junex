<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductScheduledPublish extends Model
{
    protected $table = 'product_scheduled_publishes';

    protected $fillable = [
        'product_id',
        'publish_at',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
    ];

    /**
     * 关联产品
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
