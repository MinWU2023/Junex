<section class="w-full bg-white processes sec-bg-white">
    <div class="sec-pad mx-auto w-full max-w-[1200px] px-4 py-16 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="text-center">
        <div class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">{{ $processes['title'] ?? '' }}</div>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 max-w-[825px] leading-6 text-slate-600 text-f16 font-poppins-regular text-themeText-g">
        {{ $processes['description'] ?? '' }}
        </p>
    </div>

    <div class="mt-8 space-y-7 md4:mt-10 md4:space-y-8">
        @foreach(($processes['steps'] ?? []) as $step)
        <div class="pb-4">
        <div class="relative">
            <div class="flex min-h-[54px] w-full items-center bg-themeBg-g px-4 pl-[66px] text-f20 font-poppins-medium text-themeText-f">{{ $step['title'] ?? '' }}</div>
            <div class="absolute left-0 top-[-8px] flex h-[50px] w-[50px] items-center justify-center bg-themeBg-d text-f20 font-poppins-semibold text-white">{{ $step['no'] ?? '' }}.</div>
        </div>
        <p class="mt-3 text-f14 leading-[22px] text-themeText-g font-poppins-regular pb-4">
            {{ $step['description'] ?? '' }}
        </p>

        <div class="mt-4 grid {{ $step['grid_class'] ?? 'grid-cols-1 gap-4' }}">
            @foreach(($step['cards'] ?? []) as $card)
            <div class="bg-white shadow-sm ring-1 ring-black/5">
            <img class="w-full object-cover" src="{{ $card['image_url'] ?? '' }}" alt="{{ $card['alt'] ?? '' }}" loading="lazy" />
            <div class="px-2 py-2 text-center text-f16 font-poppins-medium text-themeText-f">{{ $card['label'] ?? '' }}</div>
            </div>
            @endforeach
        </div>
        </div>
        @endforeach
    </div>
    </div>
</section>
