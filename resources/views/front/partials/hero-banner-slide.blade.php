@php
    $slidePath = $slidePath ?? ($item['path'] ?? '');
    $slideAlt = $item['alt'] ?? __('Banner');
@endphp
<div class="swiper-slide relative">
    <img class="absolute inset-0 h-full w-full object-cover" src="{{ $slidePath }}" alt="{{ $slideAlt }}" loading="lazy" />
    <div class="absolute inset-0 bg-black/30" aria-hidden="true"></div>
    <div class="relative z-10 flex h-full items-center">
        <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
            <div class="mx-auto max-w-[720px] text-center text-white">
                <h2 class="text-[18px] font-semibold leading-tight sm1:text-[20px] sm2:text-[22px] sm3:text-[24px] sm4:text-[26px] sm6:text-[28px] md1:text-[30px] md2:text-[32px] md3:text-[34px] md4:text-[36px] mb-2 md1:mb-6">
                    {!! $item['title'] ?? '' !!}
                </h2>
                <p class="mt-0 text-[11px] leading-5 text-white sm2:text-[12px] sm4:text-[13px] sm6:text-[14px] md1:mt-4 md1:leading-6 md2:text-[15px] md4:text-[16px] mb-3 md1:mb-8">
                    {{ $item['description'] ?? '' }}
                </p>
                @if(!empty($item['url']))
                    <a href="{{ $item['url'] }}" class="hero-cta-btn mx-auto mt-2 inline-flex w-fit items-center justify-center rounded-lg border border-white/80 bg-black/40 px-6 py-2 text-sm font-bold uppercase tracking-wider text-white backdrop-blur-sm transition-all duration-300 hover:bg-black/70 md1:mt-7 md1:px-10 md1:py-3.5 md1:text-base">
                        {{ $item['button_text'] ?? __('Get More') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
