<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebpImage extends Model
{
    public const STATUS_PENDING = 0;
    public const STATUS_DONE = 1;
    public const STATUS_FAILED = 2;

    protected $table = 'webp_images';

    protected $fillable = [
        'path',
        'status',
        'path_webp',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
}
