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
                <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Products</span>
                </li>
                @endif
            </ol>
            </nav>
        </div>
    </div>
</section>

@if(!empty(trim(strip_tags((string)($category->content ?? '')))))
<section class="w-full bg-themeBg-a category-description sec-bg-white js-cat-desc-section" data-max-lines="6">
    <div class="sec-pad mx-auto w-[calc(100%-30px)] max-w-[1200px] pb-16 font-poppins-regular text-f16 text-themeText-g leading-7 [&_img]:max-w-full [&_a]:text-themeText-h">
        <div class="js-cat-desc-body cat-desc-body is-pending">
            {!! front_html_prefer_webp($category->content) !!}
        </div>
        <div class="js-cat-desc-actions mt-4 flex justify-start gap-3 hidden">
            <button type="button" class="js-cat-desc-more inline-flex items-center justify-center bg-themeBg-d px-5 py-2 text-f12 font-poppins-medium uppercase tracking-wide text-white transition hover:opacity-90">Read More</button>
            <button type="button" class="js-cat-desc-less hidden inline-flex items-center justify-center bg-themeBg-d px-5 py-2 text-f12 font-poppins-medium uppercase tracking-wide text-white transition hover:opacity-90">Hide More</button>
        </div>
    </div>
</section>
@endif

@php
    $isGroupedDisplay = ($displayMode ?? 'product_list') === \App\Modules\Product\Models\ProductCategory::DISPLAY_CATEGORY_PRODUCT;
    $listPaddingTop = 'py-16';
@endphp

@if($isGroupedDisplay)
    @include('front.partials.category-product-sections', [
        'categoryProductSections' => $categoryProductSections ?? [],
        'sidebarCategories' => $sidebarCategories ?? [],
        'sidebarRecommendProducts' => $sidebarRecommendProducts ?? [],
        'activeCategoryId' => $activeCategoryId ?? null,
        'listPaddingTop' => $listPaddingTop,
    ])
@else
    @include('front.partials.product-list-with-sidebar', [
        'products' => $products ?? null,
        'productsData' => $productsData ?? [],
        'sidebarCategories' => $sidebarCategories ?? [],
        'sidebarRecommendProducts' => $sidebarRecommendProducts ?? [],
        'activeCategoryId' => $activeCategoryId ?? null,
        'listPaddingTop' => $listPaddingTop,
    ])
@endif

@if(!empty(trim(strip_tags((string)($category->content2 ?? '')))))
<section class="w-full bg-white category-description-2 sec-bg-white js-cat-desc-section" data-max-lines="10">
    <div class="sec-pad mx-auto w-[calc(100%-30px)] max-w-[1200px] pb-16 font-poppins-regular text-f16 text-themeText-g leading-7 [&_img]:max-w-full [&_a]:text-themeText-h">
        <div class="js-cat-desc-body cat-desc-body is-pending">
            {!! front_html_prefer_webp($category->content2) !!}
        </div>
        <div class="js-cat-desc-actions mt-4 flex justify-start gap-3 hidden">
            <button type="button" class="js-cat-desc-more inline-flex items-center justify-center bg-themeBg-d px-5 py-2 text-f12 font-poppins-medium uppercase tracking-wide text-white transition hover:opacity-90">Read More</button>
            <button type="button" class="js-cat-desc-less hidden inline-flex items-center justify-center bg-themeBg-d px-5 py-2 text-f12 font-poppins-medium uppercase tracking-wide text-white transition hover:opacity-90">Hide More</button>
        </div>
    </div>
</section>
@endif

@include('front.partials.contact-cta-banner')

@if(!empty($pageBlockHtml) && \App\Modules\Product\Models\ProductCategory::hasRichHtml($pageBlockHtml))
<section class="w-full bg-themeBg-a category-page-block sec-bg-white">
    <div class="sec-pad mx-auto w-[calc(100%-30px)] max-w-[1200px] pt-6 pb-2 font-poppins-regular text-f16 text-themeText-g leading-7 [&_img]:max-w-full [&_a]:text-themeText-h [&_table]:w-full [&_table]:border-collapse [&_td]:border [&_td]:border-[#ddd] [&_td]:px-3 [&_td]:py-2 [&_th]:border [&_th]:border-[#ddd] [&_th]:px-3 [&_th]:py-2">
        {!! $pageBlockHtml !!}
    </div>
</section>
@endif

{!! custom_services_html() !!}

<section class="w-full bg-white why_choose sec-bg-white">
    <div class="mx-auto w-full px-4 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="sec-pad py-16">
            <div class="text-center">
            <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
                {{ $whyChoose['title'] ?? '' }}
            </h2>
            <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
            <p class="mx-auto mt-4 max-w-[825px] leading-6 text-slate-600 text-f16 font-poppins-regular text-themeText-g">
                {{ $whyChoose['description'] ?? '' }}
            </p>
            </div>
            <!-- Mobile: stacked layout -->
            <div class="mt-10 flex flex-col gap-4 md4:hidden">
            @foreach(($whyChoose['cards'] ?? []) as $row)
            <div class="relative overflow-hidden border border-gray-300">
                <img class="absolute inset-0 h-full w-full object-cover grayscale" src="{{ $row['image_mobile_url'] ?? '' }}" alt="{{ $row['label'] ?? '' }}" loading="lazy" />
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.2) 100%);"></div>
                <div class="relative flex min-h-[200px] flex-col justify-center p-6">
                <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">{{ $row['label'] ?? '' }}</div>
                <div class="mt-3 text-[26px] font-poppins-extrabold leading-none text-white">{{ $row['value'] ?? '' }} <span class="ml-2 text-[22px] font-poppins-extrabold text-white">{{ $row['value_suffix'] ?? '' }}</span></div>
                <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">{{ $row['description'] ?? '' }}</div>
                </div>
            </div>
            @endforeach
            <div class="flex items-center justify-center bg-themeBg-d py-10 text-center text-white">
                <div>
                <img class="mx-auto h-14 w-14 object-contain" src="{{ $whyChoose['center']['logo_url'] ?? '' }}" alt="Junex" loading="lazy" />
                <div class="mt-3 text-[16px] font-poppins-semibold uppercase tracking-[3px]">{{ $whyChoose['center']['title'] ?? '' }}</div>
                <div class="mx-auto mt-3 h-[1px] w-[40px] bg-white/60"></div>
                <div class="mt-3 text-[11px] leading-5 text-white px-4 font-poppins-regular">{{ $whyChoose['center']['subtitle'] ?? '' }}</div>
                </div>
            </div>
            </div>

            <!-- Desktop: kite layout -->
            <div class="relative mx-auto mt-10 hidden md4:block" style="aspect-ratio:1920/1040;">
            @php
                $whyChooseCards = $whyChoose['cards'] ?? [];
                $wc1 = $whyChooseCards[0] ?? [];
                $wc2 = $whyChooseCards[1] ?? [];
                $wc3 = $whyChooseCards[2] ?? [];
                $wc4 = $whyChooseCards[3] ?? [];
            @endphp
            <!-- Left Top: 63.333% wide, 33.33% tall -->
            <div class="absolute left-0 top-0 overflow-hidden border-r border-b border-gray-300" style="width:63.333%;height:33.33%;">
                <div class="absolute inset-0 grayscale" style="background:url('{{ $wc1['background_desktop_url'] ?? '' }}') center/cover no-repeat;"></div>
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="absolute top-1/2 -translate-y-1/2 left-[80px] md2:left-[120px] md4:left-[180px] lg1:left-[240px] lg2:left-[300px]">
                <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">{{ $wc1['label'] ?? '' }}</div>
                <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">{{ $wc1['value'] ?? '' }} <span class="mt-1 text-f42 font-poppins-semibold text-stroke-white">{{ $wc1['value_suffix'] ?? '' }}</span></div>
                <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">{{ $wc1['description'] ?? '' }}</div>
                </div>
            </div>
            <!-- Left Bottom: 36.667% wide, 66.67% tall -->
            <div class="absolute left-0 overflow-hidden border-r border-gray-300" style="width:39%;top:33.33%;height:66.67%;">
                <div class="absolute inset-0 grayscale" style="background:url('{{ $wc2['background_desktop_url'] ?? '' }}') center/cover no-repeat;"></div>
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(218,43,40,0.5) 0%, rgba(0,0,0,0.4) 100%);"></div>
                <div class="absolute top-1/2 -translate-y-1/2 left-[80px] md2:left-[120px] md4:left-[180px] lg1:left-[240px] lg2:left-[300px]">
                <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">{{ $wc2['label'] ?? '' }}</div>
                <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">{{ $wc2['value'] ?? '' }} <span class="mt-1 text-f42 font-poppins-semibold text-stroke-white">{{ $wc2['value_suffix'] ?? '' }}</span></div>
                <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">{{ $wc2['description'] ?? '' }}</div>
                </div>
            </div>
            <!-- Right Top: 36.667% wide, 66.67% tall -->
            <div class="absolute right-0 top-0 overflow-hidden border-l border-b border-gray-300" style="width:39%;height:66.67%;">
                <div class="absolute inset-0 grayscale" style="background:url('{{ $wc3['background_desktop_url'] ?? '' }}') center/cover no-repeat;"></div>
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="absolute top-1/2 -translate-y-1/2 left-[24px] md2:left-[36px] md4:left-[48px] lg1:left-[64px]">
                <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">{{ $wc3['label'] ?? '' }}</div>
                <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">{{ $wc3['value'] ?? '' }} <div class="mt-1 text-f42 font-poppins-semibold text-stroke-white ">{{ $wc3['value_suffix'] ?? '' }}</div></div>
                <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">{{ $wc3['description'] ?? '' }}</div>
                </div>
            </div>
            <!-- Right Bottom: 63.333% wide, 33.33% tall -->
            <div class="absolute right-0 overflow-hidden border-l border-gray-300" style="width:61%;top:66.67%;height:33.33%;">
                <div class="absolute inset-0 grayscale" style="background:url('{{ $wc4['background_desktop_url'] ?? '' }}') center/cover no-repeat;"></div>
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(218,43,40,0.5) 0%, rgba(0,0,0,0.4) 100%);"></div>
                <div class="absolute top-1/2 -translate-y-1/2 left-[24px] md2:left-[36px] md4:left-[48px] lg1:left-[64px]">
                <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">{{ $wc4['label'] ?? '' }}</div>
                <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">{{ $wc4['value'] ?? '' }} <span class="mt-1 text-f42 font-poppins-semibold text-stroke-white">{{ $wc4['value_suffix'] ?? '' }}</span></div>
                <div class="mt-3 max-w-[360px] text-f15 leading-5 text-white font-poppins-regular">{{ $wc4['description'] ?? '' }}</div>
                </div>
            </div>
            <!-- Center Red Block -->
            <div class="absolute z-10 flex flex-col items-center justify-center bg-themeBg-d text-center text-white" style="left:39%;top:33.33%;width:22%;height:33.34%;">
                <img class="h-auto w-[200px] object-contain" src="{{ $whyChoose['center']['logo_url'] ?? '' }}" alt="Junex" loading="lazy" />
                <div class="mt-3 text-f12 leading-5 text-white px-4 font-poppins-regular">{{ $whyChoose['center']['description_desktop'] ?? '' }}</div>
            </div>
            </div>
        </div>
    </div>
</section>

{!! static_block_html('defined_services_faqs') !!}

{!! static_block_html('ask_us') !!}

@endsection 

@section('page-css-footer')
<style>
.cat-desc-body.is-pending {
  opacity: 0;
}
.cat-desc-body.is-collapsed {
  overflow: hidden;
  position: relative;
}
.cat-desc-body:not(.is-pending) {
  opacity: 1;
  transition: opacity .15s ease;
}
/* 富文本表格：恢复边框（Tailwind preflight 会清掉默认表格线） */
.cat-desc-body table {
  width: 100%;
  max-width: 100%;
  border-collapse: collapse;
  margin: 1em 0;
}
.cat-desc-body table td,
.cat-desc-body table th {
  border: 1px solid #ddd;
  padding: 8px 12px;
  vertical-align: top;
}
.cat-desc-body table th {
  font-weight: 600;
  background: rgba(0, 0, 0, 0.03);
}
/* 分类页板块与下方定制服务间距收紧 */
.category-page-block + .custom_serrvices .sec-pad,
.category-page-block + section.custom_serrvices .sec-pad {
  padding-top: 2rem;
}
</style>
@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
<script>
(function () {
  function resolveLineHeight(el) {
    var style = window.getComputedStyle(el);
    var lh = parseFloat(style.lineHeight);
    if (!isNaN(lh) && isFinite(lh) && lh > 0) return lh;
    var fs = parseFloat(style.fontSize) || 16;
    return fs * 1.75;
  }

  /**
   * 按「带文字的可视行」统计，并返回第 maxLines 行底部相对容器顶部的高度。
   * 空文本节点不计行；图片/空白块不单独计行，但会包含在裁切高度内。
   */
  function measureTextLines(el, maxLines) {
    var range = document.createRange();
    var walker = document.createTreeWalker(el, NodeFilter.SHOW_TEXT, null);
    var bodyTop = el.getBoundingClientRect().top;
    var lines = 0;
    var clampHeight = null;
    var clampNode = null;
    var node;

    while ((node = walker.nextNode())) {
      var text = (node.nodeValue || '').replace(/\s+/g, ' ').trim();
      if (!text) continue;
      range.selectNodeContents(node);
      var rects = range.getClientRects();
      for (var i = 0; i < rects.length; i++) {
        var rect = rects[i];
        if (rect.width <= 0 || rect.height <= 0) continue;
        lines += 1;
        if (lines === maxLines) {
          clampHeight = Math.ceil(rect.bottom - bodyTop);
          clampNode = node;
        }
      }
    }

    if (lines <= 0) {
      var lh = resolveLineHeight(el);
      lines = Math.ceil(el.scrollHeight / lh);
      clampHeight = Math.round(lh * maxLines);
    } else if (clampHeight === null && lines > 0) {
      clampHeight = el.scrollHeight;
    }

    if (clampHeight != null) {
      clampHeight = snapClampPastBorders(el, clampHeight, clampNode);
    }

    return { lines: lines, clampHeight: clampHeight };
  }

  /**
   * overflow:hidden 按文字行底裁切时，容易切掉单元格 padding / 表格线。
   * 若裁切落在表格内，对齐到该行底边；并加 1px 避免亚像素裁掉边框。
   */
  function snapClampPastBorders(el, clampHeight, clampNode) {
    var bodyTop = el.getBoundingClientRect().top;
    var height = clampHeight;

    // 裁切点落在某单元格内：至少露到该行底部（含底边框）
    if (clampNode && clampNode.parentElement) {
      var cell = clampNode.parentElement.closest('td, th');
      if (cell) {
        var row = cell.parentElement;
        var rowBottom = Math.ceil((row || cell).getBoundingClientRect().bottom - bodyTop);
        if (rowBottom > height) height = rowBottom;
      }
    }

    // 裁切线穿过表格中间：扩展到「已露出顶部」的最后一行底边
    var tables = el.querySelectorAll('table');
    for (var t = 0; t < tables.length; t++) {
      var table = tables[t];
      var tableRect = table.getBoundingClientRect();
      var tableTop = tableRect.top - bodyTop;
      var tableBottom = tableRect.bottom - bodyTop;
      if (!(height > tableTop && height < tableBottom - 0.5)) continue;

      var rows = table.rows;
      var bestBottom = height;
      for (var r = 0; r < rows.length; r++) {
        var rowRect = rows[r].getBoundingClientRect();
        var rowTop = rowRect.top - bodyTop;
        var rowBottom2 = Math.ceil(rowRect.bottom - bodyTop);
        if (rowTop < height - 0.5) {
          bestBottom = Math.max(bestBottom, rowBottom2);
        }
      }
      height = bestBottom;
    }

    // 亚像素 / border-collapse 下多留 1px，避免底边框被裁掉
    return height + 1;
  }

  function resetSection(section) {
    var body = section.querySelector('.js-cat-desc-body');
    if (!body) return;
    var keepExpanded = section.getAttribute('data-cat-desc-expanded') === '1';
    body.style.maxHeight = '';
    body.classList.remove('is-collapsed');
    body.classList.add('is-pending');
    var actions = section.querySelector('.js-cat-desc-actions');
    if (actions) {
      var next = actions.cloneNode(true);
      next.classList.add('hidden');
      var moreBtn = next.querySelector('.js-cat-desc-more');
      var lessBtn = next.querySelector('.js-cat-desc-less');
      if (moreBtn) moreBtn.classList.toggle('hidden', keepExpanded);
      if (lessBtn) lessBtn.classList.toggle('hidden', !keepExpanded);
      actions.parentNode.replaceChild(next, actions);
    }
    return keepExpanded;
  }

  function initSection(section) {
    var body = section.querySelector('.js-cat-desc-body');
    var actions = section.querySelector('.js-cat-desc-actions');
    var moreBtn = section.querySelector('.js-cat-desc-more');
    var lessBtn = section.querySelector('.js-cat-desc-less');
    if (!body) return;

    var maxLines = parseInt(section.getAttribute('data-max-lines') || '6', 10) || 6;
    var keepExpanded = section.getAttribute('data-cat-desc-expanded') === '1';
    // 先展开测量
    body.style.maxHeight = '';
    body.classList.remove('is-collapsed');

    var measured = measureTextLines(body, maxLines);
    var needToggle = measured.lines > maxLines;
    var maxHeight = measured.clampHeight || Math.round(resolveLineHeight(body) * maxLines);

    function collapse() {
      body.style.maxHeight = maxHeight + 'px';
      body.classList.add('is-collapsed');
      section.setAttribute('data-cat-desc-expanded', '0');
      if (moreBtn) moreBtn.classList.remove('hidden');
      if (lessBtn) lessBtn.classList.add('hidden');
    }

    function expand() {
      body.style.maxHeight = '';
      body.classList.remove('is-collapsed');
      section.setAttribute('data-cat-desc-expanded', '1');
      if (moreBtn) moreBtn.classList.add('hidden');
      if (lessBtn) lessBtn.classList.remove('hidden');
    }

    if (needToggle) {
      if (actions) actions.classList.remove('hidden');
      if (keepExpanded) {
        expand();
      } else {
        collapse();
      }
      if (moreBtn) moreBtn.addEventListener('click', expand);
      if (lessBtn) {
        lessBtn.addEventListener('click', function () {
          collapse();
          // 仅手动收起时滚回板块顶部，方便继续阅读；滚动本身不会触发收起
          try {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
          } catch (e) {}
        });
      }
    } else {
      section.setAttribute('data-cat-desc-expanded', '0');
      if (actions) actions.classList.add('hidden');
    }

    body.classList.remove('is-pending');
  }

  function run() {
    document.querySelectorAll('.js-cat-desc-section').forEach(initSection);
  }

  function reinitAll() {
    document.querySelectorAll('.js-cat-desc-section').forEach(resetSection);
    run();
  }

  function whenReady(fn) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn);
    } else {
      fn();
    }
  }

  whenReady(function () {
    run();

    // 图片加载后行位置可能变化，需重测（保留已展开状态）
    document.querySelectorAll('.js-cat-desc-body img').forEach(function (img) {
      if (img.complete) return;
      img.addEventListener('load', function () {
        clearTimeout(window.__catDescImgTimer);
        window.__catDescImgTimer = setTimeout(reinitAll, 50);
      });
      img.addEventListener('error', function () {
        clearTimeout(window.__catDescImgTimer);
        window.__catDescImgTimer = setTimeout(reinitAll, 50);
      });
    });

    // 兜底：避免脚本异常时内容一直不可见
    setTimeout(function () {
      document.querySelectorAll('.cat-desc-body.is-pending').forEach(function (el) {
        el.classList.remove('is-pending');
      });
    }, 2500);
  });

  // 手机滚动时地址栏显隐会触发 resize（高度变、宽度不变），
  // 若整页重初始化会误把已展开内容收起。仅在宽度变化时重测。
  var lastLayoutWidth = window.innerWidth;
  var resizeTimer = null;
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      var width = window.innerWidth;
      if (Math.abs(width - lastLayoutWidth) < 2) return;
      lastLayoutWidth = width;
      reinitAll();
    }, 150);
  });
})();
</script>
@endsection
</x-layout>

