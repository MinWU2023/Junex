<?php

namespace App\Services;

use App\Modules\Setting\Models\Locale;

class FrontLocaleService
{
    public function build(): array
    {
        $scheme = config('app.redirect_https') ? 'https://' : 'http://';
        $currentHost = strtolower((string)request()->getHost());
        $currentCode = strtolower((string)app()->getLocale());

        $locales = Locale::query()
            ->orderByDesc('sort')
            ->get()
            ->map(function (Locale $locale) use ($scheme) {
                $host = $this->normalizeHost((string)$locale->url);
                $link = $host !== '' ? ($scheme . $host) : $scheme;

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

    protected function normalizeHost(string $url): string
    {
        $url = strtolower(trim($url));
        if ($url === '') {
            return '';
        }

        $url = preg_replace('#^https?://#i', '', $url) ?? $url;
        $url = explode('/', $url, 2)[0];
        $url = explode('?', $url, 2)[0];

        return rtrim($url, '.');
    }
}
