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
    {{-- 移动端标题与面包屑间距相对 py-16 减小 30px --}}
    <div class="sec-pad mx-auto w-full max-w-[1200px] px-4 pt-[34px] pb-16 sm2:px-5 md1:px-6 md1:py-16 lg1:px-0">
    <div class="flex flex-col gap-8 md4:flex-row md4:gap-[26px]">
        <main class="w-full md4:w-[860px]">
        <article class="bg-white">
            <div class="text-center">
            <h1 class="mx-auto max-w-[720px] leading-snug font-poppins-medium text-f28 text-themeText-f">
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
                @php
                    $blogShareTitle = (string)($blogTitle ?? ($blog->name ?? ''));
                    $blogShareImage = (string)($blogCover ?? '');
                    if ($blogShareImage !== '' && !preg_match('#^https?://#i', $blogShareImage)) {
                        $blogShareImage = url($blogShareImage);
                    }
                @endphp
                @include('front.partials.sns-icons', [
                    'variant' => 'blog',
                    'shareUrl' => url()->current(),
                    'shareTitle' => $blogShareTitle,
                    'shareImage' => $blogShareImage,
                    'snsIcons' => $snsIcons ?? ($data['snsShareIcons'] ?? sns_icons('share')),
                ])
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
