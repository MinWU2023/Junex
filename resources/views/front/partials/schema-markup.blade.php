{{--
    Schema.org 结构化数据。
    规则文件：resources/schema/{schemaType}.json，文件里的双花括号占位符由 PHP 替换。
    页面级变量通过第二个参数传进来，TDK / 面包屑 / 当前 URL 在这里自动补齐。
--}}
@php
    $schemaRuleType = trim((string)($schemaType ?? ''));
    $schemaPageVars = is_array($schemaVars ?? null) ? $schemaVars : [];

    $schemaPageVars += [
        'PAGE_URL' => (string) url()->current(),
        'PAGE_TITLE' => trim((string)($tdk['title'] ?? '')),
        'PAGE_DESCRIPTION' => trim((string)($tdk['description'] ?? '')),
        'PAGE_KEYWORDS' => trim((string)($tdk['keywords'] ?? '')),
        'BREADCRUMB_ITEMS' => front_schema_breadcrumbs(is_array($breadcrumbs ?? null) ? $breadcrumbs : []),
    ];
@endphp
@if($schemaRuleType !== '')
{!! front_schema_markup($schemaRuleType, $schemaPageVars) !!}
@endif
