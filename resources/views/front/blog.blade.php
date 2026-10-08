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
            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Blog</span>
            </li>

            <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
            <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18l6-6-6-6" />
            </svg>
            </li>

            <li class="inline-flex items-center">
            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Types of Vacuums: Everything You Need to Know to Choose the Best Cleaner</span>
            </li>
            @endif
        </ol>
        </nav>
    </div>
    </div>
</section>
 

<section class="w-full blog_main bg-white sec-bg-white">
    <div class="sec-pad mx-auto w-full max-w-[1200px] px-4 py-16 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="flex flex-col gap-8 md4:flex-row md4:gap-[26px]">
        <main class="w-full md4:w-[860px]">
        <article class="bg-white">
            <div class="text-center">
            <div class="inline-flex items-center justify-center gap-2 text-f14 text-themeText-p font-poppins-regular">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M8 7V3m8 4V3" />
                <path d="M4 11h16" />
                <path d="M5 5h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                </svg>
                <span>{{ $blogDate ?? '' }}</span>
            </div>

            <h1 class="mx-auto mt-4 max-w-[720px] leading-snug font-poppins-medium text-f28 text-themeText-f">
                {{ $blogTitle ?? '' }}
            </h1>
            </div>

            <div class="mt-6 overflow-hidden bg-slate-200 md1:mt-8">
            <img class="h-[240px] w-full object-cover md1:h-[320px] md2:h-[360px]" src="{{ $blogCover ?? '' }}" alt="Blog cover" loading="lazy" />
            </div>

            <div class="mt-10 text-center">
            <img class="mx-auto h-auto w-auto max-w-[60px] mb-[30px]" src="{{ front_webp_url('/front/imgs/blog-detail-icon.png') }}" alt="Quote" loading="lazy" aria-hidden="true" />
            <p class="mx-auto max-w-[680px] text-f20 font-poppins-medium leading-6 text-themeText-f mb-[30px]">
                Very Comfortable Easy To Keep Clean. Small Enough To Put In Any Room In Your House But Yet Big Enough For A Big Person.
            </p>
            </div>

            <div class="mt-8 space-y-5 text-[14px] leading-6 text-themeText-g font-poppins-regular">
                {!! $blogContent ?? '' !!}
            </div>

            <div class="mt-10">
            <div class="flex flex-wrap items-center gap-3">
                <div class="inline-flex items-center gap-2">
                <img src="{{ front_webp_url('/front/icons/blog-tags.svg') }}" alt="Hot Tags" class="h-4 w-4" loading="lazy" />
                <span class="text-f18 font-poppins-medium uppercase tracking-wide text-themeText-h">Hot Tags :</span>
                </div>

                @foreach(($blogTagsData ?? []) as $tag)
                    <a href="{{ $tag['url'] ?? 'javascript:void(0);' }}" class="inline-flex h-10 items-center bg-themeBg-g px-5 text-[14px] text-themeText-p transition hover:bg-slate-200">{{ $tag['name'] ?? '' }}</a>
                @endforeach
            </div>

            <div class="mt-8 h-px w-full bg-slate-200" aria-hidden="true"></div>

            <div class="mt-8 space-y-4">
                @if(!empty($prevBlogData))
                <a href="{{ $prevBlogData['url'] ?? 'javascript:void(0);' }}" class="group block bg-themeBg-g px-5 py-2.5 transition hover:bg-slate-200">
                <div class="flex items-center gap-5">
                    <div class="flex h-10 w-10 items-center justify-center bg-white text-slate-700 ring-1 ring-slate-200">
                    <svg viewBox="0 0 24 24" class="h-[30px] w-auto" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 15l6-6 6 6" />
                    </svg>
                    </div>
                    <div class="min-w-0">
                    <div class="text-f18 font-poppins-medium uppercase tracking-wide">Previous Post</div>
                    <div class="truncate text-[14px] text-themeText-p font-poppins-regular">{{ $prevBlogData['title'] ?? '' }}</div>
                    </div>
                </div>
                </a>
                @endif

                @if(!empty($nextBlogData))
                <a href="{{ $nextBlogData['url'] ?? 'javascript:void(0);' }}" class="group block bg-themeBg-g px-5 py-2.5 transition hover:bg-slate-200">
                <div class="flex items-center gap-5">
                    <div class="flex h-10 w-10 items-center justify-center bg-white text-slate-700 ring-1 ring-slate-200">
                    <svg viewBox="0 0 24 24" class="h-[30px] w-auto" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                    </div>
                    <div class="min-w-0">
                    <div class="text-f18 font-poppins-medium uppercase tracking-wide">Next Post</div>
                    <div class="truncate text-[14px] text-themeText-p font-poppins-regular">{{ $nextBlogData['title'] ?? '' }}</div>
                    </div>
                </div>
                </a>
                @endif
            </div>
            </div>
        </article>
        </main>

        <aside class="w-full md4:w-[314px]">
        <div class="space-y-10 md4:pt-0">
            <section class="w-full">
            <div class="text-f18 font-poppins-medium uppercase tracking-wide">Share</div>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <a href="#" class="inline-flex h-[30px] w-[30px] items-center justify-center bg-[#1DA1F2] text-white" aria-label="Twitter">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                    <path d="M22 5.92c-.73.33-1.52.55-2.35.65.85-.51 1.5-1.32 1.81-2.28-.8.47-1.69.82-2.63 1A4.12 4.12 0 0015.5 3c-2.27 0-4.1 1.86-4.1 4.16 0 .33.03.65.1.96-3.41-.18-6.43-1.83-8.46-4.35a4.2 4.2 0 00-.56 2.1c0 1.44.72 2.71 1.8 3.46-.67-.02-1.3-.21-1.85-.51v.05c0 2.02 1.42 3.7 3.3 4.09-.34.1-.7.15-1.08.15-.26 0-.52-.02-.76-.07.52 1.63 2 2.82 3.77 2.85A8.26 8.26 0 012 18.2 11.64 11.64 0 008.29 20c7.55 0 11.68-6.34 11.68-11.84 0-.18 0-.36-.01-.54A8.5 8.5 0 0022 5.92z" />
                </svg>
                </a>
                <a href="#" class="inline-flex h-[30px] w-[30px] items-center justify-center bg-[#0A66C2] text-white" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                    <path d="M4.98 3.5C4.98 4.88 3.87 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM0.5 23.5h4V7.98h-4V23.5zM8.5 7.98h3.83v2.12h.05c.53-1.01 1.84-2.08 3.79-2.08 4.05 0 4.8 2.71 4.8 6.24v9.24h-4v-8.2c0-1.95-.04-4.47-2.7-4.47-2.71 0-3.12 2.13-3.12 4.33v8.34h-4V7.98z" />
                </svg>
                </a>
                <a href="#" class="inline-flex h-[30px] w-[30px] items-center justify-center bg-[#FF0000] text-white" aria-label="YouTube">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                    <path d="M23.5 6.2a3 3 0 00-2.1-2.12C19.6 3.6 12 3.6 12 3.6s-7.6 0-9.4.48A3 3 0 00.5 6.2 31.5 31.5 0 000 12a31.5 31.5 0 00.5 5.8 3 3 0 002.1 2.12c1.8.48 9.4.48 9.4.48s7.6 0 9.4-.48a3 3 0 002.1-2.12A31.5 31.5 0 0024 12a31.5 31.5 0 00-.5-5.8zM9.8 15.5V8.5l6.2 3.5-6.2 3.5z" />
                </svg>
                </a>
                <a href="#" class="inline-flex h-[30px] w-[30px] items-center justify-center bg-[#E1306C] text-white" aria-label="Instagram">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                    <path d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm10 2H7a3 3 0 00-3 3v10a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3zm-5 3.5A4.5 4.5 0 1112 16a4.5 4.5 0 010-9zm0 2A2.5 2.5 0 1014.5 12 2.5 2.5 0 0012 9.5zM17.75 6.3a1.05 1.05 0 11-1.05 1.05 1.05 1.05 0 011.05-1.05z" />
                </svg>
                </a>
                <a href="#" class="inline-flex h-[30px] w-[30px] items-center justify-center bg-[#BD081C] text-white" aria-label="Pinterest">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                    <path d="M12.1 2C6.6 2 2 6.1 2 11.6c0 4.1 2.5 7.7 6.1 9.2-.1-.8-.2-2 0-2.9.2-.8 1.4-5.3 1.4-5.3s-.4-.8-.4-2c0-1.9 1.1-3.3 2.5-3.3 1.2 0 1.7.9 1.7 1.9 0 1.2-.8 3-1.2 4.6-.3 1.4.7 2.5 2 2.5 2.4 0 4.2-2.6 4.2-6.3 0-3.3-2.3-5.6-5.6-5.6-3.8 0-6 2.9-6 5.9 0 1.2.4 2.4 1.1 3.1.1.1.1.2.1.4-.1.4-.3 1.2-.3 1.3-.1.2-.2.3-.4.2-1.6-.8-2.6-3.2-2.6-5.2 0-4.2 3-8 8.7-8 4.6 0 8.2 3.3 8.2 7.6 0 4.5-2.8 8.2-6.7 8.2-1.3 0-2.6-.7-3-1.5l-.8 3c-.3 1-.9 2.3-1.3 3.1.9.3 1.9.5 2.9.5 5.5 0 10.1-4.1 10.1-9.6C22.2 6.1 17.6 2 12.1 2z" />
                </svg>
                </a>
            </div>
            </section>

            <section class="w-full">
            <div class="text-f18 font-poppins-medium uppercase tracking-wide">New Blog</div>
            <div class="mt-5 space-y-4">
                @foreach(($latestBlogsData ?? []) as $item)
                    <a href="{{ $item['url'] ?? 'javascript:void(0);' }}" class="block bg-themeBg-g p-4 transition hover:bg-slate-200">
                        <img class="h-auto w-full object-cover" src="{{ $item['image'] ?? '' }}" alt="{{ $item['title'] ?? 'Blog thumbnail' }}" loading="lazy" />
                        <div class="mt-3 text-f16 font-poppins-regular leading-6 text-themeText-f">
                            {{ $item['title'] ?? '' }}
                        </div>
                    </a>
                @endforeach
            </div>
            </section>

            <section class="w-full">
            <div class="text-f18 font-poppins-medium uppercase tracking-wide">Hot Tags</div>
            <div class="mt-5 flex flex-wrap gap-3">
                @foreach(($hotTagsData ?? []) as $tag)
                    <a href="{{ $tag['url'] ?? 'javascript:void(0);' }}" class="inline-flex h-10 items-center bg-themeBg-g px-5 text-[14px] text-themeText-p transition hover:bg-slate-200">{{ $tag['name'] ?? '' }}</a>
                @endforeach
            </div>
            </section>
        </div>
        </aside>
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
