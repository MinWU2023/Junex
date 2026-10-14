{{-- Contact CTA Banner: sample / quote inquiry --}}
@php
    $contactCtaUrl = $contactCtaUrl ?? '#ask-us';
    $contactCtaEmail = $contactCtaEmail ?? __('Info@Junzhuosport.com');
@endphp
<section class="contact-cta-banner relative w-full overflow-hidden bg-brand-red py-16 sec-pad sec-bg-color">
    <div class="pointer-events-none absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ front_webp_url('/front/imgs/indexquote/img01.png') }}')" aria-hidden="true"></div>

    <div class="relative mx-auto flex w-full max-w-[1200px] items-center px-4 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="flex w-full flex-col items-center gap-5 text-center md2:flex-row md2:items-center md2:justify-between md2:gap-6 md2:text-left">
            <div class="flex flex-col items-center gap-4 sm6:flex-row sm6:items-center sm6:gap-5 md2:gap-6">
                <img
                    class="h-12 w-12 shrink-0 object-contain brightness-0 invert md1:h-14 md1:w-14"
                    src="{{ front_webp_url('/front/imgs/indexquote/img02.png') }}"
                    alt=""
                    loading="lazy"
                    aria-hidden="true"
                />
                <div class="min-w-0">
                    <h3 class="font-poppins-semibold text-xl uppercase tracking-wide text-white md1:text-2xl lg1:text-3xl">
                        {{ __('Need A Sample Or An Official Quote?') }}
                    </h3>
                    <p class="mt-2 text-f14 font-poppins-regular text-white/95 md1:text-f16">
                        {{ __('Contact') }}
                        <a href="mailto:{{ $contactCtaEmail }}" class="font-poppins-semibold font-bold text-white underline-offset-2 hover:underline">{{ $contactCtaEmail }}</a>
                        {{ __('For More Details.') }}
                    </p>
                </div>
            </div>

            <a
                href="{{ $contactCtaUrl }}"
                class="inline-flex shrink-0 items-center justify-center rounded-none bg-black px-8 py-3 text-sm font-poppins-semibold uppercase tracking-wide text-white transition-colors duration-200 hover:bg-gray-900 md1:text-base"
            >
                {{ __('Contact Us') }}
            </a>
        </div>
    </div>
</section>
