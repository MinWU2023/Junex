<?php

namespace App\Services;

/**
 * WebP 路径命名规则（不查库，前后端/命令共用）：
 * 原图 /front/imgs/a.png  → /webps/front/imgs/a.webp
 * 原图 /storage/x/b.jpg   → /webps/storage/x/b.webp
 * 即：public/webps/ + 原相对路径（去掉扩展名）+ .webp
 */
class WebpImageService
{
    public const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

    /**
     * 前台可能展示的图片目录（相对 public/）。
     * 后台上传：FileUpload → public/storage/uploads/…；UEditor disk=storage → 同目录下 uploads/image/…
     * 静态资源：front/、images/、pages/、pre/ 等。
     */
    public const FRONT_IMAGE_PUBLIC_ROOTS = [
        'front',       // 前台静态图 /front/imgs、/front/icons
        'images',      // 站点通用图 /images/…
        'pages',       // 落地页素材 /pages/…
        'pre',         // 预览/过渡页 /pre/…
        'uploads',     // 部分编辑器直传 public/uploads（ueditor 配置路径）
        '3dbottle',    // 前台 3D/展示素材
        'report',      // 报表页若挂前台也会用到
    ];

    /**
     * 在已纳入的扫描根目录内部，仍要跳过的子目录名（编辑器/依赖包等，非业务图）。
     * 注意：不再全局跳过 storage——上传图就在 storage 下，见 CollectImagesCommand。
     */
    public const SKIP_DIR_NAMES = [
        'webps',
        'vendor',
        'node_modules',
        'tinymce',
        'ueditor',
        'ckeditor',
        'kindeditor',
        '.git',
    ];

    /**
     * 规范化为站点相对路径：/front/xxx.png
     */
    public static function normalizeSitePath(?string $path): string
    {
        $path = trim((string)$path);
        if ($path === '') {
            return '';
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, 'data:')) {
            return $path;
        }
        $path = preg_replace('#^/+#', '', $path) ?? $path;
        if ($path === '') {
            return '';
        }
        return '/' . str_replace('\\', '/', $path);
    }

    /**
     * 由原图站点路径推导 webp 站点路径（纯命名规则）。
     */
    public static function webpSitePathFromOriginal(?string $originalSitePath): string
    {
        $original = self::normalizeSitePath($originalSitePath);
        if ($original === '' || str_starts_with($original, 'http') || str_starts_with($original, 'data:')) {
            return '';
        }

        $rel = ltrim($original, '/');
        if ($rel === '' || str_starts_with($rel, 'webps/')) {
            return '';
        }

        $dir = str_replace('\\', '/', dirname($rel));
        $name = pathinfo($rel, PATHINFO_FILENAME);
        if ($name === '') {
            return '';
        }

        $webpRel = ($dir === '.' || $dir === '')
            ? 'webps/' . $name . '.webp'
            : 'webps/' . $dir . '/' . $name . '.webp';

        $webpRel = preg_replace('#/+#', '/', $webpRel) ?? $webpRel;
        return '/' . ltrim($webpRel, '/');
    }

    /**
     * 原图绝对路径（磁盘）。
     *
     * /storage/xxx 在本项目可能落在两处：
     * - public/storage/xxx（FileUpload / UEditor disk=storage，宝塔上常为真实目录）
     * - storage/app/public/xxx（Laravel 标准 storage:link）
     * 哪个文件存在用哪个；都不存在时优先返回 public/storage（与上传写入一致）。
     */
    public static function absolutePathFromSitePath(string $sitePath): string
    {
        $rel = ltrim(str_replace('\\', '/', $sitePath), '/');

        if (str_starts_with($rel, 'storage/')) {
            $inner = substr($rel, strlen('storage/'));
            $candidates = [
                public_path('storage/' . $inner),
                storage_path('app/public/' . $inner),
            ];
            foreach ($candidates as $candidate) {
                if (is_file($candidate)) {
                    return $candidate;
                }
            }
            // 默认与 FileUploadService 写入位置一致，便于报错对照
            return $candidates[0];
        }

        return public_path($rel);
    }

    /**
     * webp 绝对路径（始终在 public/webps 下）。
     */
    public static function absoluteWebpPathFromSitePath(string $webpSitePath): string
    {
        $rel = ltrim(str_replace('\\', '/', $webpSitePath), '/');
        return public_path($rel);
    }

    public static function isConvertibleImagePath(string $path): bool
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($ext, self::IMAGE_EXTENSIONS, true);
    }

    /**
     * 前台展示：若对应 webp 文件存在则返回 webp，否则原图。不查库。
     */
    public static function preferWebpUrl(?string $src): string
    {
        static $cache = [];

        $src = trim((string)$src);
        if ($src === '') {
            return '';
        }
        if (str_starts_with($src, 'http://') || str_starts_with($src, 'https://') || str_starts_with($src, 'data:')) {
            return $src;
        }

        $original = self::normalizeSitePath($src);
        if ($original === '') {
            return '';
        }
        if (array_key_exists($original, $cache)) {
            return $cache[$original];
        }

        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        if ($ext === 'webp' || $ext === 'svg' || $ext === 'ico') {
            return $cache[$original] = $original;
        }

        $webp = self::webpSitePathFromOriginal($original);
        if ($webp === '') {
            return $cache[$original] = $original;
        }

        $abs = self::absoluteWebpPathFromSitePath($webp);
        if (is_file($abs)) {
            return $cache[$original] = $webp;
        }

        return $cache[$original] = $original;
    }

    /**
     * 将 HTML 中 img[src]、style/background 的 url(...) 按命名规则替换为 webp（不查库）。
     */
    public static function rewriteHtmlImagesToWebp(string $html): string
    {
        $html = (string)$html;
        if ($html === '') {
            return '';
        }

        if (stripos($html, '<img') !== false || stripos($html, 'src=') !== false) {
            $html = preg_replace_callback(
                '/(<img\b[^>]*?\bsrc\s*=\s*)([\'"])([^\'"]*)\2/i',
                static function (array $m): string {
                    $replaced = self::rewriteSrcValue($m[3]);
                    if ($replaced === null) {
                        return $m[0];
                    }
                    return $m[1] . $m[2] . htmlspecialchars($replaced, ENT_QUOTES | ENT_HTML5, 'UTF-8') . $m[2];
                },
                $html
            ) ?? $html;
        }

        if (stripos($html, 'url(') !== false) {
            $html = preg_replace_callback(
                '/url\(\s*([\'"]?)([^\'"\)]+)\1\s*\)/i',
                static function (array $m): string {
                    $raw = trim($m[2]);
                    // 跳过 data / 渐变占位
                    if ($raw === '' || str_starts_with(strtolower($raw), 'data:')) {
                        return $m[0];
                    }
                    $replaced = self::rewriteSrcValue($raw);
                    if ($replaced === null) {
                        return $m[0];
                    }
                    $quote = $m[1] !== '' ? $m[1] : "'";
                    return 'url(' . $quote . $replaced . $quote . ')';
                },
                $html
            ) ?? $html;
        }

        return $html;
    }

    /**
     * @return string|null 有替换时返回新路径；无需替换返回 null
     */
    public static function rewriteSrcValue(string $src): ?string
    {
        $src = html_entity_decode(trim($src), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if ($src === '' || str_starts_with(strtolower($src), 'data:')) {
            return null;
        }

        $sitePath = $src;
        $prefix = '';

        // 同站绝对 URL：取出 path 再匹配
        $parts = parse_url($src);
        if (!empty($parts['host']) && isset($parts['path'])) {
            $prefix = (isset($parts['scheme']) ? $parts['scheme'] . ':' : '') . '//' . $parts['host']
                . (isset($parts['port']) ? ':' . $parts['port'] : '');
            $sitePath = (string)$parts['path'];
            if (!empty($parts['query'])) {
                $sitePath .= '?' . $parts['query'];
            }
        }

        $pathOnly = $sitePath;
        $query = '';
        if (str_contains($pathOnly, '?')) {
            [$pathOnly, $query] = explode('?', $pathOnly, 2);
            $query = '?' . $query;
        }
        if (str_contains($pathOnly, '#')) {
            $pathOnly = explode('#', $pathOnly, 2)[0];
        }

        $preferred = self::preferWebpUrl($pathOnly);
        $normalized = self::normalizeSitePath($pathOnly);
        if ($preferred === '' || $preferred === $normalized) {
            return null;
        }

        if (str_starts_with($preferred, 'http://') || str_starts_with($preferred, 'https://')) {
            return null;
        }

        if ($prefix !== '') {
            return $prefix . $preferred . $query;
        }

        return $preferred . $query;
    }
}
