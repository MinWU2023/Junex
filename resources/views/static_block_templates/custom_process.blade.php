<section class="w-full custom_process sec-bg-white">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="sec-pad py-16">
        <div class="text-center">
        <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f ">
            {{ $customProcess['title'] ?? '' }}
        </h2>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 w-[100% - 30px] max-w-[825px] leading-6 text-f16 font-poppins-regular text-themeText-g">
            {{ $customProcess['description'] ?? '' }}
        </p>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-[15px] md4:grid-cols-[25.4%_50%_25.4%] md4:items-stretch">
        <div class="flex h-full flex-col gap-[15px]">
            @foreach(($customProcess['left_steps'] ?? []) as $step)
            <article class="flex flex-1 flex-col overflow-hidden shadow-sm bg-themeBg-g px-2 py-2">
            <div class="px-4 md1:py-[26px]">
                <div class="text-f20 font-poppins-medium">{{ $step['label'] ?? '' }}</div>
                <div class="mt-1 text-f22 font-poppins-semibold">{{ $step['title'] ?? '' }}</div>
                <div class="mt-2 leading-5 font-poppins-regular text-f14">{{ $step['description'] ?? '' }}</div>
            </div>
            <div class="px-4 pb-10">
                <img class="object-contain" src="{{ $step['image_url'] ?? '' }}" alt="{{ $step['label'] ?? '' }}" loading="lazy" />
            </div>
            </article>
            @endforeach
        </div>

        <div class="overflow-hidden bg-themeBg-g shadow-sm flex h-full flex-col justify-center">
            <div class="px-6 pt-6 text-center md1:px-7 md1:pt-7">
            <div class="font-poppins-semibold text-f32 text-slate-900">{{ $customProcess['center']['label'] ?? '' }}</div>
            </div>

            <div class="flex items-center justify-center px-4 pb-6 pt-4 md1:px-6 md1:pb-7">
            <img class="h-auto w-full max-w-[520px] object-cover" src="{{ $customProcess['center']['image_url'] ?? '' }}" alt="Product" loading="lazy" />
            </div>

            <div class="px-6 pb-6 text-center leading-5 md1:px-7 md1:pb-7 text-f16 font-poppins-regular">
            {{ $customProcess['center']['description'] ?? '' }}
            </div>
        </div>

        <div class="flex h-full flex-col gap-[15px]">
            @foreach(($customProcess['right_steps'] ?? []) as $step)
            <article class="flex flex-1 flex-col overflow-hidden shadow-sm bg-themeBg-g px-2 py-2">
            <div class="px-4 md1:py-[26px]">
                <div class="text-f20 font-poppins-medium">{{ $step['label'] ?? '' }}</div>
                <div class="mt-1 text-f22 font-poppins-semibold">{{ $step['title'] ?? '' }}</div>
                <div class="mt-2 leading-5 font-poppins-regular text-f14">{{ $step['description'] ?? '' }}</div>
            </div>
            <div class="px-4 pb-10">
                <img class="object-contain" src="{{ $step['image_url'] ?? '' }}" alt="{{ $step['label'] ?? '' }}" loading="lazy" />
            </div>
            </article>
            @endforeach
        </div>
        </div>
    </div>
    </div>
</section>
