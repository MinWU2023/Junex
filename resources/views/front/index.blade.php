<x-layout>
@section('tdk')
@include('front.partials.seo-head')
@endsection

@section('page-css-header')
<link type="text/css" rel="stylesheet" href="/front/css/pages/home.css" />
@endsection

@section('page-js-header')

@endsection 

@section('page-header')
<section class="relative w-full pt-16 md4:pt-0 banners">
    <div class="absolute inset-0 bg-slate-900" aria-hidden="true"></div>
    <header class="pointer-events-none absolute inset-x-0 top-0 z-20 hidden md4:block header-nav">
    <div class="pointer-events-auto mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="flex h-16 items-center justify-between md1:h-20 mt-2.5">
            @php
                $siteLogo = $setting->logo ?? front_webp_url('/front/imgs/logo2.svg');
                $innerLogo = $setting->inner_logo ?? null;
                $stickyLogo = $innerLogo ?: $siteLogo;
            @endphp
            <a href="/" class="flex items-center gap-2">
                <img class="header-logo selectable h-[70px] w-[100px] object-contain" src="{{ $siteLogo }}" data-default-src="{{ $siteLogo }}" data-sticky-src="{{ $stickyLogo }}" alt="Logo" loading="lazy" />
            </a>
            <div class="flex items-center gap-[35px]">
            @php
                $navItems = $nav['items'] ?? [];
                $linkBase = 'relative transition duration-200 hover:text-white after:absolute after:left-1/2 after:-translate-x-1/2 after:-bottom-[14px] after:h-[5px] after:w-[34px] after:rounded-[5px] after:bg-themeBg-d after:opacity-0 after:transition-all after:duration-200 hover:after:opacity-100';
                $linkActive = 'text-white after:opacity-100';
            @endphp
            <nav class="hidden items-center gap-[26px] text-[16px] font-poppins-medium uppercase tracking-wide text-white md4:flex">
                @foreach($navItems as $item)
                    @if(!empty($item['has_dropdown']) || !empty($item['children']))
                        <div class="relative group">
                            <a class="{{ $linkBase }} {{ !empty($item['active']) ? $linkActive : '' }} inline-flex items-center gap-1" href="{{ $item['url'] }}" @if(!empty($item['target'])) target="{{ $item['target'] }}" @endif @if(!empty($item['rel'])) rel="{{ $item['rel'] }}" @endif>
                                {{ $item['label'] }}
                            </a>

                            <div class="pointer-events-none absolute left-1/2 -translate-x-1/2 top-full z-40 pt-[26px] mt-0 w-[240px] opacity-0 transition duration-150 group-hover:pointer-events-auto group-hover:opacity-100">
                                <div class="relative overflow-visible bg-white text-slate-900 shadow-lg ring-1 ring-black/10">
                                    @if(!empty($item['url']) && $item['url'] !== '#' && ($item['link_type'] ?? '') === 'category')
                                        <a href="{{ $item['url'] }}" @if(!empty($item['target'])) target="{{ $item['target'] }}" @endif @if(!empty($item['rel'])) rel="{{ $item['rel'] }}" @endif class="flex items-center justify-between px-4 py-3 text-f14 font-poppins-regular text-slate-900 transition hover:bg-slate-50">{{ __('All Products') }}</a>
                                    @endif

                                    @foreach($item['children'] as $category)
                                        <div class="h-px w-full bg-slate-200"></div>
                                        @if(!empty($category['children']))
                                            <div class="relative submenu-parent">
                                                <a href="{{ $category['url'] }}" @if(!empty($category['target'])) target="{{ $category['target'] }}" @endif @if(!empty($category['rel'])) rel="{{ $category['rel'] }}" @endif class="flex items-center justify-between px-4 py-3 text-f14 font-poppins-regular text-slate-900 transition hover:bg-slate-50 {{ !empty($category['active']) ? 'bg-slate-50' : '' }}">
                                                    {{ $category['label'] }}
                                                    <svg viewBox="0 0 20 20" class="h-4 w-4 text-slate-500" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M7.21 5.23a.75.75 0 011.06 0l4.25 4.24a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 01-1.06-1.06L10.94 10 7.21 6.29a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>

                                                <div class="submenu-third pointer-events-none absolute left-full top-0 z-50 ml-0 w-[240px] opacity-0 transition duration-150">
                                                    <div class="overflow-hidden bg-white text-slate-900 shadow-lg ring-1 ring-black/10">
                                                        @foreach($category['children'] as $child)
                                                            <a href="{{ $child['url'] }}" @if(!empty($child['target'])) target="{{ $child['target'] }}" @endif @if(!empty($child['rel'])) rel="{{ $child['rel'] }}" @endif class="block px-4 py-3 text-f14 font-poppins-regular text-slate-900 transition hover:bg-slate-50 {{ !empty($child['active']) ? 'bg-slate-50' : '' }}">{{ $child['label'] }}</a>
                                                            @if(!$loop->last)
                                                                <div class="h-px w-full bg-slate-200"></div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <a href="{{ $category['url'] }}" @if(!empty($category['target'])) target="{{ $category['target'] }}" @endif @if(!empty($category['rel'])) rel="{{ $category['rel'] }}" @endif class="flex items-center justify-between px-4 py-3 text-f14 font-poppins-regular text-slate-900 transition hover:bg-slate-50 {{ !empty($category['active']) ? 'bg-slate-50' : '' }}">{{ $category['label'] }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a class="{{ $linkBase }} {{ !empty($item['active']) ? $linkActive : '' }}" href="{{ $item['url'] }}" @if(!empty($item['target'])) target="{{ $item['target'] }}" @endif @if(!empty($item['rel'])) rel="{{ $item['rel'] }}" @endif>{{ $item['label'] }}</a>
                    @endif
                @endforeach
        </nav>
        
        <div class="flex items-center gap-[35px] text-white/90">
            <button type="button" class="hidden h-8 w-8 items-center justify-center md4:inline-flex search-trigger" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48" class="h-6 w-6" aria-hidden="true">
                <path stroke-linejoin="round" stroke-width="4" stroke="currentColor" d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4 4 11.611 4 21s7.611 17 17 17Z" data-follow-stroke="#000" />
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="4" stroke="currentColor" d="M26.657 14.343A7.975 7.975 0 0 0 21 12c-2.209 0-4.209.895-5.657 2.343M33.222 33.222l8.485 8.485" data-follow-stroke="#000" />
            </svg>
            </button>
            @php
                $localeItems = $locales['items'] ?? [];
                $firstLocale = $localeItems[0] ?? null;
            @endphp
            <div class="language-switcher relative ml-auto hidden cursor-pointer select-none items-center gap-2 md4:flex">
            <img class="h-[26px] w-[26px] rounded-full object-cover" src="{{ $firstLocale['path'] ?? front_webp_url('/front/imgs/us-flag.svg') }}" alt="{{ $firstLocale['code'] ?? 'EN' }}" loading="lazy" />
            <span class="text-[15px] font-poppins-medium font-[500]">{{ $firstLocale['label'] ?? 'ENGLISH' }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-white" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
            <div class="language-dropdown absolute left-1/2 top-full z-30 mt-3 w-[170px]">
                <div class="language-dropdown-panel overflow-hidden rounded-lg border border-white/30 bg-white/30 shadow-lg backdrop-blur-md">
                @foreach($localeItems as $locale)
                    <a href="{{ $locale['url'] }}" class="flex items-center gap-3 px-4 py-3 text-[15px] text-themeText-a transition-colors hover:bg-white/25">
                        <img class="h-[26px] w-[26px] rounded-full object-cover" src="{{ $locale['path'] }}" alt="{{ $locale['code'] }}" loading="lazy" />
                        <span>{{ $locale['label'] }}</span>
                    </a>
                    @if(!$loop->last)
                        <div class="h-px w-full bg-white/25"></div>
                    @endif
                @endforeach
                </div>
            </div>
            </div>
            <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded bg-white/10 text-white md4:hidden" aria-label="Menu">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                <path d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h16v2H4v-2z" />
            </svg>
            </button>
        </div>
            </div>
        </div>
    </div>
    </header>
    @php
        $heroBanners = isset($heroBanners) ? collect($heroBanners) : collect();
        $hasAnyMobileBanner = $heroBanners->contains(function ($item) {
            return !empty($item['path_mobile']);
        });
        $mobileHeroBanners = $hasAnyMobileBanner
            ? $heroBanners->filter(function ($item) {
                return !empty($item['path_mobile']);
            })->values()
            : $heroBanners;
    @endphp
    @if($hasAnyMobileBanner)
        <div class="banners-viewport banners-viewport--pc">
            <div class="swiper banners-swiper h-[520px] w-full md1:h-[620px] md4:h-[720px]">
                <div class="swiper-wrapper">
                    @forelse($heroBanners as $item)
                        @include('front.partials.hero-banner-slide', ['item' => $item, 'slidePath' => $item['path'] ?? ''])
                    @empty
                        @include('front.partials.hero-banner-fallback')
                    @endforelse
                </div>
                <div class="absolute bottom-8 left-1/2 z-20 w-[180px] -translate-x-1/2 md1:bottom-10 md1:w-[220px]">
                    <div class="swiper-pagination banners-pagination"></div>
                </div>
            </div>
        </div>
        <div class="banners-viewport banners-viewport--mobile">
            <div class="swiper banners-swiper banners-swiper--mobile aspect-[3/4] h-auto w-full">
                <div class="swiper-wrapper">
                    @foreach($mobileHeroBanners as $item)
                        @include('front.partials.hero-banner-slide', ['item' => $item, 'slidePath' => $item['path_mobile'] ?? ''])
                    @endforeach
                </div>
                <div class="absolute bottom-3 left-1/2 z-20 w-[140px] -translate-x-1/2 sm6:bottom-4 sm6:w-[160px]">
                    <div class="swiper-pagination banners-pagination"></div>
                </div>
            </div>
        </div>
    @else
        <div class="swiper banners-swiper aspect-[3/4] h-auto w-full md1:aspect-auto md1:h-[520px] md4:h-[620px] lg1:h-[720px]">
            <div class="swiper-wrapper">
                @if($heroBanners->count())
                    @foreach($heroBanners as $item)
                        @include('front.partials.hero-banner-slide', ['item' => $item, 'slidePath' => $item['path'] ?? ''])
                    @endforeach
                @else
                    @include('front.partials.hero-banner-fallback')
                @endif
            </div>
            <div class="absolute bottom-3 left-1/2 z-20 w-[140px] -translate-x-1/2 sm6:bottom-4 sm6:w-[160px] md1:bottom-8 md1:w-[180px] md4:bottom-10 md4:w-[220px]">
                <div class="swiper-pagination banners-pagination"></div>
            </div>
        </div>
    @endif
</section>
@endsection 

@section('content')

{!! static_block_html('index_partners') !!}

@php
    $aboutUsSlides = $aboutUsSlides ?? [];
    if (empty($aboutUsSlides) && !empty($aboutUs)) {
        $aboutUsSlides = [$aboutUs];
    }
@endphp
<section class="w-full bg-white about-us sec-bg-white">
    <div class="mx-auto w-full max-w-[calc(1200px+100px)] px-4 sm2:px-5 md1:px-6">
        <div class="about-us-layout sec-pad py-16">
            <div class="about-us-bg min-w-0 max-w-[1200px]">
                <div class="swiper about-us-swiper">
                    <div class="swiper-wrapper">
                        @foreach($aboutUsSlides as $slide)
                        <div class="swiper-slide">
                            <div class="grid grid-cols-1 items-center gap-10 md4:grid-cols-2 md4:gap-12 lg1:gap-14">
                                <div class="relative pl-5 pb-5 md1:pl-6 md1:pb-6">
                                    <div class="absolute left-0 bottom-0 h-16 w-16 bg-brand-red md1:h-40 md1:w-[100px]" aria-hidden="true"></div>
                                    <div class="relative z-[1] overflow-hidden bg-slate-200 shadow-sm">
                                        <img class="block h-auto w-full object-cover" src="{{ $slide['media_image_url'] ?? '' }}" alt="{{ $slide['title'] ?? 'Brand solutions' }}" loading="lazy" />
                                    </div>
                                </div>

                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-0 bg-[url('{{ front_webp_url('/front/imgs/brands-bg.png') }}')] bg-contain bg-right bg-no-repeat opacity-20" aria-hidden="true"></div>
                                    <div class="relative">
                                        <h2 class="text-[22px] font-extrabold uppercase tracking-wide text-themeText-f sm6:text-[24px] md1:text-[28px] md4:text-[32px]">{{ $slide['title'] ?? '' }}</h2>
                                        <div class="mt-3 h-[7px] w-[46px] rounded bg-brand-red" aria-hidden="true"></div>
                                        <div class="mt-4 text-f16 leading-6 text-themeText-g font-poppins-regular md1:mt-5">{!! $slide['description'] ?? '' !!}</div>

                                        <ul class="mt-5 space-y-3 md1:mt-6 md1:space-y-4">
                                            @foreach(($slide['features'] ?? []) as $row)
                                            <li class="flex items-center gap-3">
                                                <span class="inline-flex h-5 w-5 flex-none items-center justify-center rounded-full">
                                                    <img src="{{ $row['icon_url'] ?? '' }}" alt="" class="h-4 w-4 object-contain" loading="lazy" />
                                                </span>
                                                <p class="text-f14 leading-6 text-themeText-g">{{ $row['text'] ?? '' }}</p>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <a href="{{ $slide['button']['url'] ?? '#' }}" class="about-us-cta" aria-label="Learn more">{{ $slide['button']['text'] ?? 'Learn More' }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-pagination about-us-pagination" aria-hidden="true"></div>
            </div>

            <div class="about-us-controls">
                <button type="button" class="about-us-prev about-us-nav-btn junex-swiper-nav" aria-label="Previous">
                    <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M9 1L2 8l7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button type="button" class="about-us-next about-us-nav-btn junex-swiper-nav" aria-label="Next">
                    <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M1 1l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="w-full bg-[#F7F7F7] home_cates sec-bg-color">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="sec-pad py-16">
        @include('front.partials.section-header', ['section' => section_title('home_product_category')])

        <div class="mt-10 mb-4 grid grid-cols-1 gap-5 md2:grid-cols-2">
            @foreach(($productCategoryCards ?? []) as $card)
            <article class="home_cates_big relative min-h-[282px] h-auto bg-[url('{{ front_webp_url('/front/imgs/jpclbg.png') }}')] bg-center bg-no-repeat bg-cover shadow-sm">
                <div class="home_cates_big_grid grid h-full min-h-[282px] grid-cols-1 sm7:grid-cols-2 max-[600px]:grid max-[600px]:grid-cols-1 max-[600px]:grid-rows-1">
                    <div class="pointer-events-none hidden bg-black/35 max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-10 max-[600px]:block max-[600px]:h-full max-[600px]:w-full" aria-hidden="true"></div>
                    <div class="home_cates_big_img relative flex min-h-[200px] h-full items-center justify-center max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-0">
                        <img class="h-auto max-h-full w-auto max-w-full object-contain" src="{{ $card['image'] ?? '' }}" alt="{{ $card['alt'] ?? '' }}" loading="lazy" />
                    </div>
                    <div class="home_cates_big_text relative flex items-center pr-5 pl-2 py-5 max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-20 max-[600px]:flex max-[600px]:flex-col max-[600px]:items-center max-[600px]:justify-center max-[600px]:text-center">
                        <div class="pointer-events-none absolute inset-0 bg-[url('{{ front_webp_url('/front/imgs/brands-bg.png') }}')] bg-right bg-no-repeat bg-contain opacity-10" aria-hidden="true"></div>
                        <div class="relative">
                            <h3 class="font-poppins-semibold text-f28 uppercase tracking-wide text-brand-navy max-[600px]:text-white">
                                {!! $card['title_html'] ?? '' !!}
                            </h3>
                            <p class="mt-3 line-clamp-3 font-poppins-regular text-xs leading-5 text-themeText-p max-[600px]:text-white/90 sm7:text-[14px]">
                                {!! $card['description'] ?? '' !!}
                            </p>
                            <a href="{{ $card['url'] ?? '#' }}" class="mt-5 inline-flex h-[40px] items-center justify-center bg-brand-dark px-3 font-poppins-regular text-f14 uppercase tracking-wide text-white transition hover:bg-opacity-90 max-[600px]:mx-auto">
                                {{ $card['button_text'] ?? 'Learn More' }}
                            </a>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
    </div>
</section>

<section class="w-full bg-white hot_styles sec-bg-white">
    <div class="mx-auto w-full px-[18px]">
    <div class="sec-pad py-16">
        @include('front.partials.section-header', ['section' => section_title('hot_styles')])

        @php
            $hotStyleTabs = $hotStyleTabs ?? [
                ['key' => 'new', 'label' => 'New Arrivals', 'products' => $hotProducts ?? collect()],
                ['key' => 'best', 'label' => 'Best Sellers', 'products' => $hotProducts ?? collect()],
                ['key' => 'bundles', 'label' => 'Bundles & Save', 'products' => $hotProducts ?? collect()],
            ];
        @endphp

        <div class="hot-styles-tabs-wrap mt-8">
            <div class="hot-styles-tabs" role="tablist" aria-label="Hot styles filters">
                @foreach($hotStyleTabs as $index => $tab)
                <button
                    type="button"
                    role="tab"
                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                    data-hot-tab="{{ $tab['key'] }}"
                    class="hot-styles-tab {{ $index === 0 ? 'is-active' : '' }}"
                >
                    {{ $tab['label'] }}
                </button>
                @endforeach
            </div>
        </div>

        <div class="hot-styles-layout mt-8">
            <div class="hot-styles-stage min-w-0">
                @foreach($hotStyleTabs as $index => $tab)
                <div class="hot-styles-panel {{ $index === 0 ? '' : 'hidden' }}" data-hot-panel="{{ $tab['key'] }}" role="tabpanel">
                    <div class="swiper hot-styles-swiper" data-hot-swiper="{{ $tab['key'] }}">
                        <div class="swiper-wrapper">
                            @forelse(($tab['products'] ?? []) as $p)
                            <div class="swiper-slide h-auto">
                                @include('front.partials.hot-product-card', ['product' => $p])
                            </div>
                            @empty
                            <div class="swiper-slide h-auto">
                                @include('front.partials.hot-product-card', [
                                    'name' => 'OEM Contrast Color Women Sports Bra Custom Gym Wear',
                                    'image' => front_webp_url('/front/imgs/index_rc_01.png'),
                                ])
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="hot-styles-controls">
                <button type="button" class="hot-styles-prev about-us-nav-btn junex-swiper-nav" aria-label="Previous">
                    <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M9 1L2 8l7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button type="button" class="hot-styles-next about-us-nav-btn junex-swiper-nav" aria-label="Next">
                    <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M1 1l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </div>
    </div>
    </div>
</section>

{!! custom_services_html() !!}

@include('front.partials.contact-cta-banner')

@include('front.partials.exciting-updates')

{{-- Video Recommendation 板块暂时隐藏 --}}

<section class="w-full bg-white why_choose sec-bg-white">
    <div class="mx-auto w-full px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="sec-pad py-16">
        @include('front.partials.section-header', [
            'section' => section_title('why_choose'),
            'dividerClass' => 'mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d',
        ])
        <!-- Mobile: stacked layout (force-hidden on desktop to avoid extra height) -->
        <div class="why-choose-mobile mt-10 flex flex-col gap-4 md4:hidden">
        @foreach(($whyChoose['cards'] ?? []) as $row)
        <div class="relative overflow-hidden border border-gray-300">
            <img class="absolute inset-0 h-full w-full object-cover grayscale" src="{{ $row['image_mobile_url'] ?? '' }}" alt="{{ $row['label'] ?? '' }}" loading="lazy" />
            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.2) 100%);"></div>
            <div class="relative flex min-h-[200px] flex-col justify-center p-6">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">{{ $row['label'] ?? '' }}</div>
            <div class="mt-3 text-[26px] font-poppins-extrabold leading-none text-white">{{ $row['value'] ?? '' }} <span class="ml-2 text-[22px] font-poppins-extrabold text-white">{{ $row['value_suffix'] ?? '' }}</span></div>
            <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">{{ $row['description'] ?? '' }}</div>
            </div>
        </div>
        @endforeach
        <div class="flex items-center justify-center bg-themeBg-d py-10 text-center text-white">
            <div>
            <img class="mx-auto h-14 w-14 object-contain" src="{{ $whyChoose['center']['logo_url'] ?? '' }}" alt="Junex" loading="lazy" />
            <div class="mt-3 text-[16px] font-poppins-semibold uppercase tracking-[3px]">{{ $whyChoose['center']['title'] ?? '' }}</div>
            <div class="mx-auto mt-3 h-[1px] w-[40px] bg-white/60"></div>
            <div class="mt-3 text-[11px] leading-5 text-white px-4 font-poppins-regular">{{ $whyChoose['center']['subtitle'] ?? '' }}</div>
            </div>
        </div>
        </div>

        <!-- Desktop: kite layout -->
        <div class="why-choose-desktop relative mx-auto mt-10 hidden md4:block" style="aspect-ratio:1920/1040;">
        @php
            $whyChooseCards = $whyChoose['cards'] ?? [];
            $wc1 = $whyChooseCards[0] ?? [];
            $wc2 = $whyChooseCards[1] ?? [];
            $wc3 = $whyChooseCards[2] ?? [];
            $wc4 = $whyChooseCards[3] ?? [];
        @endphp
        <!-- Left Top: 63.333% wide, 33.33% tall -->
        <div class="absolute left-0 top-0 overflow-hidden border-r border-b border-gray-300" style="width:63.333%;height:33.33%;">
            <div class="absolute inset-0 grayscale" style="background:url('{{ $wc1['background_desktop_url'] ?? '' }}') center/cover no-repeat;"></div>
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="absolute top-1/2 -translate-y-1/2 left-[80px] md2:left-[120px] md4:left-[180px] lg1:left-[240px] lg2:left-[300px]">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">{{ $wc1['label'] ?? '' }}</div>
            <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">{{ $wc1['value'] ?? '' }} <span class="mt-1 text-f42 font-poppins-semibold text-stroke-white">{{ $wc1['value_suffix'] ?? '' }}</span></div>
            <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">{{ $wc1['description'] ?? '' }}</div>
            </div>
        </div>
        <!-- Left Bottom: 36.667% wide, 66.67% tall -->
        <div class="absolute left-0 overflow-hidden border-r border-gray-300" style="width:39%;top:33.33%;height:66.67%;">
            <div class="absolute inset-0 grayscale" style="background:url('{{ $wc2['background_desktop_url'] ?? '' }}') center/cover no-repeat;"></div>
            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(218,43,40,0.5) 0%, rgba(0,0,0,0.4) 100%);"></div>
            <div class="absolute top-1/2 -translate-y-1/2 left-[80px] md2:left-[120px] md4:left-[180px] lg1:left-[240px] lg2:left-[300px]">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">{{ $wc2['label'] ?? '' }}</div>
            <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">{{ $wc2['value'] ?? '' }} <span class="mt-1 text-f42 font-poppins-semibold text-stroke-white">{{ $wc2['value_suffix'] ?? '' }}</span></div>
            <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">{{ $wc2['description'] ?? '' }}</div>
            </div>
        </div>
        <!-- Right Top: 36.667% wide, 66.67% tall -->
        <div class="absolute right-0 top-0 overflow-hidden border-l border-b border-gray-300" style="width:39%;height:66.67%;">
            <div class="absolute inset-0 grayscale" style="background:url('{{ $wc3['background_desktop_url'] ?? '' }}') center/cover no-repeat;"></div>
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="absolute top-1/2 -translate-y-1/2 left-[24px] md2:left-[36px] md4:left-[48px] lg1:left-[64px]">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">{{ $wc3['label'] ?? '' }}</div>
            <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">{{ $wc3['value'] ?? '' }} <div class="mt-1 text-f42 font-poppins-semibold text-stroke-white ">{{ $wc3['value_suffix'] ?? '' }}</div></div>
            <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">{{ $wc3['description'] ?? '' }}</div>
            </div>
        </div>
        <!-- Right Bottom: 63.333% wide, 33.33% tall -->
        <div class="absolute right-0 overflow-hidden border-l border-gray-300" style="width:61%;top:66.67%;height:33.33%;">
            <div class="absolute inset-0 grayscale" style="background:url('{{ $wc4['background_desktop_url'] ?? '' }}') center/cover no-repeat;"></div>
            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(218,43,40,0.5) 0%, rgba(0,0,0,0.4) 100%);"></div>
            <div class="absolute top-1/2 -translate-y-1/2 left-[24px] md2:left-[36px] md4:left-[48px] lg1:left-[64px]">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">{{ $wc4['label'] ?? '' }}</div>
            <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">{{ $wc4['value'] ?? '' }} <span class="mt-1 text-f42 font-poppins-semibold text-stroke-white">{{ $wc4['value_suffix'] ?? '' }}</span></div>
            <div class="mt-3 max-w-[360px] text-f15 leading-5 text-white font-poppins-regular">{{ $wc4['description'] ?? '' }}</div>
            </div>
        </div>
        <!-- Center Red Block -->
        <div class="absolute z-10 flex flex-col items-center justify-center bg-themeBg-d text-center text-white" style="left:39%;top:33.33%;width:22%;height:33.34%;">
            <img class="h-auto w-[200px] object-contain" src="{{ $whyChoose['center']['logo_url'] ?? '' }}" alt="Junex" loading="lazy" />
            <div class="mt-3 text-f12 leading-5 text-white px-4 font-poppins-regular">{{ $whyChoose['center']['description_desktop'] ?? '' }}</div>
        </div>
        </div>
    </div>
    </div>
</section>

{!! static_block_html('ask_us_home') !!}

@endsection 

@section('page-css-footer')

@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js?v=20260929c" defer></script>
@endsection 
</x-layout>
