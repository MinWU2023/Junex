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
            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Blogs</span>
            </li>
            @endif
        </ol>
        </nav>
    </div>
    </div>
</section>


@php
    $blogListItems = $blogsListData ?? [];
    $hasFeaturedBlog = !empty($featuredBlog);
    $hasBlogList = count($blogListItems) > 0;
    $isBlogEmpty = !$hasFeaturedBlog && !$hasBlogList;
    $onlyFeaturedBlog = $hasFeaturedBlog && !$hasBlogList;
    $tagName = (string)(($tag->name ?? null) ?: ($breadcrumbs[count($breadcrumbs ?? []) - 1]['label'] ?? ''));
@endphp

@if($isBlogEmpty)
@include('front.partials.blog-empty-state', [
    'eyebrow' => __('No Blogs'),
    'title' => __('No Matching Blogs'),
    'description' => $tagName !== ''
        ? __('Sorry, there are no blog posts under ":tag" right now. Please browse other tags or return to the blog list.', ['tag' => $tagName])
        : __('Sorry, there are no blog posts under this tag right now. Please browse other tags or return to the blog list.'),
    'secondaryUrl' => route('blogs'),
    'secondaryLabel' => __('View Blogs'),
])
@else
    <section class="w-full blogs bg-white">
    {{-- 仅一篇时底部 padding 相对原 pb-10/pb-14 各减 30px --}}
    <div class="mx-auto w-full max-w-[1200px] px-4 pt-10 sm2:px-5 md1:px-6 md4:pt-14 lg1:px-0 {{ $onlyFeaturedBlog ? 'pb-[10px] md4:pb-[26px]' : 'pb-10 md4:pb-14' }}">
    @if($hasFeaturedBlog)
    <article class="w-full bg-themeBg-g">
        <a href="{{ $featuredBlog['url'] }}" class="flex flex-col md2:flex-row md2:items-center">
        <div class="relative flex w-full items-center justify-center md2:w-[48%]">
            <img class="w-full object-cover" src="{{ $featuredBlog['image'] }}" alt="Blog cover" loading="lazy" />
        </div>
        <div class="flex w-full flex-col justify-center px-6 py-6 md2:w-[42%] md2:px-10 md2:py-10">
            <h2 class="text-f34 font-poppins-semibold leading-snug font-themeText-f">
            {{ $featuredBlog['title'] }}
            </h2>
            <p class="mt-3 text-f16leading-5 font-poppins-regular text-themeText-g">
            {{ $featuredBlog['excerpt'] }}
            </p>
            <div class="mt-6">
            <span class="inline-flex py-2.5 items-center justify-center bg-black px-4 text-f14 font-poppins-regular uppercase tracking-wide text-white">{{ __('Learn More') }}</span>
            </div>
        </div>
        </a>
    </article>
    @endif

    @if($hasBlogList)
    <div class="mt-8 flex flex-wrap gap-y-5 md1:mt-10">
        @foreach($blogListItems as $item)
        <article class="w-full px-0 md2:w-1/2 md2:px-2 md4:w-1/3">
        <div class="h-full bg-themeBg-g">
            <a href="{{ $item['url'] }}" class="block">
            <img class="h-[180px] w-full object-cover md1:h-[200px]" src="{{ $item['image'] }}" alt="Blog cover" loading="lazy" />
            </a>
            <div class="px-5 py-5">
            <div class="h-[5px] w-[34px] bg-themeBg-d rounded-[3px]" aria-hidden="true"></div>
            <a href="{{ $item['url'] }}" class="mt-3 block text-f18 font-poppins-medium leading-[26px] text-themeText-f transition hover:text-slate-700">
                {{ $item['title'] }}
            </a>
            <div class="mt-4">
                <a href="{{ $item['url'] }}" class="inline-flex h-[44px] items-center justify-center bg-black px-4 text-f14 font-poppins-regular uppercase tracking-wide text-white transition hover:bg-black/90">{{ __('Learn More') }}</a>
            </div>
            </div>
        </div>
        </article>
        @endforeach
    </div>
    @elseif($onlyFeaturedBlog)
    {{-- 无第二篇：相对原 mt-8/mt-10 共减 50px（先减30再减20） --}}
    <div class="mt-[-18px] md1:mt-[-10px]" aria-hidden="true"></div>
    @endif
    </div>
</section>

@if(isset($blogs) && $blogs->hasPages())
<section class="w-full paginations bg-white">
    <div class="mx-auto w-full max-w-[1200px] px-4 pb-12 sm2:px-5 md1:px-6 md4:pb-16 lg1:px-0">
        @include('pagination.common', ['paginator' => $blogs])
    </div>
</section>
@endif
@endif

{{-- 博客标签列表不展示 Product Video；博客列表 / 分类列表仍保留 --}}
@endsection 

@section('page-css-footer')

@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
@endsection 
</x-layout>

