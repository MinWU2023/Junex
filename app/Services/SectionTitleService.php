<?php

namespace App\Services;

use App\Modules\Setting\Models\SectionTitle;

class SectionTitleService
{
    public const DEFAULT_SUBTITLE = 'Junzhuosport, As A Mature Sportswear/ Yoga Wear/ Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focuses On Offering Eco-Friendly & Recycled & Sustainable Fabric';

    /** @var array<string, array{name:string,title:string,subtitle:string,sort:int}> */
    public const DEFINITIONS = [
        'home_product_category' => [
            'name' => '首页产品分类',
            'title' => 'Junex Product Category',
            'subtitle' => self::DEFAULT_SUBTITLE,
            'sort' => 60,
        ],
        'hot_styles' => [
            'name' => '热门款式',
            'title' => 'Junex Hot Styles',
            'subtitle' => self::DEFAULT_SUBTITLE,
            'sort' => 50,
        ],
        'custom_serrvices' => [
            'name' => '定制服务',
            'title' => 'Junex Custom Service',
            'subtitle' => self::DEFAULT_SUBTITLE,
            'sort' => 40,
        ],
        'exciting_updates' => [
            'name' => '精彩动态',
            'title' => 'The Exciting Updates For You',
            'subtitle' => self::DEFAULT_SUBTITLE,
            'sort' => 30,
        ],
        'video_recommends' => [
            'name' => '视频推荐',
            'title' => 'Video Recommendation',
            'subtitle' => self::DEFAULT_SUBTITLE,
            'sort' => 28,
        ],
        'why_choose' => [
            'name' => '为何选择我们',
            'title' => 'Why Choose Junexsport',
            'subtitle' => self::DEFAULT_SUBTITLE,
            'sort' => 20,
        ],
        'ask_us_home' => [
            'name' => '首页询盘',
            'title' => 'To Power Your Brand With Us',
            'subtitle' => self::DEFAULT_SUBTITLE,
            'sort' => 10,
        ],
    ];

    /** @var array<string, array{title:string,subtitle:string,name:string,sign:string}>|null */
    private ?array $cache = null;

    /**
     * @return array{title:string,subtitle:string,name:string,sign:string}
     */
    public function get(string $sign): array
    {
        $sign = trim($sign);
        $all = $this->all();

        if (isset($all[$sign])) {
            return $all[$sign];
        }

        $fallback = self::DEFINITIONS[$sign] ?? [
            'name' => $sign,
            'title' => '',
            'subtitle' => '',
            'sort' => 0,
        ];

        return [
            'sign' => $sign,
            'name' => (string)$fallback['name'],
            'title' => (string)$fallback['title'],
            'subtitle' => (string)$fallback['subtitle'],
        ];
    }

    /**
     * @return array<string, array{title:string,subtitle:string,name:string,sign:string}>
     */
    public function all(): array
    {
        if ($this->cache !== null) {
            return $this->cache;
        }

        $result = [];
        foreach (self::DEFINITIONS as $sign => $def) {
            $result[$sign] = [
                'sign' => $sign,
                'name' => (string)$def['name'],
                'title' => (string)$def['title'],
                'subtitle' => (string)$def['subtitle'],
            ];
        }

        try {
            $rows = SectionTitle::query()
                ->active()
                ->with(['translations'])
                ->whereIn('sign', array_keys(self::DEFINITIONS))
                ->get()
                ->keyBy('sign');

            foreach ($rows as $sign => $row) {
                $title = trim((string)($row->title ?? ''));
                $subtitle = trim((string)($row->subtitle ?? ''));
                $result[$sign] = [
                    'sign' => $sign,
                    'name' => (string)($row->name ?: ($result[$sign]['name'] ?? $sign)),
                    'title' => $title !== '' ? $title : (string)($result[$sign]['title'] ?? ''),
                    'subtitle' => $subtitle !== '' ? $subtitle : (string)($result[$sign]['subtitle'] ?? ''),
                ];
            }
        } catch (\Throwable $e) {
            // keep defaults
        }

        $this->cache = $result;

        return $this->cache;
    }

    /**
     * Ensure six fixed section rows exist (idempotent).
     */
    public function seedDefaults(): void
    {
        $locale = (string)(config('translatable.fallback_locale') ?: config('app.locale', 'en'));

        foreach (self::DEFINITIONS as $sign => $def) {
            $model = SectionTitle::query()->where('sign', $sign)->first();
            if (!$model) {
                SectionTitle::create([
                    'sign' => $sign,
                    'name' => $def['name'],
                    'sort' => (int)$def['sort'],
                    'active' => 1,
                    $locale => [
                        'title' => $def['title'],
                        'subtitle' => $def['subtitle'],
                    ],
                ]);
                continue;
            }

            $changed = false;
            if (trim((string)$model->name) === '') {
                $model->name = $def['name'];
                $changed = true;
            }
            if ($changed) {
                $model->save();
            }

            $translation = $model->translate($locale, false);
            if (!$translation || (trim((string)($translation->title ?? '')) === '' && trim((string)($translation->subtitle ?? '')) === '')) {
                $model->fill([
                    $locale => [
                        'title' => $def['title'],
                        'subtitle' => $def['subtitle'],
                    ],
                ]);
                $model->save();
            }
        }

        $this->cache = null;
    }
}
