{{-- /videos 列表页主副标题（后台静态块可编辑） --}}
<div class="mb-8 text-center md1:mb-10 videos-page-header">
    <h1 class="text-f28 font-poppins-semibold uppercase tracking-wide text-themeText-f md1:text-f32">{{ $title ?? 'Product Videos' }}</h1>
    <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
    @if(!empty($subtitle))
    <p class="mx-auto mt-4 max-w-[720px] text-f14 font-poppins-regular leading-relaxed text-themeText-g md1:text-f15">
        {{ $subtitle }}
    </p>
    @endif
</div>
