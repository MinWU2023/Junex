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
<section class="w-full breadcrumb bg-[#f7f8fa]">
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
            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Blogs</span>
            </li>
            @endif
        </ol>
        </nav>
    </div>
    </div>
</section>


    <section class="w-full blogs blogs-list-section bg-white sec-bg-white">
    <div class="sec-pad mx-auto w-full max-w-[1200px] px-4 pt-14 pb-6 sm2:px-5 md1:px-6 md1:pt-16 md1:pb-10 lg1:px-0">
    @if(!empty($featuredBlog))
    <article class="w-full bg-themeBg-g">
        <a href="{{ $featuredBlog['url'] }}" class="flex flex-col md2:flex-row md2:items-stretch">
        <div class="relative flex w-full items-center justify-center md2:w-[48%]">
            <img class="w-full object-cover" src="{{ $featuredBlog['image'] }}" alt="Blog cover" loading="lazy" />
        </div>
        <div class="flex w-full flex-col justify-center px-6 py-6 md2:w-[42%] md2:px-10 md2:py-10">
            <div class="text-f14 font-poppins-regular text-themeText-p">{{ $featuredBlog['date'] }}</div>
            
            <h2 class="mt-4 text-f34 font-poppins-semibold leading-snug font-themeText-f">
            {{ $featuredBlog['title'] }}
            </h2>
            <p class="mt-3 text-f16leading-5 font-poppins-regular text-themeText-g">
            {{ $featuredBlog['excerpt'] }}
            </p>
            <div class="mt-6">
            <span class="inline-flex py-2.5 items-center justify-center bg-black px-4 text-f14 font-poppins-regular uppercase tracking-wide text-white">Learn More</span>
            </div>
        </div>
        </a>
    </article>
    @endif

    <div class="mt-8 flex flex-wrap gap-y-5 md1:mt-10">
        @foreach(($blogsListData ?? []) as $item)
        <div class="w-full px-0 md2:w-1/2 md2:px-2 md4:w-1/3">
            @include('front.partials.blog-card', ['item' => $item])
        </div>
        @endforeach
    </div>

    @if(isset($blogs) && $blogs->hasPages())
    <div class="blogs-pagination mt-8 [&_>div]:!mt-0 md1:mt-10">
        @include('pagination.common', ['paginator' => $blogs])
    </div>
    @endif
    </div>
</section>

<section class="w-full videos blogs-videos-section bg-white sec-bg-white">
    <div class="sec-pad mx-auto w-full max-w-[1200px] px-4 pt-4 pb-14 sm2:px-5 md1:px-6 md1:pt-10 md1:pb-16 lg1:px-0">
    <div class="text-center">
        <a href="{{ route('videos') }}" class="group inline-block transition hover:text-themeBg-d">
            <div class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f transition group-hover:text-themeBg-d">PRODUCT VIDEO</div>
            <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d transition group-hover:w-[56px]" aria-hidden="true"></div>
        </a>
    </div>

    <div class="mt-3 md1:mt-5">
        <div class="swiper blogs-product-video-swiper">
            <div class="swiper-wrapper">
                @foreach(($productVideosData ?? []) as $v)
                <article class="swiper-slide">
                <div class="h-full bg-themeBg-g">
                    <a href="{{ $v['video_url'] ?: '#' }}" data-video-url="{{ $v['video_url'] ?: '' }}" class="group block js-video-modal">
                    <div class="relative">
                        <img class="h-[190px] w-full object-cover md1:h-[210px]" src="{{ $v['image'] }}" alt="Product video cover" loading="lazy" />
                        <div class="absolute inset-0 bg-black/10 transition group-hover:bg-black/15" aria-hidden="true"></div>
                        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                        <span class="video-play-btn inline-flex h-12 w-12 items-center justify-center rounded-full border border-white/70 bg-white/20 text-white backdrop-blur-[1px] transition duration-200">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                            <path d="M8 5v14l11-7L8 5z" />
                            </svg>
                        </span>
                        </div>
                    </div>
                    <div class="px-5 py-4">
                        <div class="text-f18 font-poppins-medium leading-5 text-themeText-f">
                        {{ $v['title'] }}
                        </div>
                    </div>
                    </a>
                </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>
    </div>
</section>
@endsection 

@section('page-css-footer')
<style type="text/css">
/* /blogs：列表与 PRODUCT VIDEO 之间再收紧 */
@media only screen and (max-width: 991px) {
    body.sec-space-on section.blogs-list-section.sec-bg-white:has(+ section.blogs-videos-section) .sec-pad,
    section.blogs-list-section.sec-bg-white:has(+ section.blogs-videos-section) .sec-pad {
        padding-bottom: 0.5rem !important;
    }
    body.sec-space-on section.blogs-list-section + section.blogs-videos-section .sec-pad,
    section.blogs-list-section + section.blogs-videos-section .sec-pad {
        padding-top: 0.5rem !important;
    }
}
@media only screen and (min-width: 992px) {
    body.sec-space-on section.blogs-list-section.sec-bg-white:has(+ section.blogs-videos-section) .sec-pad,
    section.blogs-list-section.sec-bg-white:has(+ section.blogs-videos-section) .sec-pad {
        padding-bottom: 1.5rem !important;
    }
    body.sec-space-on section.blogs-list-section + section.blogs-videos-section .sec-pad,
    section.blogs-list-section + section.blogs-videos-section .sec-pad {
        padding-top: 1.5rem !important;
    }
}

/* /blogs 视频：悬停时圆形边框 + 三角为主题红 */
section.blogs-videos-section a.js-video-modal:hover .video-play-btn {
    color: #D92B28 !important;
    border-color: #D92B28 !important;
}
section.blogs-videos-section a.js-video-modal:hover .video-play-btn *,
section.blogs-videos-section a.js-video-modal:hover .video-play-btn svg,
section.blogs-videos-section a.js-video-modal:hover .video-play-btn path {
    color: #D92B28 !important;
    fill: #D92B28 !important;
}
</style>
@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
<script type="text/javascript">
(function () {
    function initBlogsProductVideoSwiper() {
        var el = document.querySelector('.blogs-product-video-swiper');
        if (!el) return;
        if (typeof window.Swiper === 'undefined' || typeof window.JunexSwiper === 'undefined') {
            setTimeout(initBlogsProductVideoSwiper, 50);
            return;
        }
        if (el.swiper) return;

        var host = el.parentElement || el;
        var base = {
            slidesPerView: 1,
            spaceBetween: 16,
            speed: 500,
            breakpoints: {
                768: { slidesPerView: 2, spaceBetween: 16 },
                992: { slidesPerView: 3, spaceBetween: 20 },
            },
        };
        var opts = window.JunexSwiper.withAutoNav(base, el, host, 'blogs-video');
        var swiper = new window.Swiper(el, opts);
        window.JunexSwiper.startAutoplay(swiper);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBlogsProductVideoSwiper);
    } else {
        initBlogsProductVideoSwiper();
    }
    window.addEventListener('load', initBlogsProductVideoSwiper);
})();
</script>
@endsection 
</x-layout>

