<x-layout>
@section('tdk')
@include('front.partials.seo-head')
@endsection

@section('page-css-header')
<link type="text/css" rel="stylesheet" href="/front/css/pages/home.css" />
@endsection


@section('page-js-header')

@endsection 

@if(isset($pageBanner) && $pageBanner->count())
@section('pagebanner')
@include('front.partials.page-banner-bg')
@endsection
@endif



@section('content')
<section class="w-full breadcrumb bg-themeBg-a md4:bg-themeBg-g">
    <div >
        <div class="mx-auto w-full max-w-[1200px] px-4 py-4 sm2:px-5 md1:px-6 lg1:px-0">
            <nav aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-x-3 gap-y-1">
                @if(isset($breadcrumbs) && count($breadcrumbs))
                    @foreach($breadcrumbs as $index => $crumb)
                        @if($index === 0)
                            <li class="inline-flex items-center">
                                @if(!empty($crumb['url']))
                                    <a href="{{ $crumb['url'] }}" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                                        <img src="{{ front_webp_url('/front/imgs/breadcrumbs-home.png') }}" alt="Home" class="w-[14px] h-[14px]" />
                                        <span class="font-poppins-regular  text-f14 text-themeText-p">{{ $crumb['label'] }}</span>
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-2">
                                        <img src="{{ front_webp_url('/front/imgs/breadcrumbs-home.png') }}" alt="Home" class="w-[14px] h-[14px]" />
                                        <span class="font-poppins-regular  text-f14 text-themeText-p">{{ $crumb['label'] }}</span>
                                    </span>
                                @endif
                            </li>
                        @else
                            <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
                                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </li>
                            <li class="inline-flex items-center">
                                @if(!empty($crumb['url']))
                                    <a href="{{ $crumb['url'] }}" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                                        <span class="font-poppins-regular  text-f14 text-themeText-p">{{ $crumb['label'] }}</span>
                                    </a>
                                @else
                                    <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">{{ $crumb['label'] }}</span>
                                @endif
                            </li>
                        @endif
                    @endforeach
                @else
                <li class="inline-flex items-center">
                <a href="#" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                    <img src="{{ front_webp_url('/front/imgs/breadcrumbs-home.png') }}" alt="Home" class="w-[14px] h-[14px]" />
                    <span class="font-poppins-regular  text-f14 text-themeText-p">Home</span>
                </a>
                </li>

                <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
                </li>

                <li class="inline-flex items-center">
                <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Customer Services</span>
                </li>
                @endif
            </ol>
            </nav>
        </div>
    </div>
    </section>
 
{!! static_block_html('processes') !!}

{!! static_block_html('odm_oem_cus') !!}

{!! static_block_html('sample_stages') !!}

{!! static_block_html('certificates') !!}

<section class="w-full bg-white why_choose sec-bg-white">
    <div class="mx-auto w-full px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="sec-pad py-16">
        <div class="text-center">
        <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
            {{ $whyChoose['title'] ?? '' }}
        </h2>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 max-w-[825px] leading-6 text-slate-600 text-f16 font-poppins-regular text-themeText-g">
            {{ $whyChoose['description'] ?? '' }}
        </p>
        </div>
        <!-- Mobile: stacked layout -->
        <div class="mt-10 flex flex-col gap-4 md4:hidden">
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
        <div class="relative mx-auto mt-10 hidden md4:block" style="aspect-ratio:1920/1040;">
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

{!! static_block_html('defined_services_faqs') !!}

{!! static_block_html('ask_us') !!}

@endsection 

@section('page-css-footer')

@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
<script type="text/javascript">
(function () {
    function leftAlignFullCusSubtitles() {
        var nodes = document.querySelectorAll('section.full_cus p.full-cus-subtitle');
        Array.prototype.forEach.call(nodes, function (p) {
            p.style.setProperty('display', 'block', 'important');
            p.style.setProperty('width', '100%', 'important');
            p.style.setProperty('max-width', '100%', 'important');
            p.style.setProperty('margin-left', '0', 'important');
            p.style.setProperty('margin-right', '0', 'important');
            p.style.setProperty('text-align', 'left', 'important');
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', leftAlignFullCusSubtitles);
    } else {
        leftAlignFullCusSubtitles();
    }
})();
(function () {
    var NAV_PREV_SVG = '<svg class="cs-cert-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>';
    var NAV_NEXT_SVG = '<svg class="cs-cert-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>';

    function ensureCsCertCarousel(el) {
        var section = el.closest('.cs-cert');
        if (!section) return { el: el, prev: null, next: null, pagination: null };

        var carousel = section.querySelector('.cs-cert-carousel');
        var viewport = section.querySelector('.cs-cert-viewport');
        var prev = section.querySelector('.cs-cert-prev');
        var next = section.querySelector('.cs-cert-next');
        var pagination = section.querySelector('.cs-cert-pagination');
        var inner = section.querySelector('.cs-cert-inner');

        if (!carousel) {
            carousel = document.createElement('div');
            carousel.className = 'cs-cert-carousel';
            if (inner && inner.parentNode === section) {
                if (inner.nextSibling) {
                    section.insertBefore(carousel, inner.nextSibling);
                } else {
                    section.appendChild(carousel);
                }
            } else {
                section.appendChild(carousel);
            }
        }

        if (!viewport) {
            viewport = document.createElement('div');
            viewport.className = 'cs-cert-viewport';
            carousel.appendChild(viewport);
        }

        if (el.parentNode !== viewport) {
            viewport.appendChild(el);
        }

        if (!prev) {
            prev = document.createElement('button');
            prev.type = 'button';
            prev.className = 'cs-cert-nav cs-cert-prev';
            prev.setAttribute('aria-label', 'Previous certificates');
            prev.innerHTML = NAV_PREV_SVG;
            carousel.insertBefore(prev, viewport);
        }

        if (!next) {
            next = document.createElement('button');
            next.type = 'button';
            next.className = 'cs-cert-nav cs-cert-next';
            next.setAttribute('aria-label', 'Next certificates');
            next.innerHTML = NAV_NEXT_SVG;
            carousel.appendChild(next);
        }

        if (!pagination) {
            pagination = document.createElement('div');
            pagination.className = 'cs-cert-pagination';
            pagination.setAttribute('aria-label', 'Certificate slides');
            carousel.appendChild(pagination);
        }

        return { el: el, prev: prev, next: next, pagination: pagination };
    }

    function boostSlidesForLoop(el) {
        var wrapper = el.querySelector('.swiper-wrapper');
        if (!wrapper) return;
        var slides = wrapper.querySelectorAll('.swiper-slide');
        if (slides.length === 0 || slides.length >= 8) return;
        var originals = Array.prototype.slice.call(slides);
        originals.forEach(function (slide) {
            wrapper.appendChild(slide.cloneNode(true));
        });
    }

    function initCsCertSwiper() {
        if (typeof Swiper === 'undefined') {
            setTimeout(initCsCertSwiper, 40);
            return;
        }
        var el = document.querySelector('.cs-cert-swiper');
        if (!el || el.dataset.swiperReady === '1') return;
        el.dataset.swiperReady = '1';

        var parts = ensureCsCertCarousel(el);
        boostSlidesForLoop(parts.el);

        new Swiper(parts.el, {
            slidesPerView: 1,
            spaceBetween: 20,
            grabCursor: true,
            watchOverflow: false,
            loop: true,
            loopAdditionalSlides: 4,
            speed: 600,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            navigation: {
                prevEl: parts.prev,
                nextEl: parts.next
            },
            pagination: parts.pagination
                ? {
                    el: parts.pagination,
                    clickable: true,
                }
                : undefined,
            breakpoints: {
                480: { slidesPerView: 2, spaceBetween: 24 },
                992: { slidesPerView: 4, spaceBetween: 16 }
            }
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCsCertSwiper);
    } else {
        initCsCertSwiper();
    }
})();
</script>
@endsection 
</x-layout>
