<x-layout>
@section('tdk')
@php
    $siteName = app('settings')['setting']->site_name ?? config('app.name');
    $tdk = [
        'title' => '404 - ' . __('Page Not Found') . ' | ' . $siteName,
        'description' => __('The page you are looking for cannot be found.'),
        'keywords' => '',
    ];
@endphp
@include('front.partials.seo-head')
<meta name="robots" content="noindex, nofollow" />
@endsection

@section('content')
@include('front.partials.error-404-body')
@endsection
</x-layout>
