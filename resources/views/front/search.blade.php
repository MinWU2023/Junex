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
                <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Products</span>
                </li>
                @endif
            </ol>
            </nav>
        </div>
    </div>
</section>

@php
    $hasSearchResults = isset($products) && method_exists($products, 'total') ? $products->total() > 0 : count($productsData ?? []) > 0;
@endphp

@if($hasSearchResults)
<section class="w-full bg-themeBg-a product_list">
    <div class="mx-auto w-[calc(100%-30px)] max-w-[1200px] pt-8 md1:pt-10 md4:pt-[64px]">
        <div class="grid grid-cols-1 sm5:grid-cols-2 md4:grid-cols-3 lg1:grid-cols-4 gap-4">
            @foreach(($productsData ?? []) as $p)
                <a href="{{ $p['url'] }}" class="group block">
                    <div class="relative overflow-hidden bg-themeBg-f">
                        <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="{{ $p['image'] }}" alt="{{ $p['name'] }}" loading="lazy" />
                        <button type="button"
                                class="collect-btn js-prefer-toggle absolute top-[16px] right-[16px] z-10 flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white cursor-pointer"
                                aria-label="Collect"
                                data-product-id="{{ $p['id'] }}"
                                data-favorite="{{ $p['is_favorited'] ? '1' : '0' }}">
                            <img class="uncollect-icon h-[15px] w-[16px] {{ $p['is_favorited'] ? 'hidden' : '' }}" src="{{ front_webp_url('/front/icons/uncollect.png') }}" alt="Uncollect" />
                            <img class="collect-icon h-[15px] w-[16px] {{ $p['is_favorited'] ? '' : 'hidden' }}" src="{{ front_webp_url('/front/icons/collect.png') }}" alt="Collect" />
                        </button>
                    </div>
                    <div class="py-3">
                        <h4 class="text-f16 font-poppins-medium text-themeText-f leading-6">{{ $p['name'] }}</h4>
                    </div>
                </a>
            @endforeach
        </div>

        @include('pagination.common', ['paginator' => $products])
    </div>
</section>

{!! static_block_html('custom_serrvices') !!}

<section class="w-full bg-white why_choose">
    <div class="mx-auto w-full px-4 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="pt-6 md1:pt-10 md4:pt-14">
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
@else
<section class="w-full bg-white sec-bg-white">
    <div class="mx-auto w-full max-w-[1200px] px-4 py-14 sm2:px-5 md1:px-6 md1:py-20 lg1:px-0 lg1:py-24">
        <div class="flex flex-col items-center gap-10 md3:flex-row md3:items-center md3:justify-between md3:gap-12 lg1:gap-16">
            <div class="order-2 w-full flex-1 text-center md3:order-1 md3:text-left">
                <div class="inline-flex items-center rounded-full bg-[#FEECEC] px-4 py-1.5 text-f12 font-poppins-semibold uppercase tracking-[0.18em] text-themeBg-d md1:text-f14">
                    No Products
                </div>
                <h1 class="mt-5 text-f32 font-poppins-extrabold leading-tight text-themeText-a sm6:text-f36 md1:text-f40 lg1:text-f48">
                    No Matching Products
                </h1>
                <p class="mx-auto mt-4 max-w-xl text-f15 font-poppins-regular leading-relaxed text-themeText-g md1:mt-5 md1:text-f16 md3:mx-0">
                    @if(!empty($q))
                        Sorry, we could not find any products for "{{ $q }}". Try another keyword, or browse our catalog to find the styles you need.
                    @else
                        Sorry, there are no products to show right now. Please browse our catalog or return to the homepage.
                    @endif
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-3 md3:justify-start md1:mt-10">
                    <a
                        href="{{ route('home') }}"
                        class="inline-flex h-12 min-w-[200px] items-center justify-center rounded-none bg-themeBg-d px-8 text-f14 font-poppins-semibold uppercase tracking-wide text-white transition hover:bg-[#c22522] md1:h-[52px] md1:px-10 md1:text-f15"
                    >
                        Back to Homepage
                    </a>
                    <a
                        href="{{ route('products') }}"
                        class="inline-flex h-12 min-w-[200px] items-center justify-center rounded-none border border-themeBg-d bg-white px-8 text-f14 font-poppins-semibold uppercase tracking-wide text-themeText-a transition hover:bg-themeBg-d hover:text-white md1:h-[52px] md1:px-10 md1:text-f15"
                    >
                        View Products
                    </a>
                </div>
            </div>

            <div class="order-1 flex w-full flex-1 justify-center md3:order-2 md3:justify-end">
                <div class="relative w-full max-w-[420px]">
                    <div class="pointer-events-none absolute -inset-3 rounded-[28px] bg-gradient-to-br from-[#FEECEC] via-white to-[#F7F8FA] md1:-inset-4" aria-hidden="true"></div>
                    <img
                        src="{{ front_webp_url('/front/imgs/no-products-illustration.svg') }}"
                        alt="No products"
                        class="relative z-[1] h-auto w-full max-w-[420px] object-contain"
                        width="420"
                        height="315"
                        loading="lazy"
                    />
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{!! static_block_html('defined_services_faqs') !!}

{!! static_block_html('ask_us') !!}
@endsection 

@section('page-css-footer')

@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
@endsection 
</x-layout>
