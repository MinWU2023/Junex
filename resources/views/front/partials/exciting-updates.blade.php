@php
    $excitingUpdates = $excitingUpdates ?? [];
    $excitingSection = section_title('exciting_updates');
@endphp

{{-- ExcitingUpdatesSection --}}
<section class="w-full bg-white exciting_updates sec-bg-white">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="sec-pad py-16">
            @include('front.partials.section-header', [
                'section' => $excitingSection,
                'titleClass' => 'text-2xl font-extrabold uppercase tracking-wide text-brand-dark md:text-3xl',
                'subtitleClass' => 'mx-auto mt-4 max-w-[825px] text-f16 font-poppins-regular leading-6 text-themeText-g',
                'titleUrl' => route('blogs'),
            ])

            <div class="exciting-updates-layout mt-10">
                <div class="exciting-updates-stage min-w-0">
                    <div class="swiper exciting-updates-swiper">
                        <div class="swiper-wrapper">
                            @forelse($excitingUpdates as $item)
                            <div class="swiper-slide h-auto">
                                @include('front.partials.blog-card', ['item' => $item])
                            </div>
                            @empty
                            @for($i = 1; $i <= 6; $i++)
                            <div class="swiper-slide h-auto">
                                @include('front.partials.blog-card', [
                                    'url' => '#',
                                    'image' => '/front/imgs/index_rc_0' . (($i - 1) % 3 + 1) . '.png',
                                    'date' => 'December 25, 2025',
                                    'title' => 'Types of Vacuums: Everything You Need to Know to Choose the Best Cleaner',
                                ])
                            </div>
                            @endfor
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="exciting-updates-controls">
                    <button type="button" class="exciting-updates-prev junex-swiper-nav flex h-[42px] w-[42px] shrink-0 cursor-pointer items-center justify-center transition" aria-label="{{ __('Previous') }}">
                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M9 1L2 8l7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="exciting-updates-next junex-swiper-nav flex h-[42px] w-[42px] shrink-0 cursor-pointer items-center justify-center transition" aria-label="{{ __('Next') }}">
                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M1 1l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
