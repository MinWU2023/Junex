<section class="relative w-full overflow-hidden bg-white solutions sec-bg-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
    <img src="{{ $solutions['bg_image_url'] ?? '' }}" alt="" class="h-full w-full object-cover" loading="lazy" />
    </div>

    <div class="sec-pad relative mx-auto w-full max-w-[1200px] px-4 py-16 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="flex flex-col items-center gap-8 md4:flex-row md4:gap-0">
        <div class="relative w-full md4:w-[54%]">
        <div class="relative mx-auto max-w-[520px] md4:max-w-none">
            <div class="relative">
            <div class="overflow-hidden">
                <img class="h-auto w-full object-cover" src="{{ $solutions['left_image_url'] ?? '' }}" alt="Solutions" loading="lazy" />
            </div>
            </div>
        </div>
        </div>
        <div class="w-full md4:w-[calc(50%)] md4:-ml-[50px]">
        <div class="relative z-10 mx-auto w-full max-w-[520px] overflow-hidden bg-[#f3f3f3] p-[20px] shadow-sm sm6:p-[36px] md4:max-w-none md4:p-[50px]">
            <div class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">{!! $solutions['title'] ?? '' !!}</div>
            <div class="mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
            <p class="mt-5 text-[15px] leading-5 text-themeText-g font-poppins-regular">
            {{ $solutions['description'] ?? '' }}
            </p>
        </div>
        <div class="pointer-events-none absolute -right-6 top-[140px] hidden h-[110px] w-[110px] md4:block" aria-hidden="true">
            <div class="grid h-full w-full grid-cols-10 gap-1">
                @for($i = 0; $i < 100; $i++)
                <div class="h-1 w-1 rounded-full bg-red-600"></div>
                @endfor
            </div>
        </div>
        </div>
    </div>
    </div>
</section>
