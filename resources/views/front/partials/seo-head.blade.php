{{-- Front SEO head: title/description/keywords + Schema.org --}}
@php
    // 优先：去掉域名后的 path 匹配后台单页面 url_key，命中则用该页 SEO 覆盖 TDK
    $cmsPageTdk = page_tdk_by_path();
    if (is_array($cmsPageTdk)) {
        $setting = app('settings')['setting'] ?? null;
        $tdk = [
            'title' => ($cmsPageTdk['title'] ?? '') !== ''
                ? $cmsPageTdk['title']
                : (($tdk['title'] ?? '') !== '' ? $tdk['title'] : translated_attr($setting, 'title')),
            'keywords' => ($cmsPageTdk['keywords'] ?? '') !== ''
                ? $cmsPageTdk['keywords']
                : (($tdk['keywords'] ?? '') !== '' ? $tdk['keywords'] : translated_attr($setting, 'keywords')),
            'description' => ($cmsPageTdk['description'] ?? '') !== ''
                ? $cmsPageTdk['description']
                : (($tdk['description'] ?? '') !== '' ? $tdk['description'] : translated_attr($setting, 'description')),
        ];
    }

    // 优先：按当前 URL 匹配单页面 url_key 的 schema；否则用控制器传入的 schemaOrgHtml
    $resolvedSchemaHtml = page_schema_org_html();
    if ($resolvedSchemaHtml === '') {
        $resolvedSchemaHtml = wrap_schema_org_html($schemaOrgHtml ?? '');
    }
@endphp
<title>{{ $tdk['title'] ?? '' }}</title>
@if(!empty($tdk['description']))
<meta name="description" content="{{ $tdk['description'] }}" />
@endif
@if(!empty($tdk['keywords']))
<meta name="keywords" content="{{ $tdk['keywords'] }}" />
@endif
@if($resolvedSchemaHtml !== '')
{!! $resolvedSchemaHtml !!}
@endif
