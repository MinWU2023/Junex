<x-layout>
@section('tdk')
<title>{{ $tdk['title'] ?? '' }}</title>
<meta name="description" content="{{ $tdk['description'] ?? '' }}" />
<meta name="keywords" content="{{ $tdk['keywords'] ?? '' }}" />
@endsection

@section('page-css-header')
<link type="text/css" rel="stylesheet" href="/front/css/pages/home.css" />
@endsection

@section('page-js-header')

@endsection 


@section('content')

<section class="w-full breadcrumb bg-themeBg-a md4:bg-themeBg-g">
    <div>
        <div class="mx-auto w-full max-w-[1200px] px-4 py-4 sm2:px-5 md1:px-6 lg1:px-0">
            <nav aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-x-3 gap-y-1">
                    @foreach(($breadcrumbs ?? []) as $idx => $item)
                        @if($idx > 0)
                            <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
                                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </li>
                        @endif
                        <li class="inline-flex items-center">
                            @if(!empty($item['url']))
                                <a href="{{ $item['url'] }}" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                                    @if($idx === 0)
                                        <img src="/front/imgs/breadcrumbs-home.png" alt="Home" class="w-[14px] h-[14px]" />
                                    @endif
                                    <span class="font-poppins-regular text-f14 text-themeText-p">{{ $item['label'] }}</span>
                                </a>
                            @else
                                <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">{{ $item['label'] }}</span>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="w-full bg-white">
    <div class="mx-auto w-full max-w-[1200px] px-4 py-10 sm2:px-5 md1:px-6 md4:py-14 lg1:px-0">
        <div class="text-center">
            @if(!empty($createdLabel))
                <div class="inline-flex items-center justify-center gap-2 text-f14 text-themeText-p font-poppins-regular">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M8 7V3m8 4V3" />
                        <path d="M4 11h16" />
                        <path d="M5 5h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                    </svg>
                    <span>{{ $createdLabel }}</span>
                </div>
            @endif

            <h1 class="mx-auto mt-4 max-w-[920px] leading-snug font-poppins-medium text-f28 text-themeText-f">{{ $pageName ?? '' }}</h1>
        </div>

        <div class="mt-10 space-y-5 text-[14px] leading-6 text-themeText-g font-poppins-regular">
            {!! $pageContent ?? '' !!}
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