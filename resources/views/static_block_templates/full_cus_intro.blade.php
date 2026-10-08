<section class="relative w-full overflow-hidden bg-themeBg-a full_cus bg-center bg-no-repeat bg-cover sec-bg-white" style="background-image: url('{{ $fullCus['bg_image_url'] ?? '' }}')">
    <div class="relative mx-auto w-full max-w-[1200px] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
    <div class="sec-pad py-16">
        <div class="flex flex-col items-center text-center">
            <div class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">{{ $fullCus['title'] ?? '' }}</div>
            <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        </div>

        <p class="full-cus-subtitle mt-4 w-full leading-6 text-slate-600 text-f16 font-poppins-regular text-themeText-g" style="display:block;width:100%;max-width:100%;margin-left:0;margin-right:0;text-align:left !important;">
            {!! nl2br(e($fullCus['description_1'] ?? '')) !!}
        </p>
        <p class="full-cus-subtitle mt-4 w-full text-f14 leading-6 text-themeText-a md1:text-f16" style="display:block;width:100%;max-width:100%;margin-left:0;margin-right:0;text-align:left !important;">
            {!! nl2br(e($fullCus['description_2'] ?? '')) !!}
        </p>
    </div>
    </div>
</section>
