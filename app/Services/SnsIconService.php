<?php

namespace App\Services;

use App\Modules\Setting\Models\SnsIcon;
use Illuminate\Support\Facades\Schema;

class SnsIconService
{
    /** @var array<string, array|null> */
    protected static $cache = [
        'link' => null,
        'share' => null,
    ];

    /**
     * @param string $scene link|share
     * @return array<int, array{id:int,sign:string,path:string,icon_url:string,link:string,alt:string,sort:int,link_active:int,share_active:int}>
     */
    public function getIcons(string $scene = 'link'): array
    {
        $scene = $scene === 'share' ? 'share' : 'link';

        if (self::$cache[$scene] !== null) {
            return self::$cache[$scene];
        }

        self::$cache[$scene] = [];

        try {
            if (!Schema::hasTable('sns_icons')) {
                return self::$cache[$scene];
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
                $alt = trim((string)($item->alt ?? ''));
                if ($alt === '') {
                    $alt = ucfirst($sign);
                }
                self::$cache[$scene][] = [
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
            self::$cache[$scene] = [];
        }

        return self::$cache[$scene];
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
        self::$cache = [
            'link' => null,
            'share' => null,
        ];
    }
}
