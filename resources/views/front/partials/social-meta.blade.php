{{-- OG / Twitter 分享标签：title、description、keywords 直接取本页 TDK 的渲染结果，
     保证与原 TDK 同源；多语言站点因为 TDK 本身已按语言渲染，这里自然输出对应语言。 --}}
@php
    $ogTdkHtml = (string) View::yieldContent('tdk');

    $ogHtmlValue = static function (string $html, string $pattern): string {
        if ($html === '' || !preg_match($pattern, $html, $m)) {
            return '';
        }
        $raw = html_entity_decode(strip_tags((string)($m[1] ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $collapsed = preg_replace('/\s+/u', ' ', $raw);

        return trim((string)($collapsed ?? $raw));
    };

    $ogTitle = $ogHtmlValue($ogTdkHtml, '/<title\b[^>]*>(.*?)<\/title>/is');
    $ogDescription = $ogHtmlValue($ogTdkHtml, '/<meta\b[^>]*name=["\']description["\'][^>]*content=["\']([^"\']*)["\']/is');
    $ogKeywords = $ogHtmlValue($ogTdkHtml, '/<meta\b[^>]*name=["\']keywords["\'][^>]*content=["\']([^"\']*)["\']/is');

    $ogSetting = $data['setting'] ?? (app('settings')['setting'] ?? null);

    // 分享类型：默认 website，产品详情/博客详情页会覆盖
    $ogType = trim((string) View::yieldContent('og-type'));
    if ($ogType === '') {
        $ogType = 'website';
    }

    // 分享图：默认用站点 Logo（后台基础设置的 logo），产品详情用产品主图、博客详情用博客主图（由页面 section 覆盖）
    $ogImage = trim((string) View::yieldContent('og-image'));
    if ($ogImage === '' && $ogSetting) {
        $ogImage = front_image_url($ogSetting->logo ?? '');
    }
    if ($ogImage === '') {
        $ogImage = trim((string) ($data['header_logo_url'] ?? ''));
    }
    $ogImage = front_absolute_url($ogImage);

    $ogUrl = url()->current();
    $ogSiteName = $ogSetting ? translated_attr($ogSetting, 'name') : (string) config('app.name');
    $ogLocale = front_og_locale();
    $ogCurrentCode = strtolower((string) front_locale_code());

    $ogAlternates = [];
    foreach (($data['locales']['items'] ?? []) as $ogLocaleItem) {
        $code = strtolower((string) ($ogLocaleItem['code'] ?? ''));
        if ($code === '' || $code === $ogCurrentCode) {
            continue;
        }
        $alt = front_og_locale($code);
        if ($alt !== '' && $alt !== $ogLocale) {
            $ogAlternates[$alt] = $alt;
        }
    }
@endphp
@if($ogTitle !== '')
<meta property="og:type" content="{{ $ogType }}" />
<meta property="og:site_name" content="{{ $ogSiteName }}" />
<meta property="og:title" content="{{ $ogTitle }}" />
@endif
@if($ogDescription !== '')
<meta property="og:description" content="{{ $ogDescription }}" />
@endif
@if($ogKeywords !== '')
<meta property="og:keywords" content="{{ $ogKeywords }}" />
@endif
<meta property="og:url" content="{{ $ogUrl }}" />
@if($ogImage !== '')
<meta property="og:image" content="{{ $ogImage }}" />
<meta property="og:image:alt" content="{{ $ogTitle }}" />
@endif
<meta property="og:locale" content="{{ $ogLocale }}" />
@foreach($ogAlternates as $altLocale)
<meta property="og:locale:alternate" content="{{ $altLocale }}" />
@endforeach

<meta name="twitter:card" content="{{ $ogImage !== '' ? 'summary_large_image' : 'summary' }}" />
@if($ogTitle !== '')
<meta name="twitter:title" content="{{ $ogTitle }}" />
@endif
@if($ogDescription !== '')
<meta name="twitter:description" content="{{ $ogDescription }}" />
@endif
@if($ogKeywords !== '')
<meta name="twitter:keywords" content="{{ $ogKeywords }}" />
@endif
@if($ogImage !== '')
<meta name="twitter:image" content="{{ $ogImage }}" />
<meta name="twitter:image:alt" content="{{ $ogTitle }}" />
@endif
