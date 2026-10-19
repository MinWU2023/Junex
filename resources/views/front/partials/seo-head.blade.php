{{-- Front SEO head: title/description/keywords + Schema.org --}}
@php
    // Priority: match the domain-stripped path against the CMS single page url_key and, on a hit, override the TDK with that page's SEO
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

    // Priority: match the current URL against a single page url_key schema; otherwise use the schemaOrgHtml passed in by the controller
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
