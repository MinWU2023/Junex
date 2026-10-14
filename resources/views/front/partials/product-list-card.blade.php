@php
    $id = (int)($id ?? ($p['id'] ?? 0));
    $name = (string)($name ?? ($p['name'] ?? ''));
    $image = (string)($image ?? ($p['image'] ?? ''));
    $alt = (string)($alt ?? ($p['alt'] ?? $name));
    $image = front_webp_url($image !== '' ? $image : '/front/imgs/index_rc_01.png');
    $url = (string)($url ?? ($p['url'] ?? '#'));
    $model = (string)($model ?? ($p['model'] ?? ($p['item_no'] ?? '')));
    $brief = (string)($brief ?? ($p['brief'] ?? ($p['brief_content'] ?? '')));
    $favorite = (int)($favorite ?? (!empty($p['is_favorited']) ? 1 : 0));
    $imageClass = $imageClass ?? 'w-full h-auto transition-transform duration-300 group-hover:scale-110';
    $showFavorite = $showFavorite ?? false;
    $showBrief = $showBrief ?? false;
    $showModel = $showModel ?? false;
@endphp

<article class="product-list-card group flex h-full flex-col overflow-hidden border border-slate-200/80 bg-white">
    <div class="relative overflow-hidden bg-themeBg-f">
        <a href="{{ $url }}" class="block">
            <img class="{{ $imageClass }}" src="{{ $image }}" alt="{{ $alt }}" loading="lazy" />
        </a>
        @if($showFavorite)
        <button type="button"
                class="collect-btn js-prefer-toggle absolute top-[16px] right-[16px] z-10 flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white cursor-pointer shadow-sm"
                aria-label="{{ __('Collect') }}"
                data-product-id="{{ $id }}"
                data-favorite="{{ $favorite }}">
            <img class="uncollect-icon h-[15px] w-[16px] {{ $favorite ? 'hidden' : '' }}" src="{{ front_webp_url('/front/icons/uncollect.png') }}" alt="{{ __('Uncollect') }}" />
            <img class="collect-icon h-[15px] w-[16px] {{ $favorite ? '' : 'hidden' }}" src="{{ front_webp_url('/front/icons/collect.png') }}" alt="{{ __('Collect') }}" />
        </button>
        @endif
    </div>
    <div class="flex flex-1 flex-col px-3 pb-0 pt-3 text-center">
        <a href="{{ $url }}" class="block">
            <h4 class="text-[14px] font-poppins-medium leading-[22px] text-themeText-f line-clamp-2">{{ $name }}</h4>
        </a>
        @if($showBrief && trim(strip_tags($brief)) !== '')
        <div class="mt-1 text-f14 font-poppins-regular leading-6 text-themeText-p line-clamp-3">{!! $brief !!}</div>
        @endif
        @if($showModel && $model !== '')
        <p class="mt-1 text-f14 font-poppins-regular text-themeText-p">{{ __('Item No.:') }} {{ $model }}</p>
        @endif
    </div>
    <div class="js-inquiry-toggle-wrap mt-3 flex items-center justify-center gap-2 border-t border-slate-200 px-3 py-3">
        <input
            type="checkbox"
            class="js-inquiry-toggle h-4 w-4 cursor-pointer accent-themeBg-d"
            data-product-id="{{ $id }}"
            data-product-name="{{ $name }}"
            data-product-image="{{ $image }}"
            data-product-url="{{ $url }}"
            data-product-model="{{ $model }}"
            aria-label="{{ __('Inquire Now') }}"
        />
        <span class="cursor-pointer text-f14 font-poppins-medium text-themeText-f">{{ __('Inquire Now') }}</span>
    </div>
</article>
