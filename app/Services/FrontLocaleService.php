<?php

namespace App\Services;

use App\Modules\Setting\Models\Locale;

class FrontLocaleService
{
    public function build(): array
    {
        $scheme = config('app.redirect_https') ? 'https://' : 'http://';

        $locales = Locale::query()
            ->orderByDesc('sort')
            ->get()
            ->map(function (Locale $locale) use ($scheme) {
                $url = trim((string)$locale->url);
                $url = ltrim($url, '/');
                $link = $scheme.$url;

                $flagPath = front_image_url($locale->path);

                return [
                    'label' => $locale->language,
                    'code' => $locale->language_code,
                    'url' => $link,
                    'path' => $flagPath !== '' ? $flagPath : '/front/imgs/us-flag.svg',
                ];
            })
            ->values()
            ->toArray();

        return [
            'items' => $locales,
        ];
    }
}
