<?php

namespace App\Services;

/**
 * 同步 public/ 下的静态缓存开关标记，供 Nginx if (-f ...) 判断。
 */
class StaticAssetCacheService
{
    public function enabled(): bool
    {
        return (bool)config('static_cache.enabled', false);
    }

    public function maxAge(): int
    {
        return max(60, (int)config('static_cache.max_age', 31536000));
    }

    /**
     * @return string[]
     */
    public function extensions(): array
    {
        $ext = config('static_cache.extensions', []);
        return is_array($ext) ? array_values(array_filter(array_map('strtolower', $ext))) : [];
    }

    public function markerRelative(): string
    {
        $name = trim((string)config('static_cache.marker', '.static-asset-cache-on'), '/\\');
        return $name !== '' ? $name : '.static-asset-cache-on';
    }

    public function markerAbsolute(): string
    {
        return public_path($this->markerRelative());
    }

    public function markerExists(): bool
    {
        return is_file($this->markerAbsolute());
    }

    /**
     * 按 .env / config 同步标记文件。
     *
     * @return string created|removed|unchanged_on|unchanged_off
     */
    public function syncMarker(): string
    {
        $path = $this->markerAbsolute();
        $enabled = $this->enabled();
        $exists = is_file($path);

        if ($enabled) {
            if ($exists) {
                return 'unchanged_on';
            }
            $dir = dirname($path);
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
            $body = "STATIC_ASSET_CACHE_ENABLED=true\nmax_age=" . $this->maxAge() . "\n";
            if (@file_put_contents($path, $body) === false) {
                throw new \RuntimeException('无法写入静态缓存标记文件: ' . $path);
            }
            return 'created';
        }

        if ($exists) {
            if (!@unlink($path)) {
                throw new \RuntimeException('无法删除静态缓存标记文件: ' . $path);
            }
            return 'removed';
        }

        return 'unchanged_off';
    }

    public function isStaticRequestPath(?string $path): bool
    {
        $path = strtolower((string)$path);
        if ($path === '') {
            return false;
        }
        // 去掉 query
        if (str_contains($path, '?')) {
            $path = explode('?', $path, 2)[0];
        }
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if ($ext === '') {
            return false;
        }
        return in_array($ext, $this->extensions(), true);
    }

    public function cacheControlHeader(): string
    {
        $maxAge = $this->maxAge();
        return 'public, max-age=' . $maxAge . ', immutable';
    }
}
