<x-layout>
@section('tdk')
<title>{{ $tdk['title'] ?? '' }}</title>
@if(!empty($tdk['description']))
<meta name="description" content="{{ $tdk['description'] }}" />
@endif
@if(!empty($tdk['keywords']))
<meta name="keywords" content="{{ $tdk['keywords'] }}" />
@endif
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
    <div>
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
                    <a href="/" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
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
                    <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">{{ $pageName ?? '' }}</span>
                    </li>
                @endif
            </ol>
            </nav>
        </div>
    </div>
</section>
<section class="relative w-full spage_main">
    <div class="mx-auto w-full max-w-[1200px] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
    <div class="py-10 md1:py-12 md4:py-14">
        <div class="w-full bg-themeBg-f px-4 pt-6  pb-8 ring-1 ring-black/5 sm6:px-8 md1:px-10 md1:pt-8  md1:pt-10 md4:px-12 md4:pt-10 md4:pb-14">
        <article class="flex flex-col">
            <h1 class="text-f24 font-poppins-medium uppercase text-themeText-b">{{ $pageName ?? '' }}</h1>
            <p class="my-4 text-f16 font-poppins-medium text-themeText-b md1:my-5">Last updated: {{ $createdLabel ?? '' }}</p>
            {!! $pageContent ?? '' !!}
        </article>
        </div>
    </div>
    </div>
</section>
@endsection 

@section('page-css-footer')

@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
@endsection 
</x-layout>
