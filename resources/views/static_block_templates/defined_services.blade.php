<section class="relative w-full overflow-hidden defined_services sec-bg-white">
    <div class="absolute inset-0 bg-center bg-no-repeat bg-cover" style="background-image: url('{{ $definedServices['bg_image_url'] ?? '' }}')" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-black/55" aria-hidden="true"></div>
    <div class="relative mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="sec-pad py-16">
        <div class="text-center">
        <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-white">
            {{ $definedServices['title'] ?? '' }}
        </h2>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 max-w-[760px] text-f16 leading-6 text-white">
            {{ $definedServices['description'] ?? '' }}
        </p>
        </div>

        <div class="mt-10 grid grid-cols-1 items-start gap-6 md4:grid-cols-2 md4:gap-7 lg1:gap-8">
        <div class="space-y-6 text-white">
            @foreach(($definedServices['faqs'] ?? []) as $row)
            <div>
            <h3 class="text-f20 font-poppins-semibold">{{ $row['title'] ?? '' }}</h3>
            <p class="mt-2 text-f16 leading-5 text-white">{{ $row['content'] ?? '' }}</p>
            </div>
            @endforeach
        </div>

        <div class="relative overflow-hidden">
            <img class="h-auto w-full object-contain" src="{{ $definedServices['right_image_url'] ?? '' }}" alt="Customize services products" loading="lazy" />
        </div>
        </div>
    </div>
    </div>
</section>
