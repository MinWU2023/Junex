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
            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Reviews</span>
            </li>
            @endif
        </ol>
        </nav>
    </div>
    </div>
</section>
 

<section class="w-full bg-white reviews">
    <div class="mx-auto w-full max-w-[1200px] px-4 py-10 sm2:px-5 md1:px-6 md4:py-14 lg1:px-0">
    <div class="text-center">
        <div class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">GENUINE CUSTOMER REVIEW FROM JUNEX</div>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 max-w-[960px] leading-6 text-slate-600 text-f16 font-poppins-regular text-themeText-g">
        Here are some real reviews about our service and goods. We are happy to share them with all our customers, both now and in the future. If you are worried about our service and goods, you can see some reviews from our kind customers, and we hope it will help you to know us better. Looking forward to working together with you in your active wears projects.
        </p>
    </div>

    <div id="reviews-grid" class="mt-8 grid grid-cols-1 gap-5 md4:mt-10 md4:grid-cols-2 md4:gap-6">
        @foreach(($reviewsColumns ?? [[],[]]) as $col)
            <div class="space-y-4 md4:space-y-5">
                @foreach($col as $item)
                    <div class="review-card relative overflow-hidden bg-themeBg-g p-6 shadow-sm ring-1 ring-black/5" data-id="{{ $item['id'] ?? 0 }}">
                        <div class="pointer-events-none absolute inset-0" style="background:url('{{ front_webp_url('/front/imgs/reviews-item-bg.png') }}') no-repeat calc(100% - 68px) 36px" aria-hidden="true"></div>
                        <div class="relative flex flex-col gap-3">
                            <div class="flex items-start gap-3">
                                <div class="hidden md2:flex h-[50px] w-[50px] shrink-0 items-center justify-center rounded-full bg-themeBg-d font-poppins-medium text-f22 text-white">{{ $item['initial'] ?? '' }}</div>
                                <div>
                                    <div class="text-f20 font-poppins-medium text-themeText-f">{{ $item['username'] ?? '' }}</div>
                                    <div class="mt-1 flex items-center gap-0.5 text-[#f59e0b]" aria-label="{{ $item['score'] ?? 0 }} stars">
                                        @for($s=0;$s<5;$s++)
                                            <svg viewBox="0 0 20 20" class="h-[14px] w-[14px]" fill="currentColor" aria-hidden="true"><path d="M10 15l-5.878 3.09L5.244 11.5.488 6.91l6.57-.955L10 0l2.942 5.955 6.57.955-4.756 4.59 1.122 6.59z"/></svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <div class="min-w-0">
                                <div class="mt-3 text-f18 font-poppins-medium text-themeText-f">{{ $item['subject'] ?? '' }}</div>
                                <p class="mt-3 text-f14 leading-5 text-themeText-g font-poppins-regular">{{ $item['content'] ?? '' }}</p>
                                @if(!empty($item['imgs']) && is_array($item['imgs']))
                                    <div class="mt-4 grid grid-cols-2 gap-3">
                                        @foreach(array_slice($item['imgs'], 0, 2) as $img)
                                            <div class="overflow-hidden bg-slate-200">
                                                <img class="w-full object-cover preview-img" src="{{ $img }}" alt="Review image" loading="lazy" />
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <div class="mt-10 flex flex-col items-center justify-center gap-4 sm6:flex-row sm6:gap-6">
        <a id="btn-view-more" href="#" data-next-page="{{ $reviews && $reviews->hasMorePages() ? ($reviews->currentPage() + 1) : '' }}" class="inline-flex items-center justify-center bg-themeBg-h px-10 py-3.5 text-f14 font-poppins-medium uppercase tracking-wide text-themeText-f transition hover:bg-slate-300">VIEW MORE</a>
        <a href="/contact-us" class="inline-flex items-center justify-center bg-red-600 px-9 py-3.5 text-f14 font-poppins-medium uppercase tracking-wide text-white transition hover:bg-red-700">QUOTE NOW</a>
    </div>
    </div>
</section>

{!! static_block_html('defined_services') !!}

{!! static_block_html('ask_us') !!}
@endsection 

@section('page-css-footer')

@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>

<script>
    (function () {
        function escapeHtml(str) {
            str = (str === null || str === undefined) ? '' : String(str);
            return str
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function buildStarsHtml() {
            var star = '<svg viewBox="0 0 20 20" class="h-[14px] w-[14px]" fill="currentColor" aria-hidden="true"><path d="M10 15l-5.878 3.09L5.244 11.5.488 6.91l6.57-.955L10 0l2.942 5.955 6.57.955-4.756 4.59 1.122 6.59z"/></svg>';
            return star + star + star + star + star;
        }

        function buildCardHtml(item) {
            var imgsHtml = '';
            if (item.imgs && item.imgs.length) {
                var imgs = item.imgs.slice(0, 2);
                imgsHtml = '<div class="mt-4 grid grid-cols-2 gap-3">' + imgs.map(function (src) {
                    return '<div class="overflow-hidden bg-slate-200">'
                        + '<img class="w-full object-cover preview-img" src="' + escapeHtml(src) + '" alt="Review image" loading="lazy" />'
                        + '</div>';
                }).join('') + '</div>';
            }

            return ''
                + '<div class="review-card relative overflow-hidden bg-themeBg-g p-6 shadow-sm ring-1 ring-black/5" data-id="' + (item.id || 0) + '">'
                + '<div class="pointer-events-none absolute inset-0" style="background:url(\'{{ front_webp_url('/front/imgs/reviews-item-bg.png') }}\') no-repeat calc(100% - 68px) 36px" aria-hidden="true"></div>'
                + '<div class="relative flex flex-col gap-3">'
                + '<div class="flex items-start gap-3">'
                + '<div class="hidden md2:flex h-[50px] w-[50px] shrink-0 items-center justify-center rounded-full bg-themeBg-d font-poppins-medium text-f22 text-white">' + escapeHtml(item.initial || '') + '</div>'
                + '<div>'
                + '<div class="text-f20 font-poppins-medium text-themeText-f">' + escapeHtml(item.username || '') + '</div>'
                + '<div class="mt-1 flex items-center gap-0.5 text-[#f59e0b]" aria-label="' + escapeHtml(item.score || 0) + ' stars">'
                + buildStarsHtml()
                + '</div>'
                + '</div>'
                + '</div>'
                + '<div class="min-w-0">'
                + '<div class="mt-3 text-f18 font-poppins-medium text-themeText-f">' + escapeHtml(item.subject || '') + '</div>'
                + '<p class="mt-3 text-f14 leading-5 text-themeText-g font-poppins-regular">' + escapeHtml(item.content || '') + '</p>'
                + imgsHtml
                + '</div>'
                + '</div>'
                + '</div>';
        }

        function fetchJson(url) {
            return fetch(url, { headers: { 'Accept': 'application/json' } }).then(function (res) {
                if (!res.ok) {
                    throw new Error('Request failed');
                }
                return res.json();
            });
        }

        function initViewMore() {
            var btn = document.getElementById('btn-view-more');
            var grid = document.getElementById('reviews-grid');
            if (!btn || !grid) return;

            var cols = grid.querySelectorAll(':scope > div');
            if (!cols || cols.length < 2) return;
            var col0 = cols[0];
            var col1 = cols[1];

            function hideBtn() {
                btn.style.display = 'none';
            }

            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var nextPage = btn.getAttribute('data-next-page');
                if (!nextPage) {
                    hideBtn();
                    return;
                }

                try {
                    if (typeof window.showLoading === 'function') {
                        window.showLoading('Loading...');
                    }
                } catch (e) {}

                btn.setAttribute('aria-disabled', 'true');
                btn.classList.add('opacity-70');

                var url = '/api/reviews?page=' + encodeURIComponent(nextPage) + '&per_page=10';
                fetchJson(url).then(function (res) {
                    if (!res || !res.success || !res.data) {
                        hideBtn();
                        return;
                    }
                    var items = Array.isArray(res.data.items) ? res.data.items : [];
                    if (!items.length) {
                        hideBtn();
                        return;
                    }

                    items.forEach(function (item, idx) {
                        var target = ((idx % 2) === 0) ? col0 : col1;
                        target.insertAdjacentHTML('beforeend', buildCardHtml(item));
                    });

                    if (res.data.has_more && res.data.next_page) {
                        btn.setAttribute('data-next-page', String(res.data.next_page));
                    } else {
                        btn.setAttribute('data-next-page', '');
                        hideBtn();
                    }

                    try {
                        if (typeof window.hideLoading === 'function') {
                            setTimeout(function () {
                                window.hideLoading();
                            }, 1000);
                        }
                    } catch (e) {}
                }).catch(function () {
                    // keep page stable; do not throw
                    try {
                        if (typeof window.hideLoading === 'function') {
                            setTimeout(function () {
                                window.hideLoading();
                            }, 1000);
                        }
                    } catch (e) {}
                }).finally(function () {
                    btn.removeAttribute('aria-disabled');
                    btn.classList.remove('opacity-70');
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initViewMore);
        } else {
            initViewMore();
        }
    })();
</script>
@endsection 
</x-layout>
