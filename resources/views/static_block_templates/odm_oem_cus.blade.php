<section class="relative w-full overflow-hidden bg-white odm_oem_cus sec-bg-white">
    <div class="pointer-events-none absolute inset-0 opacity-40" aria-hidden="true">
    <div class="h-full w-full bg-center bg-no-repeat bg-cover" style="background-image: url('{{ $odmOemCus['bg_image_url'] ?? '' }}')"></div>
    </div>
    <div class="relative mx-auto w-full max-w-[1200px] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
    <div class="sec-pad py-16">
        <div class="relative w-full overflow-visible  bg-themeBg-g px-4 py-5 ring-1 ring-black/5 sm6:px-6">
        <div class="absolute -left-0 -top-2 flex h-[50px] w-[50px] items-center justify-center bg-themeBg-d" aria-hidden="true">
            <svg viewBox="0 0 24 24" class="h-[30px] w-[27px] text-white" fill="currentColor">
                <path d="M5 20h14v2H5v-2zM6 2h9l3 3v13H6V2zm9 1.5V6h2.5L15 3.5zM8 9h8v2H8V9zm0 4h8v2H8v-2z" />
            </svg>
        </div>

        <div class="pl-14 sm6:pl-16">
            <div class="text-f26 font-poppins-medium uppercase tracking-wide text-themeText-f"><span class="text-themeText-h">{{ $odmOemCus['title_prefix'] ?? '' }}</span> {{ $odmOemCus['title_suffix'] ?? '' }}</div>
            <p class="mt-2 text-f14 leading-5 text-themeText-g font-poppins-regular px-[5px]">
            {!! nl2br(e($odmOemCus['description'] ?? '')) !!}
            </p>
        </div>
        </div>

        <div class="mt-8 flex flex-col gap-5 md2:flex-row ">
        @foreach(($odmOemCus['items'] ?? []) as $row)
        <div class="flex-1">
            <div class="w-full overflow-hidden bg-white ring-1 ring-black/10">
            <div class="aspect-[16/9] w-full bg-themeBg-c">
                <img class="h-full w-full object-cover" src="{{ $row['image_url'] ?? '' }}" alt="{{ $row['title'] ?? '' }}" loading="lazy" />
            </div>
            </div>
            <div class="mt-4 text-center">
            <div class="text-f20 font-poppins-medium text-themeText-f ">{{ $row['title'] ?? '' }}</div>
            <p class="mt-2 text-f14 leading-5 text-themeText-g font-poppins-regular px-[5px]">
                {{ $row['description'] ?? '' }}
            </p>
            </div>
        </div>
        @endforeach
        </div>
    </div>
    </div>
</section>
