<x-layout>
@section('tdk')
@include('front.partials.seo-head')
@endsection

@section('page-css-header')
<link type="text/css" rel="stylesheet" href="/front/css/pages/home.css" />
@endsection

@if(isset($pageBanner) && $pageBanner->count())
@section('pagebanner')
@include('front.partials.page-banner-bg')
@endsection
@endif

@section('content')
<section class="w-full breadcrumb bg-[#f7f8fa]">
    <div>
    <div class="mx-auto w-full max-w-[1200px] px-4 py-4 sm2:px-5 md1:px-6 lg1:px-0">
        <nav aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center gap-x-3 gap-y-1">
            <li class="inline-flex items-center">
                <a href="/" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                    <img src="{{ front_webp_url('/front/imgs/breadcrumbs-home.png') }}" alt="Home" class="w-[14px] h-[14px]" />
                    <span class="font-poppins-regular text-f14 text-themeText-p">Home</span>
                </a>
            </li>
            <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </li>
            <li class="inline-flex items-center">
                <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">New Style</span>
            </li>
        </ol>
        </nav>
    </div>
    </div>
</section>

<section class="relative w-full bg-white sec-bg-white">
    <div class="mx-auto w-full max-w-[100%] px-4 py-16 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="text-center">
            <div class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">NEW STYLE</div>
            <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-5 sm6:grid-cols-2 md2:grid-cols-4 lg1:grid-cols-6">
            @foreach(($productsData ?? []) as $row)
                <a href="{{ $row['url'] ?? 'javascript:void(0);' }}" class="group block overflow-hidden border border-slate-200 bg-white transition hover:shadow-sm">
                    <div class="overflow-hidden bg-slate-100">
                        <img class="h-[260px] w-full object-cover transition-transform duration-300 group-hover:scale-110" src="{{ $row['image'] ?? '' }}" alt="{{ $row['alt'] ?? ($row['name'] ?? '') }}" loading="lazy" />
                    </div>
                    <!--
                    <div class="p-4">
                        <div class="text-f16 font-poppins-medium text-themeText-f line-clamp-2">{{ $row['name'] ?? '' }}</div>
                        @if(!empty($row['publish_at']))
                            <div class="mt-2 text-f12 text-themeText-g">{{ $row['publish_at'] }}</div>
                        @endif
                    </div>
                    -->
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            @include('pagination.common', ['paginator' => $products])
        </div>
    </div>
</section>
@endsection
</x-layout>
