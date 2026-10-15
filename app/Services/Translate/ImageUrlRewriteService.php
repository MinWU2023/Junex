<?php

namespace App\Services\Translate;

class ImageUrlRewriteService
{
    public const DEFAULT_DOMAIN = 'https://minge2601.dyyweb.com';

    /**
     * @return array{text:string,count:int,replacements:array<int,array{from:string,to:string}>}
     */
    public function rewrite(string $content, string $domain = self::DEFAULT_DOMAIN): array
    {
        $host = $this->extractHost($domain);
        if ($host === '' || $content === '') {
            return ['text' => $content, 'count' => 0, 'replacements' => []];
        }

        $replacements = [];
        $text = $content;

        // src="..." / src='...'
        $text = preg_replace_callback(
            '/(\bsrc\s*=\s*)([\'"])([^\'"]+)\2/iu',
            function (array $m) use ($host, &$replacements) {
                $converted = $this->toRelativePath($m[3], $host);
                if ($converted === null || $converted === $m[3]) {
                    return $m[0];
                }
                $replacements[] = ['from' => $m[3], 'to' => $converted];

                return $m[1] . $m[2] . $converted . $m[2];
            },
            $text
        ) ?? $text;

        // style="... background(-image): ... url(...)"
        $text = preg_replace_callback(
            '/(\bstyle\s*=\s*)([\'"])(.*?)\2/ius',
            function (array $m) use ($host, &$replacements) {
                $style = $this->rewriteStyleUrls((string) $m[3], $host, $replacements);

                return $m[1] . $m[2] . $style . $m[2];
            },
            $text
        ) ?? $text;

        return [
            'text' => $text,
            'count' => count($replacements),
            'replacements' => $replacements,
        ];
    }

    /**
     * @param  array<int,array{from:string,to:string}>  $replacements
     */
    protected function rewriteStyleUrls(string $style, string $host, array &$replacements): string
    {
        $rewritten = preg_replace_callback(
            '/(\b(?:background(?:-image)?)\s*:[^;]*?\burl\s*\(\s*)([\'"]?)([^\'"\s\)]+)\2(\s*\))/iu',
            function (array $m) use ($host, &$replacements) {
                $converted = $this->toRelativePath($m[3], $host);
                if ($converted === null || $converted === $m[3]) {
                    return $m[0];
                }
                $replacements[] = ['from' => $m[3], 'to' => $converted];
                $quote = $m[2] ?? '';

                return $m[1] . $quote . $converted . $quote . $m[4];
            },
            $style
        );

        return is_string($rewritten) ? $rewritten : $style;
    }

    /**
     * 若 URL 属于指定域名，返回以 / 开头且无重复 // 的相对路径；否则返回 null。
     */
    public function toRelativePath(string $url, string $host): ?string
    {
        $raw = trim(html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if ($raw === '') {
            return null;
        }

        $host = strtolower($host);
        $normalized = $raw;

        // protocol-relative
        if (str_starts_with($normalized, '//')) {
            $normalized = 'https:' . $normalized;
        }

        if (!preg_match('#^https?://#i', $normalized)) {
            // 已是相对路径：仅规范化开头多余 /
            if (str_starts_with($normalized, '/')) {
                $path = $this->collapseLeadingSlashes($normalized);
                return $path === $raw ? null : $path;
            }

            return null;
        }

        $parts = parse_url($normalized);
        if (!is_array($parts) || empty($parts['host'])) {
            return null;
        }
        if (strtolower((string) $parts['host']) !== $host) {
            return null;
        }

        $path = (string) ($parts['path'] ?? '/');
        if ($path === '') {
            $path = '/';
        }
        $path = $this->collapseLeadingSlashes($path);

        if (!empty($parts['query'])) {
            $path .= '?' . $parts['query'];
        }
        if (!empty($parts['fragment'])) {
            $path .= '#' . $parts['fragment'];
        }

        return $path;
    }

    public function extractHost(string $domain): string
    {
        $domain = trim($domain);
        if ($domain === '') {
            return '';
        }
        if (!preg_match('#^https?://#i', $domain) && !str_starts_with($domain, '//')) {
            $domain = 'https://' . ltrim($domain, '/');
        }
        if (str_starts_with($domain, '//')) {
            $domain = 'https:' . $domain;
        }
        $host = parse_url($domain, PHP_URL_HOST);

        return is_string($host) ? strtolower($host) : '';
    }

    protected function collapseLeadingSlashes(string $path): string
    {
        $path = preg_replace('#^/+#', '/', $path) ?? $path;
        if ($path === '' || $path[0] !== '/') {
            $path = '/' . ltrim($path, '/');
        }

        return $path;
    }
}
