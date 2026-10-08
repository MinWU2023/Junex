<?php

namespace App\Libs\LaravelWebp\src;

use App\Libs\LaravelWebp\src\Exceptions\ImageMimeNotSupportedException;
use App\Libs\LaravelWebp\src\Interfaces\WebpInterface;
use App\Libs\LaravelWebp\src\Traits\WebpTrait;
use Illuminate\Support\Facades\File;

class PhpGD implements WebpInterface
{
    use WebpTrait;

    /**
     * @param string $outputPath
     * @param int|null $quality
     * @return bool
     * @throws ImageMimeNotSupportedException
     */
    public function save(string $outputPath, int $quality = null): bool
    {
        $quality = $quality ?? $this->quality;
        $path = $this->image->path();
        $info = getimagesize($path);
        $isAlpha = false;

        switch ($info['mime']) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($path);
                break;
            case 'image/gif':
                $isAlpha = true;
                $image = imagecreatefromgif($path);
                break;
            case 'image/png':
                $isAlpha = true;
                $image = imagecreatefrompng($path);
                break;
            default:
                throw new ImageMimeNotSupportedException('Image mime type' . $info['mime'] . 'is not supported.');
        }

        if ($isAlpha) {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        imagewebp($image, $outputPath, $quality);

        return File::exists($outputPath);
    }
}
