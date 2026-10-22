<?php

namespace App\Services;

/**
 * Schema.org 结构化数据渲染器。
 *
 * 规则配置在 resources/schema/{type}.json，文件里的 {{PLACEHOLDER}} 由 PHP 替换成真实值。
 * 约定：
 *  - 整个值只写一个占位符（如 "numberOfItems": "{{ITEM_COUNT}}"）时，按 PHP 原生类型输出
 *    （int / bool / array 都保留），这样数组型字段（如 itemListElement）可以直接注入。
 *  - 值里混排文字（如 "{{SITE_URL}}/#website"）时按字符串替换。
 *  - 占位符解析为空 → 该键整个删除，避免输出 "price": "" 这种无效数据。
 */
class SchemaMarkupService
{
    /** 标记：该节点需要整体删除 */
    private const REMOVE = '__SCHEMA_REMOVE__';

    /**
     * 渲染页面结构化数据，返回 <script type="application/ld+json"> 片段。
     *
     * @param  string  $type  规则文件名（resources/schema/{type}.json）
     * @param  array<string, mixed>  $vars  页面级占位符
     */
    public function render(string $type, array $vars = []): string
    {
        $config = $this->loadConfig($type);
        if ($config === null) {
            return '';
        }

        // 页面级变量优先，站点级变量兜底
        $data = $this->substitute($config, $vars + $this->baseVars());

        if ($data === self::REMOVE || !is_array($data) || $data === []) {
            return '';
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false || $json === '') {
            return '';
        }

        return '<script type="application/ld+json">' . $json . '</script>';
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function loadConfig(string $type): ?array
    {
        $type = (string)preg_replace('/[^A-Za-z0-9_\-]/', '', $type);
        if ($type === '') {
            return null;
        }

        $file = resource_path('schema' . DIRECTORY_SEPARATOR . $type . '.json');
        if (!is_file($file)) {
            return null;
        }

        $raw = @file_get_contents($file);
        if ($raw === false || trim($raw) === '') {
            return null;
        }

        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : null;
    }

    /**
     * 全站通用占位符（站点名、Logo、联系方式、社交主页等）。
     *
     * @return array<string, mixed>
     */
    protected function baseVars(): array
    {
        $setting = null;
        try {
            $setting = app('settings')['setting'] ?? null;
        } catch (\Throwable $e) {
            $setting = null;
        }

        $siteName = '';
        $siteDescription = '';
        $logo = '';
        $emails = [];
        $phones = [];
        $address = '';

        if ($setting) {
            $siteName = translated_attr($setting, 'name');
            $siteDescription = translated_attr($setting, 'description');

            $logo = front_image_url($setting->logo ?? '');
            if ($logo === '') {
                $logo = front_image_url($setting->inner_logo ?? '');
            }

            $emails = $this->splitList((string)($setting->contract_email ?? ''));
            $phones = $this->splitList((string)($setting->contract_mobile ?? ''));
            $address = trim((string)($setting->company_address ?? ''));
        }

        if ($siteName === '') {
            $siteName = (string)config('app.name');
        }

        $sameAs = [];
        try {
            foreach (sns_icons('link') as $icon) {
                $link = trim((string)($icon['link'] ?? ''));
                if ($link !== '') {
                    $sameAs[] = $link;
                }
            }
        } catch (\Throwable $e) {
            $sameAs = [];
        }

        $siteUrl = '';
        try {
            $siteUrl = rtrim((string)url('/'), '/');
        } catch (\Throwable $e) {
            $siteUrl = '';
        }

        $searchUrl = '';
        try {
            $searchUrl = (string)route('search') . '?q=';
        } catch (\Throwable $e) {
            $searchUrl = $siteUrl . '/search?q=';
        }

        return [
            'SITE_NAME' => $siteName,
            'SITE_URL' => $siteUrl,
            'SITE_DESCRIPTION' => $siteDescription,
            'LOGO_URL' => $logo !== '' ? front_absolute_url($logo) : '',
            'LOCALE' => str_replace('_', '-', front_locale_code()),
            'ORG_EMAIL' => $emails[0] ?? '',
            'ORG_PHONE' => $phones[0] ?? '',
            'ORG_ADDRESS' => $address,
            'SAME_AS' => $sameAs,
            'SEARCH_URL' => $searchUrl,
        ];
    }

    /**
     * @return array<int, string>
     */
    protected function splitList(string $value): array
    {
        $value = trim($value);
        if ($value === '') {
            return [];
        }

        return array_values(array_filter(
            array_map('trim', explode(',', $value)),
            static fn ($item) => $item !== ''
        ));
    }

    /**
     * @param  mixed  $node
     * @param  array<string, mixed>  $vars
     * @return mixed
     */
    protected function substitute($node, array $vars)
    {
        if (is_string($node)) {
            return $this->substituteString($node, $vars);
        }

        if (is_array($node)) {
            $result = [];

            foreach ($node as $key => $value) {
                $resolved = $this->substitute($value, $vars);

                if ($resolved === self::REMOVE) {
                    continue;
                }

                // 空数组（列表/对象整体为空）同样丢弃，避免输出 [] 或 {}
                if (is_array($resolved) && $resolved === []) {
                    continue;
                }

                if ($resolved === '') {
                    continue;
                }

                $result[$key] = $resolved;
            }

            if ($result === []) {
                return self::REMOVE;
            }

            // 只剩 @type 的对象（例如品牌名为空时的 {"@type":"Brand"}）没有实际内容，整体丢弃
            if (isset($result['@type']) && count($result) === 1) {
                return self::REMOVE;
            }

            return $result;
        }

        return $node;
    }

    /**
     * @param  array<string, mixed>  $vars
     * @return mixed
     */
    protected function substituteString(string $value, array $vars)
    {
        // 1) 整个值就是一个占位符 → 保留 PHP 原生类型（int / bool / array）
        if (preg_match('/^\{\{\s*([A-Z0-9_]+)\s*\}\}$/', $value, $match)) {
            $key = $match[1];

            if (!array_key_exists($key, $vars)) {
                return self::REMOVE;
            }

            $resolved = $vars[$key];

            if (is_array($resolved)) {
                return $resolved === [] ? self::REMOVE : $resolved;
            }

            if (is_bool($resolved) || is_int($resolved) || is_float($resolved)) {
                return $resolved;
            }

            if ($resolved === null) {
                return self::REMOVE;
            }

            $resolved = trim((string)$resolved);

            return $resolved === '' ? self::REMOVE : $resolved;
        }

        // 2) 值里混排文字 → 字符串替换
        if (!str_contains($value, '{{')) {
            return $value;
        }

        $replaced = preg_replace_callback('/\{\{\s*([A-Z0-9_]+)\s*\}\}/', static function (array $match) use ($vars) {
            $resolved = $vars[$match[1]] ?? '';

            if (is_bool($resolved)) {
                return $resolved ? '1' : '0';
            }

            if (is_array($resolved)) {
                // 数组只能整体注入，混排时忽略
                return '';
            }

            return trim((string)$resolved);
        }, $value);

        if ($replaced === null) {
            return $value;
        }

        return trim($replaced) === '' ? self::REMOVE : $replaced;
    }
}
