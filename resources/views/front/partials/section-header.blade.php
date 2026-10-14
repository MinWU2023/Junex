{{-- Unified homepage section header: title + red divider + subtitle --}}
@php
    $section = $section ?? [];
    $title = (string)($section['title'] ?? ($title ?? ''));
    $subtitle = (string)($section['subtitle'] ?? ($subtitle ?? ''));
    $titleUrl = $titleUrl ?? ($section['url'] ?? '');
    $titleClass = $titleClass ?? 'text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f';
    $subtitleClass = $subtitleClass ?? 'mx-auto mt-4 max-w-[825px] leading-6 text-slate-600 text-f16 font-poppins-regular text-themeText-g';
    $dividerClass = $dividerClass ?? 'mx-auto mt-3 h-[7px] w-[46px] rounded bg-brand-red';
@endphp
<div class="text-center">
    @if(trim((string)$titleUrl) !== '')
        <a href="{{ $titleUrl }}" class="inline-block">
            <h2 class="{{ $titleClass }}">
                {{ $title }}
            </h2>
        </a>
    @else
        <h2 class="{{ $titleClass }}">
            {{ $title }}
        </h2>
    @endif
    <div class="{{ $dividerClass }}" aria-hidden="true"></div>
    @if(trim($subtitle) !== '')
        <p class="{{ $subtitleClass }}">
            {{ $subtitle }}
        </p>
    @endif
</div>
