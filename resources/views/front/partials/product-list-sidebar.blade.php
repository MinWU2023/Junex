{{-- Product list page sidebar: Categories + New Products (aligned with secondpagesport) --}}
@php
    $sidebarCategories = $sidebarCategories ?? [];
    $sidebarRecommendProducts = $sidebarRecommendProducts ?? [];
@endphp

<aside class="product-list-sidebar order-2 w-full shrink-0 md4:order-1 md4:w-[360px]">
    {{-- Categories --}}
    <section class="pls-block pls-cats is-collapsed">
        <button type="button" class="pls-title js-pls-section-toggle" aria-expanded="false" aria-controls="pls-cats-body">
            <span class="pls-title-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="h-[18px] w-[18px]" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round">
                    <path d="M8 7h11M8 12h11M8 17h11" />
                    <circle cx="5" cy="7" r="1.2" fill="#fff" stroke="none" />
                    <circle cx="5" cy="12" r="1.2" fill="#fff" stroke="none" />
                    <circle cx="5" cy="17" r="1.2" fill="#fff" stroke="none" />
                </svg>
            </span>
            <em>{{ __('Categories') }}</em>
            <span class="pls-title-chevron" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="pls-chevron-down" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9l6 6 6-6" />
                </svg>
                <svg viewBox="0 0 24 24" class="pls-chevron-up" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 15l6-6 6 6" />
                </svg>
            </span>
        </button>
        <nav id="pls-cats-body" class="pls-cat-body pls-section-body" aria-label="{{ __('Product categories') }}" hidden>
            @if(!empty($sidebarCategories))
                <ul class="pls-mtree">
                    @include('front.partials.product-list-sidebar-category-nodes', [
                        'nodes' => $sidebarCategories,
                        'depth' => 0,
                    ])
                </ul>
            @else
                <p class="px-3 py-2 text-f14 font-poppins-regular text-themeText-p">{{ __('No categories') }}</p>
            @endif
        </nav>
    </section>

    {{-- New Products --}}
    @if(!empty($sidebarRecommendProducts))
    <section class="pls-block pls-new is-collapsed">
        <button type="button" class="pls-title js-pls-section-toggle" aria-expanded="false" aria-controls="pls-new-body">
            <span class="pls-title-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="h-[18px] w-[18px]" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round">
                    <path d="M8 7h11M8 12h11M8 17h11" />
                    <circle cx="5" cy="7" r="1.2" fill="#fff" stroke="none" />
                    <circle cx="5" cy="12" r="1.2" fill="#fff" stroke="none" />
                    <circle cx="5" cy="17" r="1.2" fill="#fff" stroke="none" />
                </svg>
            </span>
            <em>{{ __('New Products') }}</em>
            <span class="pls-title-chevron" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="pls-chevron-down" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9l6 6 6-6" />
                </svg>
                <svg viewBox="0 0 24 24" class="pls-chevron-up" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 15l6-6 6 6" />
                </svg>
            </span>
        </button>
        <div id="pls-new-body" class="pls-new-body pls-section-body" hidden>
            <ul class="pls-new-list">
                @foreach($sidebarRecommendProducts as $item)
                <li>
                    <a href="{{ $item['url'] ?? '#' }}" class="pls-new-item">
                        <span class="pls-new-img">
                            <img
                                src="{{ $item['image'] ?: front_webp_url('/front/imgs/index_rc_01.png') }}"
                                alt="{{ $item['alt'] ?? ($item['name'] ?? '') }}"
                                loading="lazy"
                            />
                        </span>
                        <span class="pls-new-title">{{ $item['name'] ?? '' }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </section>
    @endif
</aside>

<script>
(function () {
    document.querySelectorAll('.product-list-sidebar .js-pls-toggle').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var li = btn.closest('li');
            if (!li) return;
            var children = li.querySelector(':scope > .js-pls-children');
            if (!children) return;
            var willOpen = children.classList.contains('hidden');
            children.classList.toggle('hidden', !willOpen);
            li.classList.toggle('is-open', willOpen);
            btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        });
    });

    var mqDesktop = window.matchMedia('(min-width: 992px)');

    function setSectionOpen(block, open) {
        var btn = block.querySelector('.js-pls-section-toggle');
        var body = block.querySelector('.pls-section-body');
        if (!body) return;
        block.classList.toggle('is-collapsed', !open);
        block.classList.toggle('is-expanded', open);
        body.hidden = !open;
        if (btn) btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    function syncSidebarSections() {
        document.querySelectorAll('.product-list-sidebar .pls-block').forEach(function (block) {
            setSectionOpen(block, mqDesktop.matches);
        });
    }

    document.querySelectorAll('.product-list-sidebar .js-pls-section-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (mqDesktop.matches) return;
            var block = btn.closest('.pls-block');
            if (!block) return;
            var willOpen = block.classList.contains('is-collapsed');
            setSectionOpen(block, willOpen);
        });
    });

    syncSidebarSections();
    if (mqDesktop.addEventListener) mqDesktop.addEventListener('change', syncSidebarSections);
    else if (mqDesktop.addListener) mqDesktop.addListener(syncSidebarSections);
})();
</script>
