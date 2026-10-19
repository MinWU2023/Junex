{{-- Category & product mode: left sidebar + products grouped by subcategory on the right; two rows by default, View More / Hide More only when they overflow --}}
@php
    $categoryProductSections = $categoryProductSections ?? [];
    // Matches the grid column count: 1 col x 2 rows / 2 cols x 2 rows / 3 cols x 2 rows
    $initialVisibleMobile = 2;   // < sm5
    $initialVisibleTablet = 4;   // sm5 ~ md4-1
    $initialVisibleDesktop = 6;  // >= md4
    // The server first hides by the desktop two-row count, then the front end adjusts to the current breakpoint
    $initialVisible = $initialVisibleDesktop;
    $listPaddingTop = $listPaddingTop ?? __('py-16');
@endphp

<section class="w-full bg-themeBg-a product_list product_list--grouped sec-bg-white">
    <div class="sec-pad mx-auto w-[calc(100%-30px)] max-w-[1200px] {{ $listPaddingTop }}">
        <div class="flex flex-col gap-[50px] md4:flex-row md4:items-start">
            @include('front.partials.product-list-sidebar', [
                'sidebarCategories' => $sidebarCategories ?? [],
                'sidebarRecommendProducts' => $sidebarRecommendProducts ?? [],
                'activeCategoryId' => $activeCategoryId ?? null,
            ])

            <div class="order-1 min-w-0 flex-1 md4:order-2">
        @forelse($categoryProductSections as $section)
            @php
                $products = $section['products'] ?? [];
                $total = count($products);
                $sectionId = (int)($section['id'] ?? 0);
            @endphp
            <div
                class="js-category-product-section mb-12 last:mb-0"
                data-section-id="{{ $sectionId }}"
                data-total="{{ $total }}"
                data-expanded="0"
            >
                <div class="mb-6 flex flex-wrap items-end justify-between gap-3 border-b border-slate-200 pb-4">
                    <h2 class="text-f24 font-poppins-semibold uppercase tracking-wide text-themeText-f md1:text-f28">
                        <a href="{{ $section['url'] ?? '#' }}" class="transition hover:text-themeBg-d">{{ $section['name'] ?? '' }}</a>
                    </h2>
                </div>

                @if($total > 0)
                    <div class="grid grid-cols-1 gap-4 sm5:grid-cols-2 md4:grid-cols-3">
                        @foreach($products as $index => $p)
                            <div class="js-category-product-item {{ $index >= $initialVisible ? 'hidden' : '' }}" data-index="{{ $index }}">
                                @include('front.partials.product-list-card', ['p' => $p])
                            </div>
                        @endforeach
                    </div>

                    <div class="js-category-more-actions mt-8 flex justify-center gap-4 {{ $total > $initialVisible ? '' : 'hidden' }}">
                        <button
                            type="button"
                            class="js-category-view-more inline-flex items-center justify-center bg-themeBg-h px-10 py-3.5 text-f14 font-poppins-medium uppercase tracking-wide text-themeText-f transition hover:bg-slate-300"
                            data-section-id="{{ $sectionId }}"
                        >{{ __('View More') }}</button>
                        <button
                            type="button"
                            class="js-category-hide-more hidden inline-flex items-center justify-center border border-slate-300 bg-white px-10 py-3.5 text-f14 font-poppins-medium uppercase tracking-wide text-themeText-f transition hover:bg-slate-50"
                            data-section-id="{{ $sectionId }}"
                        >{{ __('Hide More') }}</button>
                    </div>
                @else
                    <p class="py-8 text-center font-poppins-regular text-f16 text-themeText-g">{{ __('No products in this category.') }}</p>
                @endif
            </div>
        @empty
            <div class="py-16 text-center">
                <p class="font-poppins-regular text-f16 text-themeText-g">{{ __('No products found.') }}</p>
            </div>
        @endforelse
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    var limits = {
        mobile: {{ (int)$initialVisibleMobile }},
        tablet: {{ (int)$initialVisibleTablet }},
        desktop: {{ (int)$initialVisibleDesktop }}
    };

    function getInitialVisible() {
        if (window.matchMedia('(min-width: 992px)').matches) return limits.desktop;
        if (window.matchMedia('(min-width: 420px)').matches) return limits.tablet;
        return limits.mobile;
    }

    function syncSection(section) {
        var total = parseInt(section.getAttribute('data-total') || '0', 10) || 0;
        var expanded = section.getAttribute('data-expanded') === '1';
        var initialVisible = getInitialVisible();
        var items = section.querySelectorAll('.js-category-product-item');
        var actions = section.querySelector('.js-category-more-actions');
        var viewMore = section.querySelector('.js-category-view-more');
        var hideMore = section.querySelector('.js-category-hide-more');
        var needToggle = total > initialVisible;

        items.forEach(function (item, index) {
            if (index < initialVisible) {
                item.classList.remove('hidden');
                return;
            }
            item.classList.toggle('hidden', !expanded);
        });

        if (actions) {
            actions.classList.toggle('hidden', !needToggle);
        }
        if (viewMore) {
            viewMore.classList.toggle('hidden', !needToggle || expanded);
        }
        if (hideMore) {
            hideMore.classList.toggle('hidden', !needToggle || !expanded);
        }
    }

    function syncAll() {
        document.querySelectorAll('.js-category-product-section').forEach(syncSection);
    }

    document.querySelectorAll('.js-category-view-more').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var section = btn.closest('.js-category-product-section');
            if (!section) return;
            section.setAttribute('data-expanded', '1');
            syncSection(section);
        });
    });

    document.querySelectorAll('.js-category-hide-more').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var section = btn.closest('.js-category-product-section');
            if (!section) return;
            section.setAttribute('data-expanded', '0');
            syncSection(section);
        });
    });

    syncAll();

    var resizeTimer = null;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(syncAll, 120);
    });
})();
</script>
