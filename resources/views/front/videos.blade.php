<x-layout>
@section('tdk')
@include('front.partials.seo-head')
@endsection

@section('page-css-header')
<link type="text/css" rel="stylesheet" href="/front/css/pages/home.css" />
<style type="text/css">
    .video-list-page .video-card--compact .video-card__title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.75rem;
    }
    .video-list-page .video-card--compact:hover .video-card__play {
        background-color: #D92B28;
        border-color: #D92B28;
        color: #ffffff !important;
    }
    .video-list-page .video-card--compact:hover .video-card__play svg,
    .video-list-page .video-card--compact:hover .video-card__play path {
        color: #ffffff !important;
        fill: #ffffff !important;
    }
</style>
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

<section class="video-list-page w-full bg-white sec-bg-white">
    <div class="sec-pad mx-auto w-full max-w-[1200px] px-4 pt-14 pb-10 sm2:px-5 md1:px-6 md1:pt-16 md1:pb-12 lg1:px-0">
        @php
            $videosHeaderHtml = static_block_html('videos_header');
        @endphp
        @if(trim((string)$videosHeaderHtml) !== '')
            {!! $videosHeaderHtml !!}
        @else
        <div class="mb-8 text-center md1:mb-10">
            <h1 class="text-f28 font-poppins-semibold uppercase tracking-wide text-themeText-f md1:text-f32">Product Videos</h1>
            <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
            <p class="mx-auto mt-4 max-w-[720px] text-f14 font-poppins-regular leading-relaxed text-themeText-g md1:text-f15">
                {{ __('Watch factory showcases, product highlights, and customization workflows from our sportswear production line.') }}
            </p>
        </div>
        @endif

        @if(($videos->total() ?? 0) === 0)
        <div class="py-16 text-center">
            <p class="font-poppins-regular text-f16 text-themeText-g">{{ __('暂无视频') }}</p>
        </div>
        @else
        <div class="grid grid-cols-1 gap-4 sm5:grid-cols-2 md4:grid-cols-3 lg1:grid-cols-4 md1:gap-5">
            @foreach(($videosListData ?? []) as $item)
                @include('front.partials.video-card', ['item' => $item, 'compact' => true])
            @endforeach
        </div>

        <div class="videos-pagination mt-8 [&_>div]:!mt-0 md1:mt-10">
            @include('pagination.common', ['paginator' => $videos])
        </div>
        @endif
    </div>
</section>
@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
@endsection
</x-layout>
