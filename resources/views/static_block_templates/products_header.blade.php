{{-- /products 列表页主副标题（后台静态块可编辑） --}}
<section class="relative w-full bg-white prodcuts sec-bg-white">
    <div class="sec-pad mx-auto w-[calc(100%-30px)] max-w-[1200px] py-16">
        <div class="mx-auto max-w-[1200px] text-center products-page-header">
            <div class="text-f32 font-poppins-medium uppercase tracking-wide text-themeText-f">
                {!! $title_html ?? ($title ?? '') !!}
            </div>
            <div class="mt-3 flex justify-center">
                <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
            </div>
            @if(!empty($subtitle))
            <p class="mx-auto mt-4 max-w-[1000px] text-f16 leading-6 text-themeText-g sm6:leading-7">
                {{ $subtitle }}
            </p>
            @endif
        </div>
    </div>
</section>
