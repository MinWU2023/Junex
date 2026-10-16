@php
    $url = $url ?? '#';
    $image = $image ?? front_webp_url('/front/imgs/index_rc_01.png');
    $title = $title ?? '';
    $buttonText = $buttonText ?? __('Learn More');
    $alt = $alt ?? '';

    if (!empty($item) && is_array($item)) {
        $url = $item['url'] ?? $url;
        $image = $item['image'] ?? $image;
        $title = $item['title'] ?? $title;
        $buttonText = $item['button_text'] ?? $buttonText;
        $alt = $item['alt'] ?? $alt;
    }
    if ($buttonText === '' || strcasecmp(trim((string) $buttonText), 'Learn More') === 0) {
        $buttonText = __('Learn More');
    }
    if ($alt === '') {
        $alt = $title !== '' ? $title : 'Blog cover';
    }
    $image = front_webp_url($image);
@endphp

<article class="blog-card h-full bg-themeBg-g">
    <a href="{{ $url }}" class="blog-card__media block shrink-0">
        <div class="relative aspect-[16/9] overflow-hidden bg-slate-100">
            <img class="blog-card__image h-full w-full object-cover transition-transform duration-300 hover:scale-105" src="{{ $image }}" alt="{{ $alt }}" loading="lazy" />
        </div>
    </a>
    <div class="blog-card__body px-5 pb-5 pt-4">
        <div class="blog-card__divider" aria-hidden="true"></div>
        <a href="{{ $url }}" class="blog-card__title">
            <span class="line-clamp-3">{{ $title }}</span>
        </a>
        <div class="blog-card__actions">
            <a href="{{ $url }}" class="blog-card__cta">
                {{ $buttonText }}
            </a>
        </div>
    </div>
</article>
