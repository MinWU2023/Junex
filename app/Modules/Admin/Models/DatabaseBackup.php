<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class DatabaseBackup extends Model
{
    protected $fillable = [
        'filename',
        'filepath',
        'file_size',
        'type',
        'status',
        'message',
    ];

    protected $appends = [
        'file_size_human',
    ];

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = (int) $this->file_size;
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = (int) floor(log($bytes, 1024));
        $power = min($power, count($units) - 1);

        return round($bytes / (1024 ** $power), 2) . ' ' . $units[$power];
    }

    public function absolutePath(): string
    {
        return base_path($this->filepath);
    }

    public function fileExists(): bool
    {
        return is_file($this->absolutePath());
    }
}
