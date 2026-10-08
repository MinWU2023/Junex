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
    <div class="mx-auto w-full max-w-[1200px] px-4 py-4 sm2:px-5 md1:px-6 lg1:px-0">
        <nav aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-x-3 gap-y-1">
                @foreach(($breadcrumbs ?? []) as $index => $crumb)
                    @if($index > 0)
                        <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
                            <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6" /></svg>
                        </li>
                    @endif
                    <li class="inline-flex items-center">
                        @if(!empty($crumb['url']))
                            <a href="{{ $crumb['url'] }}" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                                @if($index === 0)
                                    <img src="{{ front_webp_url('/front/imgs/breadcrumbs-home.png') }}" alt="Home" class="w-[14px] h-[14px]" />
                                @endif
                                <span class="font-poppins-regular text-f14 text-themeText-p">{{ $crumb['label'] }}</span>
                            </a>
                        @else
                            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">{{ $crumb['label'] }}</span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>
    </div>
</section>

<section class="w-full blogs videos bg-white sec-bg-white">
    <div class="sec-pad mx-auto w-full max-w-[1200px] px-4 py-16 sm2:px-5 md1:px-6 lg1:px-0">
        @if(!empty($featuredVideo))
        <article class="w-full bg-themeBg-g">
            <div class="flex flex-col md2:flex-row">
                <a href="javascript:void(0)" class="js-video-modal relative block w-full md2:w-[48%]" data-video-url="{{ $featuredVideo['video_url'] ?? '' }}">
                    <img class="w-full object-cover" src="{{ $featuredVideo['image'] }}" alt="Video cover" loading="lazy" />
                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                        <span class="video-play-btn inline-flex h-14 w-14 items-center justify-center rounded-full border border-white/70 bg-white/20 text-white">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="currentColor"><path d="M8 5v14l11-7L8 5z" /></svg>
                        </span>
                    </div>
                </a>
                <div class="flex w-full flex-col justify-center px-6 py-6 md2:w-[42%] md2:px-10 md2:py-10">
                    <div class="text-f14 font-poppins-regular text-themeText-p">{{ $featuredVideo['date'] ?? '' }}</div>
                    <h2 class="mt-4 text-f34 font-poppins-semibold leading-snug text-themeText-f">
                        <a href="{{ $featuredVideo['url'] ?? '#' }}">{{ $featuredVideo['title'] ?? '' }}</a>
                    </h2>
                    <p class="mt-3 text-f16 leading-5 font-poppins-regular text-themeText-g">{{ $featuredVideo['excerpt'] ?? '' }}</p>
                    <div class="mt-6">
                        <a href="{{ $featuredVideo['url'] ?? '#' }}" class="inline-flex py-2.5 items-center justify-center bg-black px-4 text-f14 font-poppins-regular uppercase tracking-wide text-white">Learn More</a>
                    </div>
                </div>
            </div>
        </article>
        @endif

        <div class="mt-8 flex flex-wrap gap-y-5 md1:mt-10">
            @foreach(($videosListData ?? []) as $item)
            <div class="w-full px-0 md2:w-1/2 md2:px-2 md4:w-1/3">
                @include('front.partials.video-card', ['item' => $item])
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="w-full paginations bg-white sec-bg-white">
    <div class="sec-pad mx-auto w-full max-w-[1200px] px-4 py-16 sm2:px-5 md1:px-6 lg1:px-0">
        @include('pagination.common', ['paginator' => $videos])
    </div>
</section>
@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
@endsection
</x-layout>
