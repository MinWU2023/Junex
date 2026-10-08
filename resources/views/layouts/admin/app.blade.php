<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>dyycloud</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{ asset('css/admin/admin.public.css') }}" media="all">
    @yield('css')
</head>
{{ $slot }}
<script type="text/javascript" src="{{ url(config('app.admin_prefix') . '/multilingual/translations') }}"></script>
<script type="text/javascript" src="{{ asset('/js/admin/admin.newjquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/admin/admin.public.js') }}"></script>
@yield('ext')
@yield('scripts')
</html>
