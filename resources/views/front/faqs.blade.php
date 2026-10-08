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
            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Faqs</span>
            </li>
            @endif
        </ol>
        </nav>
    </div>
    </div>
</section>
@foreach(($faqGroupsData ?? []) as $gi => $group)
<section class="faqs_item w-full @if($gi===0) pt-6 md1:pt-10 md4:pt-[64px] pb-4 @else pb-[64px] @endif">
    <div class="mx-auto flex w-full max-w-[1200px] flex-col bg-themeBg-g p-10">
    <div class="mb-6 md1:mb-8">
        <h2 class="text-f24 font-poppins-semibold text-themeText-a">
            <span class="text-red-600">{{ $group['name_first'] ?? '' }}</span>{{ $group['name_rest'] ?? '' }}
        </h2>
        <p class="mt-2 text-f14 font-poppins-regular text-themeText-d">
            {{ $group['content'] ?? '' }}
        </p>
    </div>

    <div class="flex flex-col">
        @foreach(($group['faqs'] ?? []) as $faq)
            <div class="faq-accordion border-t border-gray-300 @if($loop->last) border-b @endif">
                <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
                    <span class="text-f18 font-poppins-regular text-themeText-f pr-4">{{ $faq['subject'] ?? '' }}</span>
                    <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content hidden pb-4">
                    <div class="faq-answer prose prose-sm max-w-none text-f16 font-poppins-regular text-themeText-g leading-relaxed [&_p]:mb-2 [&_p:last-child]:mb-0 [&_br]:block">
                        {!! $faq['content'] ?? '' !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>
</section>
@endforeach
@endsection 

@section('page-css-footer')

@endsection

@section('page-js-footer')
<script>
    (function () {
        function initFaqAccordion() {
            var root = document;
            if (!root) return;
            root.addEventListener('click', function (e) {
                var btn = e.target && e.target.closest ? e.target.closest('.faq-trigger') : null;
                if (!btn) return;

                var accordion = btn.closest ? btn.closest('.faq-accordion') : null;
                if (!accordion) return;

                var content = accordion.querySelector('.faq-content');
                if (!content) return;

                var expanded = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
                content.classList.toggle('hidden', expanded);

                var icon = btn.querySelector('.faq-icon');
                if (icon && icon.classList) {
                    icon.classList.toggle('rotate-180', !expanded);
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initFaqAccordion);
        } else {
            initFaqAccordion();
        }
    })();
</script>
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
@endsection 
</x-layout>
