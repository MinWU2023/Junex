@php
    $videoRecommends = $videoRecommends ?? [];
    $videoSection = section_title('video_recommends');
@endphp

@if(!empty($videoRecommends))
<section class="w-full bg-white videos_recommend sec-bg-white">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="sec-pad py-16">
            @include('front.partials.section-header', [
                'section' => $videoSection,
                'titleClass' => 'text-2xl font-extrabold uppercase tracking-wide text-brand-dark md:text-3xl',
                'subtitleClass' => 'mx-auto mt-4 max-w-[825px] text-f16 font-poppins-regular leading-6 text-themeText-g',
                'titleUrl' => route('videos'),
            ])

            <div class="relative mt-10">
                <div class="swiper video-recommends-swiper">
                    <div class="swiper-wrapper">
                        @foreach($videoRecommends as $item)
                        <div class="swiper-slide h-auto">
                            @include('front.partials.video-card', ['item' => $item])
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="pointer-events-none absolute left-0 top-0 z-10 aspect-[16/9] w-full md1:w-[calc((100%-16px)/2)] md4:w-[calc((100%-40px)/3)]">
                    <button type="button" class="video-recommends-prev junex-swiper-nav pointer-events-auto absolute bottom-[40px] left-[20px] z-10 flex h-[42px] w-[42px] cursor-pointer items-center justify-center transition" aria-label="{{ __('Previous') }}">
                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M9 1L2 8l7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
                <div class="pointer-events-none absolute right-0 top-0 z-10 aspect-[16/9] w-full md1:w-[calc((100%-16px)/2)] md4:w-[calc((100%-40px)/3)]">
                    <button type="button" class="video-recommends-next junex-swiper-nav pointer-events-auto absolute right-[20px] bottom-[40px] z-10 flex h-[42px] w-[42px] cursor-pointer items-center justify-center transition" aria-label="{{ __('Next') }}">
                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M1 1l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
