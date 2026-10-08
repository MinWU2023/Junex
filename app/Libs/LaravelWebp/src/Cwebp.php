<?php

namespace App\Libs\LaravelWebp\src;

use App\Libs\LaravelWebp\src\Exceptions\CwebpShellExecutionFailed;
use App\Libs\LaravelWebp\src\Interfaces\WebpInterface;
use App\Libs\LaravelWebp\src\Traits\WebpTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class Cwebp implements WebpInterface
{
    use WebpTrait;

    /**
     * @var string
     */
    protected $cwebpPath;

    /**
     * Cwebp constructor.
     */
    public function __construct()
    {
        $this->cwebpPath = Config::get('laravel-webp.drivers.cwebp.path');
    }

    /**
     * @param string $outputPath
     * @param int|null $quality
     * @return bool
     * @throws CwebpShellExecutionFailed
     */
    public function save(string $outputPath, int $quality = null): bool
    {
        $quality = $quality ?? $this->quality;
        $cmd = escapeshellarg($this->cwebpPath) . ' -q ' . intval($quality) . ' ' . escapeshellarg($this->image->getPathname()) . ' -o ' . escapeshellarg($outputPath);

        exec($cmd, $output, $exitCode);

        if ($exitCode !== 0) {
            throw new CwebpShellExecutionFailed($cmd, $output, $exitCode);
        }

        return File::exists($outputPath);
    }
}
