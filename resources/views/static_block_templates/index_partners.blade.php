@if(!empty($partners['logos']))
<section class="w-full bg-[#F7F7F7] lg1:px-0 px-4 partners sec-bg-color">
    <div class="mx-auto w-full max-w-[1200px] px-0">
    <div class="sec-pad py-5 md1:py-8 md4:py-12 lg1:py-16">
        {{-- PC：静态环绕排列 --}}
        <div class="partners-static partners-grid flex flex-wrap items-center justify-around gap-x-[30px] gap-y-4">
        @foreach(($partners['logos'] ?? []) as $item)
        <div class="flex items-center justify-center">
            <img class="transition-transform duration-200 will-change-transform" src="{{ $item['src'] ?? '' }}" alt="{{ $item['name'] ?? ('Brand logo ' . $loop->iteration) }}" loading="lazy" />
        </div>
        @endforeach
        </div>

        {{-- 手机 / 平板：自动轮播（&lt;992px 显示） --}}
        <div class="swiper partners-swiper" aria-label="Partner logos">
            <div class="swiper-wrapper">
                @foreach(($partners['logos'] ?? []) as $item)
                <div class="swiper-slide">
                    <div class="partners-slide-inner">
                        <img src="{{ $item['src'] ?? '' }}" alt="{{ $item['name'] ?? ('Brand logo ' . $loop->iteration) }}" loading="lazy" />
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="swiper-pagination partners-pagination" aria-hidden="true"></div>
    </div>
    </div>
</section>
@endif
