@php
    $eyebrow = $eyebrow ?? __('No Blogs');
    $title = $title ?? __('No Matching Blogs');
    $description = $description ?? __('Sorry, there are no blog posts to show right now. Please check back later or browse our products.');
    $primaryUrl = $primaryUrl ?? route('home');
    $primaryLabel = $primaryLabel ?? __('Back to Homepage');
    $secondaryUrl = $secondaryUrl ?? route('blogs');
    $secondaryLabel = $secondaryLabel ?? __('View Blogs');
    $imageAlt = $imageAlt ?? __('No blogs');
@endphp

<section class="w-full bg-white sec-bg-white">
    <div class="mx-auto w-full max-w-[1200px] px-4 py-14 sm2:px-5 md1:px-6 md1:py-20 lg1:px-0 lg1:py-24">
        <div class="flex flex-col items-center gap-10 md3:flex-row md3:items-center md3:justify-between md3:gap-12 lg1:gap-16">
            <div class="order-2 w-full flex-1 text-center md3:order-1 md3:text-left">
                <div class="inline-flex items-center rounded-full bg-[#FEECEC] px-4 py-1.5 text-f12 font-poppins-semibold uppercase tracking-[0.18em] text-themeBg-d md1:text-f14">
                    {{ $eyebrow }}
                </div>
                <h1 class="mt-5 text-f32 font-poppins-extrabold leading-tight text-themeText-a sm6:text-f36 md1:text-f40 lg1:text-f48">
                    {{ $title }}
                </h1>
                <p class="mx-auto mt-4 max-w-xl text-f15 font-poppins-regular leading-relaxed text-themeText-g md1:mt-5 md1:text-f16 md3:mx-0">
                    {{ $description }}
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-3 md3:justify-start md1:mt-10">
                    <a
                        href="{{ $primaryUrl }}"
                        class="inline-flex h-12 min-w-[200px] items-center justify-center rounded-none bg-themeBg-d px-8 text-f14 font-poppins-semibold uppercase tracking-wide text-white transition hover:bg-[#c22522] md1:h-[52px] md1:px-10 md1:text-f15"
                    >
                        {{ $primaryLabel }}
                    </a>
                    <a
                        href="{{ $secondaryUrl }}"
                        class="inline-flex h-12 min-w-[200px] items-center justify-center rounded-none border border-themeBg-d bg-white px-8 text-f14 font-poppins-semibold uppercase tracking-wide text-themeText-a transition hover:bg-themeBg-d hover:text-white md1:h-[52px] md1:px-10 md1:text-f15"
                    >
                        {{ $secondaryLabel }}
                    </a>
                </div>
            </div>

            <div class="order-1 flex w-full flex-1 justify-center md3:order-2 md3:justify-end">
                <div class="relative w-full max-w-[420px]">
                    <div class="pointer-events-none absolute -inset-3 rounded-[28px] bg-gradient-to-br from-[#FEECEC] via-white to-[#F7F8FA] md1:-inset-4" aria-hidden="true"></div>
                    <img
                        src="{{ front_webp_url('/front/imgs/no-products-illustration.svg') }}"
                        alt="{{ $imageAlt }}"
                        class="relative z-[1] h-auto w-full max-w-[420px] object-contain"
                        width="420"
                        height="315"
                        loading="lazy"
                    />
                </div>
            </div>
        </div>
    </div>
</section>
