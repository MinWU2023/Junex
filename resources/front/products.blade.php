<x-layout>
@section('tdk')
<title>Company Name | Industrial Supplier & Manufacturer</title>
<meta name="description" content="Company Name is a B2B manufacturer and exporter providing reliable industrial products for global buyers." />
<meta name="keywords" content="manufacturer, supplier, exporter, OEM, ODM, factory" />
@endsection

@section('page-css-header')
<link type="text/css" rel="stylesheet" href="/front/css/pages/home.css" />
@endsection

@section('page-js-header')

@endsection 


@section('content')
<section class="w-full breadcrumb bg-themeBg-a md4:bg-themeBg-g">
    <div >
    <div class="mx-auto w-full max-w-[1200px] px-4 py-4 sm2:px-5 md1:px-6 lg1:px-0">
        <nav aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center gap-x-3 gap-y-1">
            <li class="inline-flex items-center">
            <a href="#" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                <img src="/front/imgs/breadcrumbs-home.png" alt="Home" class="w-[14px] h-[14px]" />
                <span class="font-poppins-regular  text-f14 text-themeText-p">Home</span>
            </a>
            </li>

            <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
            <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18l6-6-6-6" />
            </svg>
            </li>

            <li class="inline-flex items-center">
            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Products</span>
            </li>
        </ol>
        </nav>
    </div>
    </div>
</section>

<section class="relative w-full bg-white prodcuts">
    <div class="mx-auto w-[calc(100%-30px)] max-w-[1200px] py-10 md1:py-12 md4:py-16">
    <div class="mx-auto max-w-[1200px] text-center">
        <div class="text-f32 font-poppins-medium uppercase tracking-wide text-themeText-f">
        JUNEX SPORTSWEAR | PROVIDE EXCELLENT PRODUCTS AND SERVICE,
        <br class="hidden sm6:block" />
        EMPOWERING ACTIVEWEAR BRAND TO GROW
        </div>
        <div class="mt-3 flex justify-center">
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        </div>
        <p class="mx-auto mt-4 max-w-[1000px] text-f16 leading-6 text-themeText-g sm6:leading-7">
        JUNEXSPORT, As A Mature Sportswear / Yoga Wear/Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focus On Offering Eco-friendly & Recycled & Sustainable Fabric Activewear. The Products Include Sports Bras, Leggings, Shorts, Tennis Wear, Kids' Sportswear, Yoga Suits, Sustainable & Recycled Wear, T-Shirts & Crop Tops, And Men's Gym Wear.
        </p>
    </div>

    <div class="mt-8 flex flex-wrap justify-center -mx-2 gap-y-6 md2:mt-10">
        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Yoga Set" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">YOGA SET</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Leggings" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">LEGGINGS</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Sports Bra" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">SPORTS BRA</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Shorts" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">SHORTS</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Jumpsuit" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">JUMPSUIT</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Yoga Set" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">YOGA SET</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Leggings" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">LEGGINGS</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Sports Bra" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">SPORTS BRA</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Shorts" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">SHORTS</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Jumpsuit" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">JUMPSUIT</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Yoga Set" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">YOGA SET</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Leggings" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">LEGGINGS</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Sports Bra" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">SPORTS BRA</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Shorts" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">SHORTS</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Jumpsuit" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">JUMPSUIT</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Yoga Set" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">YOGA SET</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Leggings" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">LEGGINGS</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Sports Bra" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">SPORTS BRA</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Shorts" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">SHORTS</div>
        </div>
        </a>

        <a href="/productcategory.html" class="group w-full sm5:w-1/2 sm6:w-1/3 md2:w-1/4 md4:w-1/5 px-2">
        <div class="w-full overflow-hidden bg-slate-100">
            <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-110" src="/front/imgs/products-demo.png" alt="Jumpsuit" loading="lazy" />
        </div>
        <div class="border border-slate-200 bg-white py-3 text-center transition-colors duration-300 group-hover:bg-themeBg-d">
            <div class="text-f16 font-poppins-medium uppercase tracking-wide text-themeText-f transition-colors duration-300 group-hover:text-white">JUMPSUIT</div>
        </div>
        </a>
    </div>
    </div>
</section>

<section class="w-full bg-cover bg-center bg-no-repeat custom_serrvices" style="background-image: url('/front/imgs/index_jcs_bg.png')">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="pt-0">
        <div class="text-center">
        <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
            Junex Custom Service
        </h2>
        <div class="mx-auto mt-3 h-1.5 w-12 rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 w-[100% - 30px] max-w-[825px] text-f16 leading-6 font-poppins-regular  text-themeColor-g">
            Junzhuosport, As A Mature Sportswear/ Yoga Wear/ Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focuses On Offering Eco-Friendly & Recycled & Sustainable Fabric
        </p>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-5 md4:grid-cols-2 mb-4">
        <div class="px-[18px] bg-themeBg-g py-[24px] bg-top bg-no-repeat" style="background-image: url('/front/imgs/index_jcs_l_bg.png')">
            <div class="text-center">
            <h3 class="font-poppins-semibold  tracking-wide text-slate-900 text-f22">
                <span class="text-themeBg-d">ODM</span> - Print Your Own Brand
            </h3>
            <p class="mt-1 text-f16 font-poppins-regular">In-Stock Products</p>
            </div>

            <!-- Mobile Swiper -->
            <div class="mt-5 block md1:hidden">
            <div class="swiper odm-swiper">
                <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="#" class="group relative h-[265px] block overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70">
                    <img class="h-[265px] w-full object-cover" src="/front/imgs/jcss01.png" alt="Custom Logo" loading="lazy" />
                    <div class="absolute inset-x-0 bottom-0 p-3">
                        <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium">
                        <span class="cs-line-clamp-2 leading-[20px]">Custom Logo</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="group relative h-[265px] block overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70">
                    <img class="h-[265px] w-full object-cover" src="/front/imgs/jcss02.png" alt="Custom Heat Transfer Wash Label" loading="lazy" />
                    <div class="absolute inset-x-0 bottom-0 p-3">
                        <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium">
                        <span class="cs-line-clamp-2 leading-[20px]">Custom Heat Transfer Wash Label</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="group relative h-[265px] block overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70">
                    <img class="h-[265px] w-full object-cover" src="/front/imgs/jcss03.png" alt="Custom Stickers" loading="lazy" />
                    <div class="absolute inset-x-0 bottom-0 p-3">
                        <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium">
                        <span class="cs-line-clamp-2 leading-[20px]">Custom Stickers</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="group relative h-[265px] block overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70">
                    <img class="h-[265px] w-full object-cover" src="/front/imgs/jcss04.png" alt="Custom Hang Tags" loading="lazy" />
                    <div class="absolute inset-x-0 bottom-0 p-3">
                        <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium">
                        <span class="cs-line-clamp-2 leading-[20px]">Custom Hang Tags</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="group relative h-[265px] block overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70">
                    <img class="h-[265px] w-full object-cover" src="/front/imgs/jcss05.png" alt="Custom-Made Sewn Wash Label" loading="lazy" />
                    <div class="absolute inset-x-0 bottom-0 p-3">
                        <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium">
                        <span class="cs-line-clamp-2 leading-[20px]">Custom-Made Sewn Wash Label</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="group relative h-[265px] block overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70">
                    <img class="h-[265px] w-full object-cover" src="/front/imgs/jcss06.png" alt="Customized Packaging Bags" loading="lazy" />
                    <div class="absolute inset-x-0 bottom-0 p-3">
                        <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium">
                        <span class="cs-line-clamp-2 leading-[20px]">Customized Packaging Bags</span>
                        </div>
                    </div>
                    </a>
                </div>
                </div>
                <div class="swiper-pagination odm-pagination mt-3"></div>
            </div>
            </div>

            <!-- Desktop Grid -->
            <div class="mt-5 hidden md1:grid grid-cols-2 gap-4 md1:gap-5">
            <a href="#" class="group relative h-[265px] overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2">
                <img class="h-[265px] w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="/front/imgs/jcss01.png" alt="Custom Logo" loading="lazy" />
                <div class="absolute inset-x-0 bottom-0 p-3">
                <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium transition duration-300 group-hover:-translate-y-1 group-hover:bg-black/60">
                    <span class="cs-line-clamp-2 leading-[20px]">Custom Logo</span>
                </div>
                </div>
            </a>
            <a href="#" class="group relative h-[265px] overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2">
                <img class="h-[265px] w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="/front/imgs/jcss02.png" alt="Custom Heat Transfer Wash Label" loading="lazy" />
                <div class="absolute inset-x-0 bottom-0 p-3">
                <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium transition duration-300 group-hover:-translate-y-1 group-hover:bg-black/60">
                    <span class="cs-line-clamp-2 leading-[20px]">Custom Heat Transfer Wash Label</span>
                </div>
                </div>
            </a>
            <a href="#" class="group relative h-[265px] overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2">
                <img class="h-[265px] w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="/front/imgs/jcss03.png" alt="Custom Stickers" loading="lazy" />
                <div class="absolute inset-x-0 bottom-0 p-3">
                <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium transition duration-300 group-hover:-translate-y-1 group-hover:bg-black/60">
                    <span class="cs-line-clamp-2 leading-[20px]">Custom Stickers</span>
                </div>
                </div>
            </a>
            <a href="#" class="group relative h-[265px] overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2">
                <img class="h-[265px] w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="/front/imgs/jcss04.png" alt="Custom Hang Tags" loading="lazy" />
                <div class="absolute inset-x-0 bottom-0 p-3">
                <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium transition duration-300 group-hover:-translate-y-1 group-hover:bg-black/60">
                    <span class="cs-line-clamp-2 leading-[20px]">Custom Hang Tags</span>
                </div>
                </div>
            </a>
            <a href="#" class="group relative h-[265px] overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2">
                <img class="h-[265px] w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="/front/imgs/jcss05.png" alt="Custom-Made Sewn Wash Label" loading="lazy" />
                <div class="absolute inset-x-0 bottom-0 p-3">
                <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium transition duration-300 group-hover:-translate-y-1 group-hover:bg-black/60">
                    <span class="cs-line-clamp-2 leading-[20px]">Custom-Made Sewn Wash Label</span>
                </div>
                </div>
            </a>
            <a href="#" class="group relative h-[265px] overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2">
                <img class="h-[265px] w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="/front/imgs/jcss06.png" alt="Customized Packaging Bags" loading="lazy" />
                <div class="absolute inset-x-0 bottom-0 p-3">
                <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium transition duration-300 group-hover:-translate-y-1 group-hover:bg-black/60">
                    <span class="cs-line-clamp-2 leading-[20px]">Customized Packaging Bags</span>
                </div>
                </div>
            </a>
            </div>
        </div>

        <div class="px-[18px] bg-themeBg-g py-[24px] bg-top bg-no-repeat" style="background-image: url('/front/imgs/index_jcs_r_bg.png')">
            <div class="text-center">
            <h3 class="font-poppins-semibold  tracking-wide text-slate-900 text-f22">
                <span class="text-themeBg-d">OEM</span> - Fully Designed By You
            </h3>
            <p class="mt-1 text-f16 font-poppins-regular">Custom Make Products</p>
            </div>

            <!-- Mobile Swiper -->
            <div class="mt-5 block md1:hidden">
            <div class="swiper oem-swiper">
                <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="#" class="group relative h-[265px] block overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70">
                    <img class="w-full object-cover" src="/front/imgs/jcsl01.png" alt="Custom By Design/Sample" loading="lazy" />
                    <div class="absolute inset-x-0 bottom-0 p-3">
                        <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium">
                        <span class="cs-line-clamp-2">Custom By Design/Sample</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="group relative h-[265px] block overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70">
                    <img class="w-full object-cover" src="/front/imgs/jcsl02.png" alt="Customized Craftsmanship" loading="lazy" />
                    <div class="absolute inset-x-0 bottom-0 p-3">
                        <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium">
                        <span class="cs-line-clamp-2">Customized Craftsmanship</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="group relative h-[265px] block overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70">
                    <img class="w-full object-cover" src="/front/imgs/jcsl03.png" alt="Fabric Customization" loading="lazy" />
                    <div class="absolute inset-x-0 bottom-0 p-3">
                        <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium">
                        <span class="cs-line-clamp-2">Fabric Customization</span>
                        </div>
                    </div>
                    </a>
                </div>
                </div>
                <div class="swiper-pagination oem-pagination mt-3"></div>
            </div>
            </div>

            <!-- Desktop List -->
            <div class="mt-5 hidden md1:block">
            <a href="#" class="group relative h-[265px] overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2 mb-5 block">
                <img class="w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="/front/imgs/jcsl01.png" alt="Custom By Design/Sample" loading="lazy" />
                <div class="absolute inset-x-0 bottom-0 p-3">
                <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium transition duration-300 group-hover:-translate-y-1 group-hover:bg-black/60">
                    <span class="cs-line-clamp-2">Custom By Design/Sample</span>
                </div>
                </div>
            </a>
            <a href="#" class="group relative h-[265px] overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2 mb-5 block">
                <img class="w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="/front/imgs/jcsl02.png" alt="Customized Craftsmanship" loading="lazy" />
                <div class="absolute inset-x-0 bottom-0 p-3">
                <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium transition duration-300 group-hover:-translate-y-1 group-hover:bg-black/60">
                    <span class="cs-line-clamp-2">Customized Craftsmanship</span>
                </div>
                </div>
            </a>
            <a href="#" class="group relative h-[265px] overflow-hidden rounded bg-white shadow-sm ring-1 ring-slate-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-slate-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2 mb-5 block">
                <img class="w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110" src="/front/imgs/jcsl03.png" alt="Fabric Customization" loading="lazy" />
                <div class="absolute inset-x-0 bottom-0 p-3">
                <div class="flex h-[50px] w-full items-center justify-center bg-black/50 px-3 text-center text-white backdrop-blur-sm text-f16 font-poppins-medium transition duration-300 group-hover:-translate-y-1 group-hover:bg-black/60">
                    <span class="cs-line-clamp-2">Fabric Customization</span>
                </div>
                </div>
            </a>
            </div>
        </div>
        </div>
    </div>
    </div>
</section>

<section class="w-full bg-white why_choose">
    <div class="mx-auto w-full px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="pt-6 md1:pt-10 md4:pt-14">
        <div class="text-center">
        <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
            Why Choose Junexsport
        </h2>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 max-w-[825px] leading-6 text-slate-600 text-f16 font-poppins-regular text-themeText-g">
            Junzhuosport, As A Mature Sportswear/ Yoga Wear/ Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focuses On Offering Eco-Friendly & Recycled & Sustainable Fabric
        </p>
        </div>
        <!-- Mobile: stacked layout -->
        <div class="mt-10 flex flex-col gap-4 md4:hidden">
        <div class="relative overflow-hidden border border-gray-300">
            <img class="absolute inset-0 h-full w-full object-cover grayscale" src="/front/imgs/index_wc_l02.png" alt="Annual output" loading="lazy" />
            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.2) 100%);"></div>
            <div class="relative flex min-h-[200px] flex-col justify-center p-6">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">Annual Output</div>
            <div class="mt-3 text-[26px] font-poppins-extrabold leading-none text-white">45 <span class="ml-2 text-[22px] font-poppins-extrabold text-white">Millions Items</span></div>
            <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">High Production Volume, Ensuring Both Quantity And Quality.</div>
            </div>
        </div>
        <div class="relative overflow-hidden border border-gray-300">
            <img class="absolute inset-0 h-full w-full object-cover grayscale" src="/front/imgs/index_wc_h02.png" alt="Spot reserves" loading="lazy" />
            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.2) 100%);"></div>
            <div class="relative flex min-h-[200px] flex-col justify-center p-6">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">Spot Reserves</div>
            <div class="mt-3 text-[26px] font-poppins-extrabold leading-none text-white">800 <span class="ml-2 text-[22px] font-poppins-extrabold text-white">Millions Items</span></div>
            <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">Rapid Response Supply, Protecting Your Business Every Step of the Way.</div>
            </div>
        </div>
        <div class="flex items-center justify-center bg-themeBg-d py-10 text-center text-white">
            <div>
            <img class="mx-auto h-14 w-14 object-contain" src="/front/imgs/index_wc_logo.png" alt="Junex" loading="lazy" />
            <div class="mt-3 text-[16px] font-poppins-semibold uppercase tracking-[3px]">Junexsport</div>
            <div class="mx-auto mt-3 h-[1px] w-[40px] bg-white/60"></div>
            <div class="mt-3 text-[11px] leading-5 text-white px-4 font-poppins-regular">Professional Sportswear Manufacturer</div>
            </div>
        </div>
        <div class="relative overflow-hidden border border-gray-300">
            <img class="absolute inset-0 h-full w-full object-cover grayscale" src="/front/imgs/index_wc_h01.png" alt="Customers" loading="lazy" />
            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.2) 100%);"></div>
            <div class="relative flex min-h-[200px] flex-col justify-center p-6">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">Number Of Customers</div>
            <div class="mt-3 text-[26px] font-poppins-extrabold leading-none text-white">100+ <div class="mt-1 text-[22px] font-poppins-extrabold text-stroke-white">Millions Of Customers</div></div>
            <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">Professionalism Earns Greater Trust.</div>
            </div>
        </div>
        <div class="relative overflow-hidden border border-gray-300">
            <img class="absolute inset-0 h-full w-full object-cover grayscale" src="/front/imgs/index_wc_l02.png" alt="Production line" loading="lazy" />
            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.2) 100%);"></div>
            <div class="relative flex min-h-[200px] flex-col justify-center p-6">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">Production Line</div>
            <div class="mt-3 text-[26px] font-poppins-extrabold leading-none text-white">50+ <span class="ml-2 text-[22px] font-poppins-extrabold text-white">Items</span></div>
            <div class="mt-3 max-w-[360px] text-f15 leading-5 text-white font-poppins-regular">A Powerful Production Capacity Of 150,000~200,000 Units Per Day.</div>
            </div>
        </div>
        </div>

        <!-- Desktop: kite layout -->
        <div class="relative mx-auto mt-10 hidden md4:block" style="aspect-ratio:1920/1040;">
        <!-- Left Top: 63.333% wide, 33.33% tall -->
        <div class="absolute left-0 top-0 overflow-hidden border-r border-b border-gray-300" style="width:63.333%;height:33.33%;">
            <div class="absolute inset-0 grayscale" style="background:url('/front/imgs/index_wc_l02.jpg') center/cover no-repeat;"></div>
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="absolute top-1/2 -translate-y-1/2 left-[80px] md2:left-[120px] md4:left-[180px] lg1:left-[240px] lg2:left-[300px]">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">Annual Output</div>
            <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">45 <span class="mt-1 text-f42 font-poppins-semibold text-stroke-white">Millions Items</span></div>
            <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">High Production Volume, Ensuring Both Quantity And Quality.</div>
            </div>
        </div>
        <!-- Left Bottom: 36.667% wide, 66.67% tall -->
        <div class="absolute left-0 overflow-hidden border-r border-gray-300" style="width:39%;top:33.33%;height:66.67%;">
            <div class="absolute inset-0 grayscale" style="background:url('/front/imgs/index_wc_h02.png') center/cover no-repeat;"></div>
            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(218,43,40,0.5) 0%, rgba(0,0,0,0.4) 100%);"></div>
            <div class="absolute top-1/2 -translate-y-1/2 left-[80px] md2:left-[120px] md4:left-[180px] lg1:left-[240px] lg2:left-[300px]">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">Spot Reserves</div>
            <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">800 <span class="mt-1 text-f42 font-poppins-semibold text-stroke-white">Millions Items</span></div>
            <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">Rapid Response Supply, Protecting Your Business Every Step of the Way.</div>
            </div>
        </div>
        <!-- Right Top: 36.667% wide, 66.67% tall -->
        <div class="absolute right-0 top-0 overflow-hidden border-l border-b border-gray-300" style="width:39%;height:66.67%;">
            <div class="absolute inset-0 grayscale" style="background:url('/front/imgs/index_wc_h01.png') center/cover no-repeat;"></div>
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="absolute top-1/2 -translate-y-1/2 left-[24px] md2:left-[36px] md4:left-[48px] lg1:left-[64px]">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">Number Of Customers</div>
            <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">100+ <div class="mt-1 text-f42 font-poppins-semibold text-stroke-white ">Millions Of Customers</div></div>
            <div class="mt-3 max-w-[340px] text-f15 leading-5 text-white font-poppins-regular">Professionalism Earns Greater Trust.</div>
            </div>
        </div>
        <!-- Right Bottom: 63.333% wide, 33.33% tall -->
        <div class="absolute right-0 overflow-hidden border-l border-gray-300" style="width:61%;top:66.67%;height:33.33%;">
            <div class="absolute inset-0 grayscale" style="background:url('/front/imgs/index_wc_l01.png') center/cover no-repeat;"></div>
            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(218,43,40,0.5) 0%, rgba(0,0,0,0.4) 100%);"></div>
            <div class="absolute top-1/2 -translate-y-1/2 left-[24px] md2:left-[36px] md4:left-[48px] lg1:left-[64px]">
            <div class="inline-flex h-9 items-center rounded-tl-[10px] rounded-br-[10px] bg-themeBg-d px-2 text-f12 font-poppins-medium uppercase tracking-wide text-white">Production Line</div>
            <div class="mt-3  font-poppins-semibold leading-none text-white md1:text-f42">50+ <span class="mt-1 text-f42 font-poppins-semibold text-stroke-white">Items</span></div>
            <div class="mt-3 max-w-[360px] text-f15 leading-5 text-white font-poppins-regular">A Powerful Production Capacity Of 150,000~200,000 Units Per Day.</div>
            </div>
        </div>
        <!-- Center Red Block -->
        <div class="absolute z-10 flex flex-col items-center justify-center bg-themeBg-d text-center text-white" style="left:39%;top:33.33%;width:22%;height:33.34%;">
            <img class="h-auto w-[200px] object-contain" src="/front/imgs/index_wc_logo.png" alt="Junex" loading="lazy" />
            <div class="mt-3 text-f12 leading-5 text-white px-4 font-poppins-regular">Creating Billions of High-Quality Garments to Make Exercise More Enjoyable.</div>
        </div>
        </div>
    </div>
    </div>
</section>

<section class="relative w-full bg-cover bg-center bg-no-repeat faqs" style="background-image: url('/front/imgs/products_faqs_bg.png')">
    <div class="mx-auto w-[calc(100%-30px)] max-w-[1200px] py-12 md1:py-14 md4:py-16">
    <div class="mx-auto max-w-[1200px] text-center">
        <div class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
        FREQUENTLY ASKED QUESTIONS
        </div>
        <div class="mt-3 flex justify-center">
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        </div>
        <p class="mx-auto mt-4 max-w-[860px] text-f16 leading-6 text-themeText-g  sm6:leading-7">
        Junzhuosport, As A Mature Sportswear/ Yoga Wear/ Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focuses On Offering Eco-Friendly & Recycled & Sustainable Fabric
        </p>
    </div>

    <div class="mt-10 flex flex-col gap-8 md2:gap-10 md4:flex-row md4:items-center">
        <div class="w-full md4:w-1/2">
        <div class="space-y-8">
            <div>
            <div class="text-f20 font-poppins-medium text-themeText-f">What Is Your Minimum Order Quantity?</div>
            <p class="mt-2 text-f16 leading-6 text-themeText-g font-poppins-regular">
                We Accept Trial Orders Starting From 100 Pieces Per Design/Color To Help You Test The Market.
            </p>
            </div>

            <div>
            <div class="text-f20 font-poppins-medium text-themeText-f">How Long Will My Order Take?</div>
            <p class="mt-2 text-f16 leading-6 text-themeText-g font-poppins-regular">
                For Samples, The Processing Time Is Approximately 7 Days. Larger Wholesale Orders Are Typically Completed Within 25 Days Or Less. We Ensure Efficient Service And Provide Real-Time Updates To Keep You Informed About Your Order Status Throughout Thecess.
            </p>
            </div>

            <div>
            <div class="text-f20 font-poppins-medium text-themeText-f">What Is Your Minimum Order Quantity?</div>
            <p class="mt-2 text-f16 leading-6 text-themeText-g font-poppins-regular">
                We Accept Trial Orders Starting From 100 Pieces Per Design/Color To Help You Test The Market.
            </p>
            </div>
        </div>
        </div>

        <div class="w-full md4:w-1/2">
        <div class="mx-auto w-full max-w-[520px] bg-white shadow-[0_10px_30px_rgba(0,0,0,0.12)] md4:max-w-none">
            <div class="relative overflow-hidden bg-slate-100">
            <img class="h-[220px] w-full object-cover sm6:h-[260px] md2:h-[300px] md4:h-[320px]" src="/front/imgs/index_cs_01.png" alt="FAQs" loading="lazy" />
            </div>
        </div>
        </div>
    </div>
    </div>
</section>

<section class="w-full bg-themeBg-f ask_us">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="py-6 md1:py-10 md4:py-14">
        <div class="mx-auto max-w-[1200px] bg-white">
        <img class="w-full object-cover" src="/front/imgs/index_form_top_bg.png" alt="" loading="lazy" aria-hidden="true" />
        <div class="border border-slate-200 px-4 py-8 sm6:px-8 md1:px-10">
            <div class="text-center">
            <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
                To Power Your Brand With Us
            </h2>
            <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
            <p class="mx-auto mt-4 max-w-[825px] leading-6  text-themeText-g text-f14">
                Junzhuosport, As A Mature Sportswear/ Yoga Wear/ Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focuses On Offering Eco-Friendly & Recycled & Sustainable Fabric
            </p>
            </div>

            <form class="mt-8" action="#" onsubmit="return false" method="post">
            <div class="grid grid-cols-1 gap-x-6 gap-y-5 md4:grid-cols-2">
                <label class="block">
                <span class="text-f14 font-poppins-regular text-slate-700">Name<span class="text-themeBg-d">*</span></span>
                <input type="text" name="name" placeholder="Please Enter Your Name" class="mt-2 h-[50px] w-full rounded border border-slate-200 bg-white px-3 text-f14 text-slate-900 outline-none ring-0 placeholder:text-slate-400 focus:border-themeBg-d" />
                </label>

                <label class="block">
                <span class="text-f14 font-poppins-regular text-slate-700">E-Mail<span class="text-themeBg-d">*</span></span>
                <input type="email" name="email" placeholder="Please Enter Your Email Address" class="mt-2 h-[50px] w-full rounded border border-slate-200 bg-white px-3 text-f14 text-slate-900 outline-none ring-0 placeholder:text-slate-400 focus:border-themeBg-d" />
                </label>

                <label class="block">
                <span class="text-f14 font-poppins-regular text-slate-700">Quantity</span>
                <select name="quantity" class="mt-2 h-[50px] w-full rounded border border-slate-200 bg-white px-3 text-f14 text-slate-600 outline-none ring-0 focus:border-themeBg-d">
                    <option value="" selected>Please Select Quantity</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                </select>
                </label>

                <label class="block">
                <span class="text-f14 font-poppins-regular text-slate-700">Tel / WhatsAPP<span class="text-themeBg-d">*</span></span>
                <input type="tel" name="tel" placeholder="Please Enter Your Telephone Number Or WhatsApp Number" class="mt-2 h-[50px] w-full rounded border border-slate-200 bg-white px-3 text-f14 text-slate-900 outline-none ring-0 placeholder:text-slate-400 focus:border-themeBg-d" />
                </label>
            </div>

            <label class="mt-5 block">
                <span class="text-f14 font-poppins-regular text-slate-700">Content<span class="text-themeBg-d">*</span></span>
                <textarea name="content" rows="8" placeholder="Please Enter The Content" class="mt-2 w-full resize-y rounded border border-slate-200 bg-white px-3 py-3 text-f14 text-slate-900 outline-none ring-0 placeholder:text-slate-400 focus:border-themeBg-d"></textarea>
            </label>

            <div class="mt-7 flex justify-center">
                <button type="submit" class="inline-flex h-[50px] items-center justify-center bg-slate-900 px-4 text-f15 font-poppins-medium uppercase tracking-wide text-white transition hover:bg-slate-800">
                Send Inquiry Now
                </button>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>
</section>
@endsection 

@section('page-css-footer')

@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
@endsection 
</x-layout>