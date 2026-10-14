@php
    $variant = $variant ?? __('link'); // link | product | blog | contact
    $scene = in_array($variant, ['product', 'blog'], true) ? 'share' : 'link';
    $snsIcons = $snsIcons
        ?? ($scene === 'share'
            ? ($data['snsShareIcons'] ?? sns_icons('share'))
            : ($data['snsIcons'] ?? sns_icons('link')));
    $shareUrl = $shareUrl ?? url()->current();
    $shareTitle = $shareTitle ?? '';
    $shareImage = $shareImage ?? '';
@endphp
@if(!empty($snsIcons))
    @foreach($snsIcons as $icon)
        @php
            $href = trim((string)($icon['link'] ?? ''));
            if ($href === '') {
                $href = '#';
            }
            $alt = (string)($icon['alt'] ?? '');
            $sign = (string)($icon['sign'] ?? '');
            $iconUrl = (string)($icon['icon_url'] ?? '');
        @endphp
        @if($variant === 'product')
            <a href="{{ $href }}"
               class="product-share-link js-sns-share"
               data-sns-sign="{{ $sign }}"
               data-share-url="{{ $shareUrl }}"
               data-share-title="{{ $shareTitle }}"
               data-share-image="{{ $shareImage }}"
               aria-label="{{ $alt }}"
               rel="noopener noreferrer">
                <img src="{{ $iconUrl }}" class="h-6 w-6" alt="{{ $alt }}" loading="lazy" />
            </a>
        @elseif($variant === 'blog')
            <a href="{{ $href }}"
               class="inline-flex h-[30px] w-[30px] items-center justify-center overflow-hidden js-sns-share"
               data-sns-sign="{{ $sign }}"
               data-share-url="{{ $shareUrl }}"
               data-share-title="{{ $shareTitle }}"
               data-share-image="{{ $shareImage }}"
               aria-label="{{ $alt }}"
               rel="noopener noreferrer">
                <img src="{{ $iconUrl }}" class="h-[30px] w-[30px] object-contain" alt="{{ $alt }}" loading="lazy" />
            </a>
        @elseif($variant === 'contact')
            <a href="{{ $href }}"
               class="sns-icon-link inline-flex h-8 w-8 items-center justify-center overflow-hidden rounded transition hover:opacity-90"
               data-sns-sign="{{ $sign }}"
               aria-label="{{ $alt }}"
               @if($href !== '#') target="_blank" rel="noopener noreferrer" @endif>
                <img src="{{ $iconUrl }}" class="h-8 w-8 object-contain" alt="{{ $alt }}" loading="lazy" />
            </a>
        @else
            <a href="{{ $href }}"
               class="inline-flex items-center justify-center transition duration-200 hover:-translate-y-0.5 hover:opacity-95"
               aria-label="{{ $alt }}"
               @if($href !== '#') target="_blank" rel="noopener noreferrer" @endif>
                <img src="{{ $iconUrl }}" class="h-[38px] w-[38px] object-contain" alt="{{ $alt }}" loading="lazy" />
            </a>
        @endif
    @endforeach
@endif
