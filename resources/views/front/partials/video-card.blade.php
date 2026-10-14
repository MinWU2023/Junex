@php
    $url = $url ?? '#';
    $image = $image ?? front_webp_url('/front/imgs/video-item.png');
    $date = $date ?? '';
    $title = $title ?? '';
    $videoUrl = $videoUrl ?? '';
    $buttonText = $buttonText ?? __('Learn More');
    $alt = $alt ?? '';
    $compact = !empty($compact);

    if (!empty($item) && is_array($item)) {
        $url = $item['url'] ?? $url;
        $image = $item['image'] ?? $image;
        $date = $item['date'] ?? $date;
        $title = $item['title'] ?? $title;
        $videoUrl = $item['video_url'] ?? $videoUrl;
        $buttonText = $item['button_text'] ?? $buttonText;
        $alt = $item['alt'] ?? $alt;
    }
    if ($alt === '') {
        $alt = $title !== '' ? $title : 'Video cover';
    }
    $image = front_webp_url($image);
@endphp

<article class="video-card {{ $compact ? 'video-card--compact' : 'blog-card h-full bg-themeBg-g' }} group h-full overflow-hidden border border-slate-200/70 bg-white transition hover:border-themeBg-d/40 hover:shadow-md">
    <a href="javascript:void(0)" class="js-video-modal block" data-video-url="{{ $videoUrl }}">
        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
            <img
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                src="{{ $image }}"
                alt="{{ $alt }}"
                loading="lazy"
                data-fallback-hq="{{ youtube_thumbnail_url($videoUrl, 'hqdefault') }}"
                data-fallback-local="{{ front_webp_url('/front/imgs/video-item.png') }}"
                onerror="if(this.dataset.fallbackHq && this.src!==this.dataset.fallbackHq){this.src=this.dataset.fallbackHq;}else if(this.dataset.fallbackLocal && this.src!==this.dataset.fallbackLocal){this.src=this.dataset.fallbackLocal;}else{this.onerror=null;}"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-black/5 to-transparent" aria-hidden="true"></div>
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                <span class="video-card__play video-play-btn inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/80 bg-white/15 text-white backdrop-blur-[1px] transition md1:h-12 md1:w-12">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7L8 5z" /></svg>
                </span>
            </div>
        </div>
    </a>
    <div class="{{ $compact ? 'px-3 py-3 md1:px-3.5 md1:py-3.5' : 'blog-card__body px-5 pb-5 pt-4' }}">
        @if(!$compact && $date !== '')
        <div class="blog-card__date text-f14 font-poppins-regular text-themeText-p">{{ $date }}</div>
        <div class="blog-card__divider" aria-hidden="true"></div>
        @endif
        <a href="{{ $url }}" class="{{ $compact ? 'video-card__title block text-f14 font-poppins-medium leading-snug text-themeText-f transition hover:text-themeBg-d md1:text-f15' : 'blog-card__title' }}">
            @if($compact)
                {{ $title }}
            @else
                <span class="line-clamp-3">{{ $title }}</span>
            @endif
        </a>
        @if(!$compact)
        <div class="mt-4">
            <a href="{{ $url }}" class="blog-card__cta">{{ $buttonText }}</a>
        </div>
        @endif
    </div>
</article>
