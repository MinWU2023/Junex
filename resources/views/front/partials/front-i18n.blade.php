{{--
  Front JS i18n bootstrap.
  Dictionary is inlined so nginx static .js 404 cannot break translations.
--}}
@php
    $frontI18n = app(\App\Services\FrontJsI18nService::class)->pack();
@endphp
<script>
window.__LOCALE__ = @json($frontI18n['locale']);
</script>
<script type="text/javascript" src="/front/js/i18n.js?v=20261010c"></script>
<script>
window.FrontI18n && window.FrontI18n.setLocale(
    @json($frontI18n['locale']),
    @json($frontI18n['messages'])
);
</script>
