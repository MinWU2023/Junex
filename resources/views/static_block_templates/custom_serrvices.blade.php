<section class="w-full bg-cover bg-center bg-no-repeat custom_serrvices sec-bg-white" style="background-image: url('{{ $customServices['bg_image_url'] ?? '' }}')">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="sec-pad py-16">
        <div class="text-center">
        <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
            __SECTION_TITLE__
        </h2>
        <div class="mx-auto mt-3 h-1.5 w-12 rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 w-[100% - 30px] max-w-[825px] text-f16 leading-6 font-poppins-regular  text-themeColor-g">
            __SECTION_SUBTITLE__
        </p>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-5 md4:grid-cols-2 mb-4">
        <div class="px-[18px] bg-themeBg-g py-[24px] bg-top bg-no-repeat" style="background-image: url('{{ $customServices['odm']['bg_image_url'] ?? '' }}')">
            <div class="text-center">
            <h3 class="font-poppins-semibold  tracking-wide text-slate-900 text-f22">
                <span class="text-themeBg-d">{{ $customServices['odm']['title_prefix'] ?? '' }}</span> {{ $customServices['odm']['title_suffix'] ?? '' }}
            </h3>
            <p class="mt-1 text-f16 font-poppins-regular">{{ $customServices['odm']['subtitle'] ?? '' }}</p>
            </div>

            <!-- Mobile Swiper -->
            <div class="mt-5 block md1:hidden">
            <div class="swiper odm-swiper">
                <div class="swiper-wrapper">
                @foreach(($customServices['odm']['items'] ?? []) as $row)
                <div class="swiper-slide">
                    <a href="{{ $row['url'] ?? '#' }}" class="group relative h-[265px] block overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70">
                    <img class="h-[265px] w-full object-cover" src="{{ $row['image_url'] ?? '' }}" alt="{{ $row['title'] ?? '' }}" loading="lazy" />
                    <div class="absolute inset-x-0 bottom-0 p-3">
                        <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium">
                        <span class="cs-line-clamp-2 leading-[20px]">{{ $row['title'] ?? '' }}</span>
                        </div>
                    </div>
                    </a>
                </div>
                @endforeach
                </div>
                <div class="swiper-pagination odm-pagination mt-4"></div>
            </div>
            </div>

            <!-- Desktop Grid -->
            <div class="mt-5 hidden md1:grid grid-cols-2 gap-4 md1:gap-5">
            @foreach(($customServices['odm']['items'] ?? []) as $row)
            <a href="{{ $row['url'] ?? '#' }}" class="group relative h-[265px] overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2">
                <img class="h-[265px] w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="{{ $row['image_url'] ?? '' }}" alt="{{ $row['title'] ?? '' }}" loading="lazy" />
                <div class="absolute inset-x-0 bottom-0 p-3">
                <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium transition duration-300 group-hover:-translate-y-1 group-hover:bg-black/60">
                    <span class="cs-line-clamp-2 leading-[20px]">{{ $row['title'] ?? '' }}</span>
                </div>
                </div>
            </a>
            @endforeach
            </div>
        </div>

        <div class="px-[18px] bg-themeBg-g py-[24px] bg-top bg-no-repeat" style="background-image: url('{{ $customServices['oem']['bg_image_url'] ?? '' }}')">
            <div class="text-center">
            <h3 class="font-poppins-semibold  tracking-wide text-slate-900 text-f22">
                <span class="text-themeBg-d">{{ $customServices['oem']['title_prefix'] ?? '' }}</span> {{ $customServices['oem']['title_suffix'] ?? '' }}
            </h3>
            <p class="mt-1 text-f16 font-poppins-regular">{{ $customServices['oem']['subtitle'] ?? '' }}</p>
            </div>

            <!-- Mobile Swiper -->
            <div class="mt-5 block md1:hidden">
            <div class="swiper oem-swiper">
                <div class="swiper-wrapper">
                @foreach(($customServices['oem']['items'] ?? []) as $row)
                <div class="swiper-slide">
                    <a href="{{ $row['url'] ?? '#' }}" class="group relative h-[265px] block overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70">
                    <img class="w-full object-cover" src="{{ $row['image_url'] ?? '' }}" alt="{{ $row['title'] ?? '' }}" loading="lazy" />
                    <div class="absolute inset-x-0 bottom-0 p-3">
                        <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium">
                        <span class="cs-line-clamp-2">{{ $row['title'] ?? '' }}</span>
                        </div>
                    </div>
                    </a>
                </div>
                @endforeach
                </div>
                <div class="swiper-pagination oem-pagination mt-4"></div>
            </div>
            </div>

            <!-- Desktop List -->
            <div class="mt-5 hidden md1:block">
            @foreach(($customServices['oem']['items'] ?? []) as $row)
            <a href="{{ $row['url'] ?? '#' }}" class="group relative h-[265px] overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2 mb-5 block">
                <img class="w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="{{ $row['image_url'] ?? '' }}" alt="{{ $row['title'] ?? '' }}" loading="lazy" />
                <div class="absolute inset-x-0 bottom-0 p-3">
                <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium transition duration-300 group-hover:-translate-y-1 group-hover:bg-black/60">
                    <span class="cs-line-clamp-2">{{ $row['title'] ?? '' }}</span>
                </div>
                </div>
            </a>
            @endforeach
            </div>
        </div>
        </div>
    </div>
    </div>
</section>
