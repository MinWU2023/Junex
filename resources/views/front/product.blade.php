<x-layout>
@section('tdk')
@include('front.partials.seo-head')
@endsection

@section('page-css-header')
<link type="text/css" rel="stylesheet" href="/front/css/pages/home.css" />
{{-- Scoped TinyMCE template styles (Bootstrap + moban); under .product-highlights-content / .product-details-content --}}
<link type="text/css" rel="stylesheet" href="/front/css/product-highlights.css" />
<link type="text/css" rel="stylesheet" href="/tinymce/tpl/css/det_font-awesome.min.css" />
@endsection

@section('page-js-header')

@endsection 

@if(isset($pageBanner) && $pageBanner->count())
@section('pagebanner')
@include('front.partials.page-banner-bg')
@endsection
@endif

<input id="product_id" type="hidden" value="{{ $product['id'] }}" />

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
            <a href="#" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                <span class="font-poppins-regular  text-f14 text-themeText-p">Products</span>
            </a>
            </li>

            <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
            <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18l6-6-6-6" />
            </svg>
            </li>

            <li class="inline-flex items-center">
            <a href="#" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                <span class="font-poppins-regular  text-f14 text-themeText-p">Sports Bra</span>
            </a>
            </li>

            <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
            <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18l6-6-6-6" />
            </svg>
            </li>
            
            <li class="inline-flex items-center">
            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Popular Ruched Front Sports Bra Halter Neckline 2024 China Manufacturer</span>
            </li>
            @endif
        </ol>
        </nav>
    </div>
    </div>
</section>

<section class="relative w-full bg-white baseinfo sec-bg-white">
    <div class="mx-auto w-full max-w-[1200px] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
    <div class="pdp-shell sec-pad">
        <div class="pdp-layout">
        <div class="pdp-gallery">
            <div class="swiper productMainSwiper">
            <div class="swiper-wrapper">
                @foreach(($productImagesData ?? []) as $img)
                <div class="swiper-slide">
                <div class="pdp-main-frame">
                    <img class="pdp-main-img" src="{{ $img['url'] ?? '' }}" alt="{{ $img['alt'] ?? 'Product' }}" loading="lazy" />
                </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-prev !left-2 !h-[42px] !w-[42px] !rounded-none bg-black/50 !text-white after:!content-[''] [&.swiper-button-disabled]:bg-white/50 [&.swiper-button-disabled]:!text-black">
                <svg class="w-[10px] h-[16px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </div>
            <div class="swiper-button-next !right-2 !h-[42px] !w-[42px] !rounded-none bg-black/50 !text-white after:!content-[''] [&.swiper-button-disabled]:bg-white/50 [&.swiper-button-disabled]:!text-black">
                <svg class="w-[10px] h-[16px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            </div>
            </div>

            <div class="pdp-thumbs swiper productThumbSwiper">
            <div class="swiper-wrapper">
                @foreach(($productImagesData ?? []) as $img)
                <div class="swiper-slide !w-auto cursor-pointer">
                <div class="pdp-thumb">
                    <img class="pdp-thumb-img" src="{{ $img['url'] ?? '' }}" alt="{{ $img['alt'] ?? 'Thumb' }}" loading="lazy" />
                </div>
                </div>
                @endforeach
            </div>
            </div>
        </div>

        <div class="pdp-info">
            <h1 class="pdp-title">{{ $product->name ?? '' }}</h1>

            <div class="pdp-share">
                @include('front.partials.product-share-bar')
            </div>

            <dl class="pdp-specs">
                @foreach(($productAttributesData ?? []) as $row)
                <div class="pdp-spec-row">
                    <dt class="attr-label">{{ $row['label'] ?? '' }}</dt>
                    <dd class="attr-value">
                        @if(!empty($row['url']))
                            <a href="{{ $row['url'] }}" class="transition hover:text-themeText-h">{{ $row['value'] ?? '' }}</a>
                        @else
                            {{ $row['value'] ?? '' }}
                        @endif
                    </dd>
                </div>
                @endforeach
            </dl>

            <div class="pdp-actions">
                <button id="quoteNowBtn" type="button" class="pdp-btn-quote group">
                <img src="{{ front_webp_url('/front/icons/QuoteNow.svg') }}" class="w-[19px] h-[18px] brightness-0 invert group-hover:invert-0" alt="" />
                QUOTE NOW
                </button>
                @php
                    $pdpInquiryImage = (string) (($productImagesData[0]['url'] ?? '') ?: '');
                    $pdpInquiryUrl = '/' . ltrim((string) (optional($product->url)->url ?? ''), '/');
                    if ($pdpInquiryUrl === '/') {
                        $pdpInquiryUrl = request()->getRequestUri() ?: '#';
                    }
                    $pdpInquiryModel = (string) ($product->url_key ?? '');
                @endphp
                <button type="button"
                        class="js-inquiry-pdp-toggle pdp-btn-fav"
                        data-product-id="{{ $product->id ?? 0 }}"
                        data-product-name="{{ $product->name ?? '' }}"
                        data-product-image="{{ $pdpInquiryImage }}"
                        data-product-url="{{ $pdpInquiryUrl }}"
                        data-product-model="{{ $pdpInquiryModel }}"
                        data-in-inquiry="0"
                        aria-label="Add to inquiry">
                <svg class="inquiry-pdp-icon h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M7.5 19.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Zm9 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" fill="white"/>
                    <path d="M3.2 3.2h1.86c.64 0 1.2.43 1.36 1.05l.28 1.05h12.55c.86 0 1.5.8 1.3 1.63l-1.4 5.9a1.4 1.4 0 0 1-1.36 1.07H8.55l.22.82c.16.62.72 1.05 1.36 1.05h8.62a.9.9 0 1 1 0 1.8H9.91a3.2 3.2 0 0 1-3.1-2.4L4.86 4.7H3.2a.9.9 0 1 1 0-1.8Zm3.7 3.9.78 2.95h9.55l1.05-4.4H7.28l-.38 1.45Z" fill="white"/>
                </svg>
                <span class="inquiry-pdp-text">ADD TO INQUIRY</span>
                </button>
            </div>
        </div>
        </div>
    </div>
    </div>
</section>

<section class="relative w-full bg-white pdp-content-with-sidebar sec-bg-white">
    <div class="mx-auto w-full max-w-[1200px] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
    <div class="sec-pad py-16">
        <div class="flex flex-col gap-[50px] md4:flex-row md4:items-start">
            @include('front.partials.product-list-sidebar', [
                'sidebarCategories' => $sidebarCategories ?? [],
                'sidebarRecommendProducts' => $sidebarRecommendProducts ?? [],
                'activeCategoryId' => $activeCategoryId ?? null,
            ])

            <div class="order-1 min-w-0 flex-1 md4:order-2">
        <div class="pro_detail">
        <div class="pdp-section-head">
        <div class="pdp-section-icon">
            <img src="{{ front_webp_url('/front/icons/JUNEXWomensYogaBrasSizeReference.svg') }}" class="h-5 w-5 brightness-0 invert" alt="" />
        </div>
        <h2 class="pdp-section-title">Product Introduction</h2>
        </div>

        <div class="mt-4 product-highlights-content">{!! $productIntroHtml ?? '' !!}</div>
        <!--
        <div class="mt-8 w-full overflow-hidden bg-white">
        <table class="w-full border-collapse [&_td]:border [&_td]:border-themeBorder-a">
            <tbody>
            <tr class="border-b border-black/5">
                <td class="w-1/4 min-w-[140px] px-4 py-3 text-f14 text-themeText-b sm6:w-1/3 sm6:px-6 md4:w-[380px]">Item</td>
                <td class="px-4 py-3 text-[15px] text-themeText-p font-poppins-regular sm6:px-6">JUNEX 2026 S/S Women Sportswear Collection</td>
            </tr>
            <tr class="border-b border-black/5 bg-themeBg-g/50">
                <td class="px-4 py-3.5 text-f14 text-themeText-g sm6:px-6">Design</td>
                <td class="px-4 py-3 text-[15px] text-themeText-p font-poppins-regular sm6:px-6">ODM / OEM /Design</td>
            </tr>
            <tr class="border-b border-black/5">
                <td class="px-4 py-3.5 text-f14 text-themeText-g sm6:px-6">Fabric</td>
                <td class="px-4 py-3 text-[15px] text-themeText-p font-poppins-regular sm6:px-6">75%nylon 25%spandex</td>
            </tr>
            <tr class="border-b border-black/5 bg-themeBg-g/50">
                <td class="px-4 py-3.5 text-f14 text-themeText-g sm6:px-6">Function</td>
                <td class="px-4 py-3 text-[15px] text-themeText-p font-poppins-regular sm6:px-6">Absorbent moisture, medium pressure, not easy to change color deformation</td>
            </tr>
            <tr class="border-b border-black/5">
                <td class="px-4 py-3.5 text-f14 text-themeText-g sm6:px-6">Technical -Four way stretch</td>
                <td class="px-4 py-4 text-f14 leading-6 text-themeText-a sm6:px-6">stretchy both vertically and horizontally which gives amazing flexibility and elasticity. It allows for a full range of motion to make your training as good as possible.</td>
            </tr>
            <tr class="border-b border-black/5 bg-themeBg-g/50">
                <td class="px-4 py-3.5 text-f14 text-themeText-g sm6:px-6">Color</td>
                <td class="px-4 py-3 text-[15px] text-themeText-p font-poppins-regular sm6:px-6">Optional,can be customized as Pantone No.</td>
            </tr>
            <tr class="border-b border-black/5">
                <td class="px-4 py-3.5 text-f14 text-themeText-g sm6:px-6">Size</td>
                <td class="px-4 py-3 text-[15px] text-themeText-p font-poppins-regular sm6:px-6">Optional: XS-XXXL</td>
            </tr>
            <tr class="border-b border-black/5 bg-themeBg-g/50">
                <td class="px-4 py-3.5 text-f14 text-themeText-g sm6:px-6">Packing</td>
                <td class="px-4 py-3 text-[15px] text-themeText-p font-poppins-regular sm6:px-6">1pc/polybag , 80pcs/carton or to be packed as requirements.</td>
            </tr>
            <tr class="border-b border-black/5">
                <td class="px-4 py-3.5 text-f14 text-themeText-g sm6:px-6">MOQ</td>
                <td class="px-4 py-3 text-[15px] text-themeText-p font-poppins-regular sm6:px-6">200 PCS</td>
            </tr>
            <tr class="border-b border-black/5 bg-themeBg-g/50">
                <td class="px-4 py-3.5 text-f14 text-themeText-g sm6:px-6">Shipping</td>
                <td class="px-4 py-3 text-[15px] text-themeText-p font-poppins-regular sm6:px-6">By sear, by air, by DHL/UPS/TNT etc.</td>
            </tr>
            <tr class="border-b border-black/5">
                <td class="px-4 py-3.5 text-f14 text-themeText-g sm6:px-6">Delivery time</td>
                <td class="px-4 py-3 text-[15px] text-themeText-p font-poppins-regular sm6:px-6">Within 30-35 days after comforming the details of the pre production sample</td>
            </tr>
            <tr>
                <td class="px-4 py-3.5 text-f14 text-themeText-g sm6:px-6">Payment terms</td>
                <td class="px-4 py-3 text-[15px] text-themeText-p font-poppins-regular sm6:px-6">T/T, Paypal, Western Union.</td>
            </tr>
            </tbody>
        </table>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-[30px] md1:mt-10">
            <div class="w-full overflow-hidden bg-themeBg-g">
                <img class="h-auto w-full object-cover" src="{{ front_webp_url('/front/imgs/pro_detail_01.png') }}" alt="Product Detail" loading="lazy" />
            </div>
            <div class="w-full overflow-hidden bg-themeBg-g">
                <img class="h-auto w-full object-cover" src="{{ front_webp_url('/front/imgs/pro_detail_02.png') }}" alt="Product Detail" loading="lazy" />
            </div>
            <div class="w-full overflow-hidden bg-themeBg-g">
                <img class="h-auto w-full object-cover" src="{{ front_webp_url('/front/imgs/pro_detail_03.png') }}" alt="Product Detail" loading="lazy" />
            </div>
            <div class="w-full overflow-hidden bg-themeBg-g">
                <img class="h-auto w-full object-cover" src="{{ front_webp_url('/front/imgs/pro_detail_04.png') }}" alt="Product Detail" loading="lazy" />
            </div>
        </div>
        -->
        </div>

        <div class="product-details mt-6 md1:mt-8">
            <div class="pdp-section-head">
                <div class="pdp-section-icon">
                    <img src="{{ front_webp_url('/front/icons/ProductIntroduction.svg') }}" class="h-5 w-5 brightness-0 invert" alt="" />
                </div>
                <h2 class="pdp-section-title">Product Details</h2>
            </div>
            <div class="product-details-content mt-2">{!! $productDetailsHtml ?? '' !!}</div>
        </div>
            </div>
        </div>
    </div>
    </div>
</section>

@if(!empty($productFaqsData))
<section class="product-faqs sec-bg-white" aria-label="FAQ">
    <div class="mx-auto w-full max-w-[1200px] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
        <div class="product-faqs-inner sec-pad">
            <div class="pdp-section-head">
                <div class="pdp-section-icon">
                    <img src="{{ front_webp_url('/front/icons/JUNEXWomensYogaBrasSizeReference.svg') }}" class="h-5 w-5 brightness-0 invert" alt="" />
                </div>
                <h2 class="pdp-section-title">FAQ</h2>
            </div>
            <div class="product-faqs-panel">
                @foreach($productFaqsData as $faq)
                    <div class="product-faq-accordion faq-accordion">
                        <button type="button" class="product-faq-trigger faq-trigger" aria-expanded="false">
                            <span class="product-faq-subject">{{ $faq['subject'] ?? '' }}</span>
                            <svg class="product-faq-icon faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="product-faq-content faq-content hidden">
                            <div class="product-faq-answer">{!! $faq['content'] ?? '' !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if(!empty($productTagsData))
<section class="product-tags sec-bg-white" aria-label="Product Tags">
    <div class="mx-auto w-full max-w-[1200px] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
        <div class="product-tags-inner sec-pad">
            <div class="pdp-section-head">
                <div class="pdp-section-icon">
                    <img src="{{ front_webp_url('/front/icons/blog-tags.svg') }}" class="h-5 w-5 brightness-0 invert" alt="" />
                </div>
                <h2 class="pdp-section-title">Product Tags</h2>
            </div>
            <div class="product-tags-list">
                @foreach($productTagsData as $tag)
                    <a href="{{ $tag['url'] ?? 'javascript:void(0);' }}" class="product-tag-link" title="{{ $tag['name'] ?? '' }}">
                        {{ $tag['name'] ?? '' }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<section class="relative w-full bg-white pro_recommend sec-bg-white">
    <div class="mx-auto w-full max-w-[1200px] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
    <div class="sec-pad py-16">
        <div class="relative flex items-center gap-3 bg-themeBg-g py-2 pl-[62px]">
        <div class="absolute left-0 top-[-8px] flex h-[50px] w-[50px] items-center justify-center bg-themeBg-d">
            <img src="{{ front_webp_url('/front/icons/RelatedProducts.svg') }}" class="h-5 w-5 brightness-0 invert" alt="" />
        </div>
        <h2 class="text-f22 font-poppins-medium text-themeText-f">Related Products</h2>
        </div>

        <div class="relative mt-8 md1:mt-10">
        <div class="swiper recommendSwiper">
            <div class="swiper-wrapper">
            @foreach(($recommendProductsData ?? []) as $p)
            <div class="swiper-slide h-auto">
                @include('front.partials.product-list-card', [
                    'p' => $p,
                    'imageClass' => 'w-full h-auto transition-transform duration-300 group-hover:scale-105',
                ])
            </div>
            @endforeach
            </div>
        </div>
        <div class="recommend-prev absolute left-0 top-1/2 z-10 flex !h-[42px] !w-[42px] -translate-y-[calc(50%+30px)] cursor-pointer items-center justify-center junex-swiper-nav transition">
            <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 1L2 8l7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="recommend-next absolute right-0 top-1/2 z-10 flex !h-[42px] !w-[42px] -translate-y-[calc(50%+30px)] cursor-pointer items-center justify-center junex-swiper-nav transition">
            <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        </div>
    </div>
    </div>
</section>

{!! static_block_html('ask_us') !!}

@endsection 

@section('page-css-footer')

@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof window.Swiper !== 'undefined') {
            var thumbSwiper = new window.Swiper('.productThumbSwiper', {
                slidesPerView: 'auto',
                spaceBetween: 8,
                watchOverflow: true,
            });

            new window.Swiper('.productMainSwiper', {
                slidesPerView: 1,
                spaceBetween: 0,
                watchOverflow: false,
                rewind: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    prevEl: '.productMainSwiper .swiper-button-prev',
                    nextEl: '.productMainSwiper .swiper-button-next',
                },
                thumbs: {
                    swiper: thumbSwiper,
                }
            });

            (function () {
                var el = document.querySelector('.recommendSwiper');
                if (!el) return;
                var host = el.closest('.relative') || el.parentElement;
                var base = {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    speed: 500,
                    breakpoints: {
                        768: { slidesPerView: 2 },
                        992: { slidesPerView: 4 },
                    },
                    navigation: {
                        prevEl: '.recommend-prev',
                        nextEl: '.recommend-next',
                    },
                };
                var opts = window.JunexSwiper
                    ? window.JunexSwiper.withAutoNav(base, el, host, 'recommend')
                    : Object.assign({ autoplay: { delay: 3500, disableOnInteraction: false } }, base);
                var swiper = new window.Swiper(el, opts);
                if (window.JunexSwiper) window.JunexSwiper.startAutoplay(swiper);
            })();
        }

        var quoteBtn = document.getElementById('quoteNowBtn');
        if (quoteBtn) {
            quoteBtn.addEventListener('click', function () {
                var askUs = document.querySelector('.ask_us');
                if (!askUs) return;
                askUs.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        }

        document.addEventListener('click', function (e) {
            var trigger = e.target && e.target.closest ? e.target.closest('.faq-trigger') : null;
            if (!trigger) return;
            var accordion = trigger.closest ? trigger.closest('.faq-accordion') : null;
            if (!accordion) return;
            var content = accordion.querySelector('.faq-content');
            if (!content) return;
            var expanded = trigger.getAttribute('aria-expanded') === 'true';
            trigger.setAttribute('aria-expanded', expanded ? 'false' : 'true');
            content.classList.toggle('hidden', expanded);
            var icon = trigger.querySelector('.faq-icon');
            if (icon && icon.classList) {
                icon.classList.toggle('rotate-180', !expanded);
            }
        });

        // 非移动端：左侧栏顶到「固定头部下方」后固定，宽高不变；上滚逆向还原
        (function initPdpSidebarSticky() {
            var section = document.querySelector('.pdp-content-with-sidebar');
            var sidebar = section && section.querySelector('.product-list-sidebar');
            if (!section || !sidebar) return;

            var row = sidebar.parentElement;
            if (!row) return;
            if (window.getComputedStyle(row).position === 'static') {
                row.style.position = 'relative';
            }

            var mq = window.matchMedia('(min-width: 992px)');
            var ph = document.createElement('div');
            ph.setAttribute('aria-hidden', 'true');
            ph.className = 'pdp-sidebar-ph';
            ph.style.cssText = 'display:none;flex-shrink:0;';
            row.insertBefore(ph, sidebar);

            var mode = 'static';

            function getStickyTop() {
                var offset = 0;
                var nodes = document.querySelectorAll('.mobile-nav, .pagebanner > header, body > header, header');
                for (var i = 0; i < nodes.length; i++) {
                    var el = nodes[i];
                    var cs = window.getComputedStyle(el);
                    if (cs.display === 'none' || cs.visibility === 'hidden' || cs.opacity === '0') continue;
                    var pos = cs.position;
                    var rect = el.getBoundingClientRect();
                    if ((pos === 'fixed' || pos === 'sticky') && rect.bottom > offset && rect.top < 120) {
                        offset = Math.max(offset, Math.ceil(rect.bottom));
                    }
                }
                // 桌面端头部若尚未写成 fixed，仍按头部实际高度预留（避免被导航挡住）
                if (offset <= 0 && mq.matches) {
                    var desktopHeader = document.querySelector('.pagebanner > header');
                    if (desktopHeader) {
                        var dcs = window.getComputedStyle(desktopHeader);
                        if (dcs.display !== 'none') {
                            offset = Math.ceil(desktopHeader.offsetHeight) || 92;
                        }
                    }
                }
                return offset;
            }

            function toStatic() {
                mode = 'static';
                ph.style.display = 'none';
                ph.style.width = '';
                ph.style.height = '';
                ph.style.order = '';
                sidebar.style.position = '';
                sidebar.style.top = '';
                sidebar.style.bottom = '';
                sidebar.style.left = '';
                sidebar.style.width = '';
                sidebar.style.zIndex = '';
                sidebar.style.boxSizing = '';
            }

            function ensurePlaceholder(w, h) {
                ph.style.display = 'block';
                ph.style.width = w + 'px';
                ph.style.height = h + 'px';
                ph.style.order = window.getComputedStyle(sidebar).order;
            }

            function applyFixedStyles(left, width, stickyTop) {
                sidebar.style.position = 'fixed';
                sidebar.style.top = stickyTop + 'px';
                sidebar.style.bottom = 'auto';
                sidebar.style.left = left + 'px';
                sidebar.style.width = width + 'px';
                sidebar.style.zIndex = '5';
                sidebar.style.boxSizing = 'border-box';
                mode = 'fixed';
            }

            function toFixed(stickyTop) {
                var rect = sidebar.getBoundingClientRect();
                var w = rect.width;
                var h = rect.height;
                ensurePlaceholder(w, h);
                applyFixedStyles(rect.left, w, stickyTop);
            }

            function toAbsolute() {
                var w = ph.offsetWidth || sidebar.offsetWidth;
                var h = sidebar.offsetHeight;
                ensurePlaceholder(w, h);
                sidebar.style.position = 'absolute';
                sidebar.style.top = 'auto';
                sidebar.style.bottom = '0px';
                sidebar.style.left = '0px';
                sidebar.style.width = w + 'px';
                sidebar.style.zIndex = '5';
                sidebar.style.boxSizing = 'border-box';
                mode = 'absolute';
            }

            function update() {
                if (!mq.matches) {
                    if (mode !== 'static') toStatic();
                    return;
                }

                var stickyTop = getStickyTop();
                section.style.setProperty('--pdp-sticky-top', stickyTop + 'px');

                var anchor = mode === 'static' ? sidebar : ph;
                var aRect = anchor.getBoundingClientRect();
                var rowRect = row.getBoundingClientRect();
                var sideH = mode === 'static'
                    ? sidebar.offsetHeight
                    : (parseFloat(ph.style.height) || sidebar.offsetHeight);

                // 顶到固定头部下沿才悬停；上滚超过该线则还原
                if (aRect.top > stickyTop) {
                    if (mode !== 'static') toStatic();
                    return;
                }

                // 内容区底部：为头部预留下方空间后贴底
                if (rowRect.bottom <= sideH + stickyTop) {
                    if (mode === 'static') toFixed(stickyTop);
                    if (mode !== 'absolute') toAbsolute();
                    return;
                }

                if (mode !== 'fixed') {
                    if (mode === 'absolute') {
                        applyFixedStyles(ph.getBoundingClientRect().left, ph.offsetWidth, stickyTop);
                    } else {
                        toFixed(stickyTop);
                    }
                } else {
                    sidebar.style.top = stickyTop + 'px';
                    sidebar.style.left = ph.getBoundingClientRect().left + 'px';
                    sidebar.style.width = ph.offsetWidth + 'px';
                }
            }

            var ticking = false;
            function requestUpdate() {
                if (ticking) return;
                ticking = true;
                window.requestAnimationFrame(function () {
                    ticking = false;
                    update();
                });
            }

            window.addEventListener('scroll', requestUpdate, { passive: true });
            window.addEventListener('resize', function () {
                if (mode !== 'static') toStatic();
                requestUpdate();
            });
            if (mq.addEventListener) mq.addEventListener('change', requestUpdate);
            else if (mq.addListener) mq.addListener(requestUpdate);

            requestUpdate();
        })();
    });
</script>
@endsection 
</x-layout>
