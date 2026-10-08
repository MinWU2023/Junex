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

<section class="w-full blog_main video_main bg-white sec-bg-white">
    <div class="sec-pad mx-auto w-full max-w-[1200px] px-4 py-16 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="flex flex-col gap-8 md4:flex-row md4:gap-[26px]">
            <main class="w-full md4:w-[860px]">
                <article class="bg-white">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center gap-2 text-f14 text-themeText-p font-poppins-regular">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 7V3m8 4V3" /><path d="M4 11h16" /><path d="M5 5h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" /></svg>
                            <span>{{ $videoDate ?? '' }}</span>
                        </div>
                        <h1 class="mx-auto mt-4 max-w-[720px] leading-snug font-poppins-medium text-f28 text-themeText-f">{{ $videoTitle ?? '' }}</h1>
                    </div>

                    <a href="javascript:void(0)" class="js-video-modal relative mt-6 block overflow-hidden bg-slate-200 md1:mt-8" data-video-url="{{ $videoUrl ?? '' }}">
                        @php
                            $coverSrc = $videoCover ?? '';
                            $ytHq = youtube_thumbnail_url($videoUrl ?? '', 'hqdefault');
                            $coverFallback = front_webp_url('/front/imgs/video-item.png');
                        @endphp
                        <img
                            class="h-[240px] w-full object-cover md1:h-[320px] md2:h-[360px]"
                            src="{{ $coverSrc }}"
                            alt="{{ $videoTitle ?? 'Video cover' }}"
                            loading="lazy"
                            data-fallback-hq="{{ $ytHq }}"
                            data-fallback-local="{{ $coverFallback }}"
                            onerror="if(this.dataset.fallbackHq && this.src!==this.dataset.fallbackHq){this.src=this.dataset.fallbackHq;}else if(this.dataset.fallbackLocal && this.src!==this.dataset.fallbackLocal){this.src=this.dataset.fallbackLocal;}else{this.onerror=null;}"
                        />
                        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                            <span class="inline-flex h-14 w-14 items-center justify-center rounded-full border border-white/70 bg-white/20 text-white">
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="currentColor"><path d="M8 5v14l11-7L8 5z" /></svg>
                            </span>
                        </div>
                    </a>

                    @if(!empty(trim(strip_tags((string)($videoIntroHtml ?? '')))))
                    <div class="mt-8 space-y-5 text-[14px] leading-6 text-themeText-g font-poppins-regular">
                        {!! $videoIntroHtml !!}
                    </div>
                    @endif

                    @if(!empty(trim(strip_tags((string)($videoDetailHtml ?? '')))))
                    <div class="mt-8 space-y-5 text-[14px] leading-6 text-themeText-g font-poppins-regular">
                        {!! $videoDetailHtml !!}
                    </div>
                    @endif

                    @if(!empty($relatedProductsData))
                    <div class="mt-10">
                        <div class="text-f18 font-poppins-medium uppercase tracking-wide text-themeText-h">Related Products</div>
                        <div class="mt-5 grid grid-cols-1 gap-4 sm5:grid-cols-2">
                            @foreach($relatedProductsData as $p)
                            <a href="{{ $p['url'] ?? '#' }}" class="flex items-center gap-4 bg-themeBg-g p-3 transition hover:bg-slate-200">
                                <img class="h-[70px] w-[70px] object-cover" src="{{ $p['image'] ?: front_webp_url('/front/imgs/index_rc_01.png') }}" alt="{{ $p['name'] ?? '' }}" loading="lazy" />
                                <div class="line-clamp-2 text-f14 font-poppins-medium text-themeText-f">{{ $p['name'] ?? '' }}</div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mt-10 h-px w-full bg-slate-200" aria-hidden="true"></div>
                    <div class="mt-8 space-y-4">
                        <a href="{{ $prevVideoData['url'] ?? 'javascript:void(0);' }}" class="group block bg-themeBg-g px-5 py-2.5 transition hover:bg-slate-200">
                            <div class="flex items-center gap-5">
                                <div class="flex h-10 w-10 items-center justify-center bg-white text-slate-700 ring-1 ring-slate-200">
                                    <svg viewBox="0 0 24 24" class="h-[30px] w-auto" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 15l6-6 6 6" /></svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-f18 font-poppins-medium uppercase tracking-wide">Previous Video</div>
                                    <div class="truncate text-[14px] text-themeText-p font-poppins-regular">{{ $prevVideoData['title'] ?? '' }}</div>
                                </div>
                            </div>
                        </a>
                        <a href="{{ $nextVideoData['url'] ?? 'javascript:void(0);' }}" class="group block bg-themeBg-g px-5 py-2.5 transition hover:bg-slate-200">
                            <div class="flex items-center gap-5">
                                <div class="flex h-10 w-10 items-center justify-center bg-white text-slate-700 ring-1 ring-slate-200">
                                    <svg viewBox="0 0 24 24" class="h-[30px] w-auto" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6" /></svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-f18 font-poppins-medium uppercase tracking-wide">Next Video</div>
                                    <div class="truncate text-[14px] text-themeText-p font-poppins-regular">{{ $nextVideoData['title'] ?? '' }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
            </main>

            <aside class="w-full md4:w-[314px]">
                <section class="w-full">
                    <div class="text-f18 font-poppins-medium uppercase tracking-wide">New Videos</div>
                    <div class="mt-5 space-y-4">
                        @foreach(($latestVideosData ?? []) as $item)
                        <a href="{{ $item['url'] ?? 'javascript:void(0);' }}" class="block bg-themeBg-g p-4 transition hover:bg-slate-200">
                            <div class="flex items-center gap-4">
                                <img
                                    class="h-[70px] w-[100px] shrink-0 object-cover"
                                    src="{{ $item['image'] ?? front_webp_url('/front/imgs/video-item.png') }}"
                                    alt="{{ $item['title'] ?? 'Video thumbnail' }}"
                                    loading="lazy"
                                    data-fallback-hq="{{ youtube_thumbnail_url($item['video_url'] ?? '', 'hqdefault') }}"
                                    data-fallback-local="{{ front_webp_url('/front/imgs/video-item.png') }}"
                                    onerror="if(this.dataset.fallbackHq && this.src!==this.dataset.fallbackHq){this.src=this.dataset.fallbackHq;}else if(this.dataset.fallbackLocal && this.src!==this.dataset.fallbackLocal){this.src=this.dataset.fallbackLocal;}else{this.onerror=null;}"
                                />
                                <div class="min-w-0">
                                    <div class="text-f14 text-themeText-p font-poppins-regular">{{ $item['date'] ?? '' }}</div>
                                    <div class="mt-2 line-clamp-2 text-f16 font-poppins-regular leading-5 text-themeText-f">{{ $item['title'] ?? '' }}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </section>
            </aside>
        </div>
    </div>
</section>
@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
@endsection
</x-layout>
