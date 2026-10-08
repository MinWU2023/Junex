<?php

namespace App\Services;

use App\Modules\Setting\Models\WhyChooseCard;
use App\Modules\Setting\Models\WhyChooseSetting;

class WhyChooseService
{
    public function getWhyChoose(): array
    {
        $section = app(SectionTitleService::class)->get('why_choose');

        $whyChoose = [
            'tree' => null,
            'title' => (string)($section['title'] ?? ''),
            'description' => (string)($section['subtitle'] ?? ''),
            'cards' => [],
            'center' => [
                'logo' => '',
                'logo_url' => '',
                'title' => '',
                'subtitle' => '',
                'description_desktop' => '',
            ],
        ];

        if (trim($whyChoose['title']) === '') {
            $whyChoose['title'] = 'Why Choose Junexsport';
        }
        if (trim($whyChoose['description']) === '') {
            $whyChoose['description'] = SectionTitleService::DEFAULT_SUBTITLE;
        }
        if (trim((string)($whyChoose['center']['logo'] ?? '')) === '') {
            $whyChoose['center']['logo'] = 'front/imgs/index_wc_logo.png';
        }
        $whyChoose['center']['logo_url'] = front_image_url($whyChoose['center']['logo'] ?? '');
        if (trim((string)($whyChoose['center']['title'] ?? '')) === '') {
            $whyChoose['center']['title'] = 'Junexsport';
        }
        if (trim((string)($whyChoose['center']['subtitle'] ?? '')) === '') {
            $whyChoose['center']['subtitle'] = 'Professional Sportswear Manufacturer';
        }
        if (trim((string)($whyChoose['center']['description_desktop'] ?? '')) === '') {
            $whyChoose['center']['description_desktop'] = 'Creating Billions of High-Quality Garments to Make Exercise More Enjoyable.';
        }

        try {
            $setting = WhyChooseSetting::query()->with(['translations'])->orderBy('id')->first();
            if ($setting) {
                if (trim((string)($setting->logo ?? '')) !== '') {
                    $whyChoose['center']['logo'] = (string)$setting->logo;
                    $whyChoose['center']['logo_url'] = front_image_url($setting->logo);
                }
                if (trim((string)($setting->title ?? '')) !== '') {
                    $whyChoose['center']['title'] = (string)$setting->title;
                }
                if (trim((string)($setting->subtitle ?? '')) !== '') {
                    $whyChoose['center']['subtitle'] = (string)$setting->subtitle;
                }
                if (trim((string)($setting->description_desktop ?? '')) !== '') {
                    $whyChoose['center']['description_desktop'] = (string)$setting->description_desktop;
                }
            }
        } catch (\Throwable $e) {
            // keep fallback center
        }

        try {
            $dbCards = WhyChooseCard::query()
                ->active()
                ->with(['translations'])
                ->orderByDesc('sort')
                ->orderByDesc('id')
                ->get()
                ->map(function ($card) {
                    $mobile = front_image_url($card->image_mobile);
                    $desktop = front_image_url($card->background_desktop);
                    $url = trim((string)($card->url ?? ''));
                    if ($url === '') {
                        $url = '#';
                    }

                    return [
                        'label' => (string)($card->label ?? ''),
                        'value' => (string)($card->value ?? ''),
                        'value_suffix' => (string)($card->value_suffix ?? ''),
                        'description' => (string)($card->description ?? ''),
                        'image_mobile' => ltrim($mobile, '/'),
                        'image_mobile_url' => $mobile,
                        'background_desktop' => ltrim($desktop, '/'),
                        'background_desktop_url' => $desktop,
                        'url' => $url,
                    ];
                })
                ->filter(function ($row) {
                    return trim((string)($row['label'] ?? '')) !== ''
                        || trim((string)($row['value'] ?? '')) !== '';
                })
                ->values()
                ->all();

            if (!empty($dbCards)) {
                $whyChoose['cards'] = $dbCards;
            }
        } catch (\Throwable $e) {
            // keep fallback cards
        }

        if (empty($whyChoose['cards'])) {
            $whyChoose['cards'] = [
                [
                    'label' => 'Annual Output',
                    'value' => '45',
                    'value_suffix' => 'Millions Items',
                    'description' => 'High Production Volume, Ensuring Both Quantity And Quality.',
                    'image_mobile' => 'front/imgs/index_wc_l02.png',
                    'image_mobile_url' => front_image_url('/front/imgs/index_wc_l02.png'),
                    'background_desktop' => 'front/imgs/index_wc_l02.jpg',
                    'background_desktop_url' => front_image_url('/front/imgs/index_wc_l02.jpg'),
                    'url' => '#',
                ],
                [
                    'label' => 'Spot Reserves',
                    'value' => '800',
                    'value_suffix' => 'Millions Items',
                    'description' => 'Rapid Response Supply, Protecting Your Business Every Step of the Way.',
                    'image_mobile' => 'front/imgs/index_wc_h02.png',
                    'image_mobile_url' => front_image_url('/front/imgs/index_wc_h02.png'),
                    'background_desktop' => 'front/imgs/index_wc_h02.png',
                    'background_desktop_url' => front_image_url('/front/imgs/index_wc_h02.png'),
                    'url' => '#',
                ],
                [
                    'label' => 'Number Of Customers',
                    'value' => '100+',
                    'value_suffix' => 'Millions Of Customers',
                    'description' => 'Professionalism Earns Greater Trust.',
                    'image_mobile' => 'front/imgs/index_wc_h01.png',
                    'image_mobile_url' => front_image_url('/front/imgs/index_wc_h01.png'),
                    'background_desktop' => 'front/imgs/index_wc_h01.png',
                    'background_desktop_url' => front_image_url('/front/imgs/index_wc_h01.png'),
                    'url' => '#',
                ],
                [
                    'label' => 'Production Line',
                    'value' => '50+',
                    'value_suffix' => 'Items',
                    'description' => 'A Powerful Production Capacity Of 150,000~200,000 Units Per Day.',
                    'image_mobile' => 'front/imgs/index_wc_l02.png',
                    'image_mobile_url' => front_image_url('/front/imgs/index_wc_l02.png'),
                    'background_desktop' => 'front/imgs/index_wc_l01.png',
                    'background_desktop_url' => front_image_url('/front/imgs/index_wc_l01.png'),
                    'url' => '#',
                ],
            ];
        }

        return $whyChoose;
    }
}
