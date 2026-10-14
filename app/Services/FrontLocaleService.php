<?php

namespace App\Services;

use App\Modules\Setting\Models\Locale;

class FrontLocaleService
{
    public function build(): array
    {
        $scheme = $this->resolveScheme();
        $currentHost = strtolower((string)request()->getHost());
        $currentCode = strtolower((string)app()->getLocale());
        $pathAndQuery = $this->currentPathAndQuery();

        $locales = Locale::query()
            ->orderByDesc('sort')
            ->get()
            ->map(function (Locale $locale) use ($scheme, $pathAndQuery) {
                $host = $this->normalizeHost((string)$locale->url);
                // 切换语种：保留当前路径与查询串，不回首页
                // 例：/blog/xxx → https://en.example.com/blog/xxx
                $link = $host !== ''
                    ? ($scheme . $host . $pathAndQuery)
                    : ($scheme . ltrim($pathAndQuery, '/') ?: $scheme);

                $flagPath = front_image_url($locale->path);

                return [
                    'label' => $locale->language,
                    'code' => (string)$locale->language_code,
                    'url' => $link,
                    'host' => $host,
                    'path' => $flagPath !== '' ? $flagPath : '/front/imgs/us-flag.svg',
                ];
            })
            ->values()
            ->toArray();

        $current = null;
        foreach ($locales as $item) {
            $itemHost = strtolower((string)($item['host'] ?? ''));
            $itemCode = strtolower((string)($item['code'] ?? ''));
            if (($itemHost !== '' && $itemHost === $currentHost) || ($itemCode !== '' && $itemCode === $currentCode)) {
                $current = $item;
                break;
            }
        }

        if ($current === null) {
            $current = $locales[0] ?? null;
        }

        return [
            'items' => $locales,
            'current' => $current,
        ];
    }

    /**
     * 当前页 path + query（不含域名），始终以 / 开头（首页为 /）。
     */
    protected function currentPathAndQuery(): string
    {
        $request = request();
        $rawPath = trim((string)$request->path(), '/');
        $path = $rawPath === '' ? '/' : ('/' . $rawPath);

        $query = (string)$request->getQueryString();
        if ($query !== '') {
            return $path . '?' . $query;
        }

        return $path;
    }

    protected function resolveScheme(): string
    {
        if (config('app.redirect_https')) {
            return 'https://';
        }
        try {
            $scheme = strtolower((string)request()->getScheme());
            if ($scheme === 'https' || $scheme === 'http') {
                return $scheme . '://';
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return 'http://';
    }

    protected function normalizeHost(string $url): string
    {
        $url = strtolower(trim($url));
        if ($url === '') {
            return '';
        }

        $url = preg_replace('#^https?://#i', '', $url) ?? $url;
        $url = explode('/', $url, 2)[0];
        $url = explode('?', $url, 2)[0];
        $url = explode(':', $url, 2)[0];

        return rtrim($url, '.');
    }
}
