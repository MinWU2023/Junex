<?php

namespace App\Modules\Inquiry\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryAttachment extends Model
{
    protected $fillable = [
        'inquiry_id',
        'original_name',
        'stored_name',
        'path',
        'mime',
        'extension',
        'size',
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function getPublicUrlAttribute(): string
    {
        $path = ltrim((string)$this->path, '/');
        return '/' . $path;
    }

    public function getAbsolutePathAttribute(): string
    {
        return public_path(ltrim((string)$this->path, '/'));
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = (int)$this->size;
        if ($bytes < 1024) {
            return $bytes . ' B';
        }
        if ($bytes < 1048576) {
            return round($bytes / 1024, 1) . ' KB';
        }
        return round($bytes / 1048576, 2) . ' MB';
    }

    public function existsOnDisk(): bool
    {
        $abs = $this->absolute_path;
        return $abs !== '' && is_file($abs);
    }
}
