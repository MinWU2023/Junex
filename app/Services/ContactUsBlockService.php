<?php

namespace App\Services;

use App\Modules\Setting\Models\Setting;
use Illuminate\Support\Facades\Schema;

class ContactUsBlockService
{
    /** @return array<string, mixed> */
    public static function defaultContactUs(): array
    {
        return [
            'header' => [
                'title' => 'HEFEI SECOND PAGE TECH CO., LTD.',
                'subtitle' => 'Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing Elit, Sed Do Eiusmod Tempor Incididunt Ut Labore Et Dolore Magna Aliqua. Quis Ipsum Suspendisse Ultrices Gravida. Risus Commodo Viverra Maecenas Accumsan Lacus Vel Facilisis Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing Elit, Sed Do Eiusmod Tempor Incididunt Ut Labore Et Dolore Magna Aliqua. Quis Ipsum Suspendisse Ultrices.',
            ],
            'form' => [
                'title' => 'Leave A Message',
                'subtitle' => 'If You Are Interested In Our Products And Want To Know More Details, Please Leave A Message Here. We Will Reply You As Soon As We Can.',
                'placeholder_name' => 'Please Enter Your Name',
                'placeholder_email' => 'Please Enter Your Email Address',
                'placeholder_tel' => 'Please Enter Your Telephone Number Or WhatsApp Number',
                'placeholder_content' => 'Please Enter The Content',
                'button_text' => 'Send Inquiry Now',
            ],
            'right' => [
                'touch_title' => 'Get In Touch With',
                'touch_desc' => 'Ningguo Friend Trading Co.,Ltd Is Specialized In Research, And Of Shock Absorber Mount, Engine Mount, Stabilizer Links, Control Arm Bushing',
                'phone_title' => 'Give Us A Call',
                'phone_label' => 'Phone :',
                'email_title' => 'Email Us',
                'email_label' => 'Email :',
                'address_title' => 'Address',
                'social_title' => 'Social Networks',
                'social_desc' => 'Ningguo Friend Trading Co.,Ltd Is Specialized In Research, And Of Shock Absorber Mount, Engine Mount',
            ],
            'map' => [
                'iframe_src' => 'https://www.google.com/maps?q=Hefei%20Science%20%26%20Technology%20Museum&output=embed',
            ],
        ];
    }

    /** @return array{phones: array<int, array{label: string, href: string}>, emails: array<int, array{label: string, href: string}>, address: string} */
    public static function defaultContactLinks(): array
    {
        return [
            'phones' => [
                ['label' => '+86 181 5606 4977', 'href' => 'tel:+8618156064977'],
            ],
            'emails' => [
                ['label' => 'sale@detugroup.com', 'href' => 'mailto:sale@detugroup.com'],
            ],
            'address' => 'G08-2 Building, B No.90-1 Heifu Xiang Qinghuai District Nanjing,210007 Jiangsu China',
        ];
    }

    /** @return array{phones: array<int, array{label: string, href: string}>, emails: array<int, array{label: string, href: string}>, address: string} */
    public static function contactLinksFromSetting(?Setting $setting = null): array
    {
        $defaults = self::defaultContactLinks();
        $setting = $setting ?: self::resolveSetting();
        if (!$setting) {
            return $defaults;
        }

        $split = static function (?string $value): array {
            $value = trim((string)$value);
            if ($value === '') {
                return [];
            }

            return array_values(array_filter(array_map('trim', explode(',', $value)), static fn ($v) => $v !== ''));
        };

        $phones = array_map(static function (string $phone): array {
            return [
                'label' => $phone,
                'href' => 'tel:' . $phone,
            ];
        }, $split($setting->contract_mobile ?? ''));

        $emails = array_map(static function (string $email): array {
            return [
                'label' => $email,
                'href' => 'mailto:' . $email,
            ];
        }, $split($setting->contract_email ?? ''));

        $address = trim((string)($setting->company_address ?? ''));

        return [
            'phones' => $phones !== [] ? $phones : $defaults['phones'],
            'emails' => $emails !== [] ? $emails : $defaults['emails'],
            'address' => $address !== '' ? $address : $defaults['address'],
        ];
    }

    public static function renderFullHtml(?Setting $setting = null): string
    {
        $defaults = self::defaultContactUs();
        $html = view('static_block_templates.contact_us', [
            'contactUs' => $defaults,
        ])->render();

        return self::applyContactLinkPlaceholders($html, $setting);
    }

    public static function applyContactLinkPlaceholders(string $html, ?Setting $setting = null): string
    {
        if (!str_contains($html, '__CONTACT_PHONES_HTML__')
            && !str_contains($html, '__CONTACT_EMAILS_HTML__')
            && !str_contains($html, '__CONTACT_ADDRESS__')) {
            return $html;
        }

        $links = self::contactLinksFromSetting($setting);
        $right = self::defaultContactUs()['right'];

        $html = str_replace('__CONTACT_PHONES_HTML__', self::renderPhonesHtml($links, $right), $html);
        $html = str_replace('__CONTACT_EMAILS_HTML__', self::renderEmailsHtml($links, $right), $html);
        $html = str_replace('__CONTACT_ADDRESS__', e((string)($links['address'] ?? '')), $html);

        return $html;
    }

    public static function isCopyMissing(string $html): bool
    {
        if (trim($html) === '') {
            return true;
        }

        if (preg_match('/<h2\b[^>]*>(.*?)<\/h2>/is', $html, $match)) {
            $title = trim(html_entity_decode(strip_tags($match[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($title !== '') {
                return false;
            }
        }

        return true;
    }

    /** @param array{phones: array<int, array{label: string, href: string}>, emails: array<int, array{label: string, href: string}>, address: string} $links */
    /** @param array<string, mixed> $right */
    private static function renderPhonesHtml(array $links, array $right): string
    {
        $label = e((string)($right['phone_label'] ?? 'Phone :'));
        $phones = $links['phones'] ?? [];

        if ($phones === []) {
            return '<div class="mt-1 text-f14 font-poppins-regular text-themeText-g">' . $label . ' —</div>';
        }

        $html = '';
        foreach ($phones as $phone) {
            $href = trim((string)($phone['href'] ?? ''));
            $text = trim((string)($phone['label'] ?? ''));
            if ($href === '' || $text === '') {
                continue;
            }

            $html .= '<div class="mt-1 text-f14 font-poppins-regular text-themeText-g">'
                . $label
                . ' <a href="' . e($href) . '" class="text-themeText-g">' . e($text) . '</a>'
                . '</div>';
        }

        return $html !== '' ? $html : '<div class="mt-1 text-f14 font-poppins-regular text-themeText-g">' . $label . ' —</div>';
    }

    /** @param array{phones: array<int, array{label: string, href: string}>, emails: array<int, array{label: string, href: string}>, address: string} $links */
    /** @param array<string, mixed> $right */
    private static function renderEmailsHtml(array $links, array $right): string
    {
        $label = e((string)($right['email_label'] ?? 'Email :'));
        $emails = $links['emails'] ?? [];

        if ($emails === []) {
            return '<div class="mt-1 text-f14 font-poppins-regular text-themeText-g">' . $label . ' —</div>';
        }

        $html = '';
        foreach ($emails as $email) {
            $href = trim((string)($email['href'] ?? ''));
            $text = trim((string)($email['label'] ?? ''));
            if ($href === '' || $text === '') {
                continue;
            }

            $html .= '<div class="mt-1 text-f14 font-poppins-regular text-themeText-g">'
                . $label
                . ' <a href="' . e($href) . '" class="text-themeText-g">' . e($text) . '</a>'
                . '</div>';
        }

        return $html !== '' ? $html : '<div class="mt-1 text-f14 font-poppins-regular text-themeText-g">' . $label . ' —</div>';
    }

    private static function resolveSetting(): ?Setting
    {
        try {
            if (!Schema::hasTable('settings')) {
                return null;
            }

            return Setting::query()->first();
        } catch (\Throwable $e) {
            return null;
        }
    }
}
