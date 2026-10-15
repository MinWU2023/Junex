<?php

namespace App\Services;

use App\Modules\Setting\Models\SnsIcon;
use Illuminate\Support\Facades\Schema;

class SnsIconService
{
    /** @var array<string, array|null> scene|locale => list */
    protected static $cache = [];

    /**
     * @param string $scene link|share
     * @return array<int, array{id:int,sign:string,path:string,icon_url:string,link:string,alt:string,sort:int,link_active:int,share_active:int}>
     */
    public function getIcons(string $scene = 'link'): array
    {
        $scene = $scene === 'share' ? 'share' : 'link';
        $locale = function_exists('front_locale_code') ? front_locale_code() : (string)app()->getLocale();
        $cacheKey = $scene . '|' . $locale;

        if (isset(self::$cache[$cacheKey]) && self::$cache[$cacheKey] !== null) {
            return self::$cache[$cacheKey];
        }

        self::$cache[$cacheKey] = [];

        try {
            if (!Schema::hasTable('sns_icons')) {
                return self::$cache[$cacheKey];
            }

            $query = SnsIcon::query()->with(['translations']);
            if ($scene === 'share') {
                $query->shareActive();
            } else {
                $query->linkActive();
            }

            $items = $query
                ->orderByDesc('sort')
                ->orderBy('id')
                ->get();

            foreach ($items as $item) {
                $sign = strtolower(trim((string)$item->sign));
                if ($sign === '') {
                    continue;
                }
                $alt = function_exists('translated_attr')
                    ? translated_attr($item, 'alt')
                    : trim((string)($item->alt ?? ''));
                if ($alt === '') {
                    $alt = ucfirst($sign);
                }
                self::$cache[$cacheKey][] = [
                    'id' => (int)$item->id,
                    'sign' => $sign,
                    'path' => (string)($item->path ?? ''),
                    'icon_url' => front_image_url($item->path ?? ''),
                    'link' => trim((string)($item->link ?? '')),
                    'alt' => $alt,
                    'sort' => (int)$item->sort,
                    'link_active' => (int)($item->link_active ?? 0),
                    'share_active' => (int)($item->share_active ?? 0),
                ];
            }
        } catch (\Throwable $e) {
            self::$cache[$cacheKey] = [];
        }

        return self::$cache[$cacheKey];
    }

    /** @deprecated use getIcons('link') */
    public function getActiveIcons(): array
    {
        return $this->getIcons('link');
    }

    public function getLinkIcons(): array
    {
        return $this->getIcons('link');
    }

    public function getShareIcons(): array
    {
        return $this->getIcons('share');
    }

    public function clearCache(): void
    {
        self::$cache = [];
    }
}
