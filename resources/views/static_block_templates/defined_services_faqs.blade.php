<section class="relative w-full bg-cover bg-center bg-no-repeat faqs sec-bg-white" style="background-image: url('{{ $definedServices['faqs_bg_image_url'] ?? '' }}')">
    <div class="sec-pad mx-auto w-[calc(100%-30px)] max-w-[1200px] py-16">
    <div class="mx-auto max-w-[1200px] text-center">
        <div class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
        {{ $definedServices['faqs_title'] ?? '' }}
        </div>
        <div class="mt-3 flex justify-center">
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        </div>
        <p class="mx-auto mt-4 max-w-[860px] text-f16 leading-6 text-themeText-g  sm6:leading-7">
        {{ $definedServices['faqs_description'] ?? '' }}
        </p>
    </div>

    <div class="mt-10 flex flex-col gap-8 md2:gap-10 md4:flex-row md4:items-center">
        <div class="w-full md4:w-1/2">
        <div class="space-y-8">
            @foreach(($definedServices['faqs'] ?? []) as $row)
            <div>
            <div class="text-f20 font-poppins-medium text-themeText-f">{{ $row['title'] ?? '' }}</div>
            <p class="mt-2 text-f16 leading-6 text-themeText-g font-poppins-regular">{{ $row['content'] ?? '' }}</p>
            </div>
            @endforeach
        </div>
        </div>

        <div class="w-full md4:w-1/2">
        <div class="mx-auto w-full max-w-[520px] bg-white shadow-[0_10px_30px_rgba(0,0,0,0.12)] md4:max-w-none">
            <div class="relative overflow-hidden bg-slate-100">
            <img class="h-[220px] w-full object-cover sm6:h-[260px] md2:h-[300px] md4:h-[320px]" src="{{ $definedServices['faqs_right_image_url'] ?? '' }}" alt="FAQs" loading="lazy" />
            </div>
        </div>
        </div>
    </div>
    </div>
</section>
