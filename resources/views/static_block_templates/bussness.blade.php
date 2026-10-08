<section class="w-full bg-white bussness sec-bg-white">
    <div class="sec-pad mx-auto w-full max-w-[1200px] px-4 py-16 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="text-center">
        <div class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">{{ $bussness['title'] ?? '' }}</div>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 max-w-[825px] leading-6 text-slate-600 text-f16 font-poppins-regular text-themeText-g">
        {{ $bussness['description'] ?? '' }}
        </p>
    </div>

    <div class="mt-8 flex flex-col gap-5 md4:mt-10 md4:flex-row md4:gap-5">
        <div class="md4:w-[32.25%] md4:flex-shrink-0">
        <div class="overflow-hidden">
            <img class="w-full object-cover" src="{{ $bussness['left_image_url'] ?? '' }}" alt="{{ $bussness['left_image_alt'] ?? 'Business philosophy' }}" loading="lazy" />
        </div>
        </div>

        <div class="md4:flex-1">
        <div class="grid grid-cols-1 gap-4 sm6:grid-cols-2 sm6:gap-5">
            @foreach(($bussness['items'] ?? []) as $row)
            <div class="bg-[#f3f3f3] p-6 md1:p-7">
            <div class="flex flex-col items-start gap-4">
                <div class="flex items-center justify-center">
                <img src="{{ $row['icon_url'] ?? '' }}" alt="{{ $row['title'] ?? '' }}" class="h-auto w-auto max-w-[50px]" loading="lazy" />
                </div>
                <div>
                <div class="text-f20 font-poppins-medium text-themeText-f">{{ $row['title'] ?? '' }}</div>
                <p class="mt-2 text-[15px] leading-5 text-themeText-g">
                    {{ $row['description'] ?? '' }}
                </p>
                </div>
            </div>
            </div>
            @endforeach
        </div>
        </div>
    </div>
    </div>
</section>
