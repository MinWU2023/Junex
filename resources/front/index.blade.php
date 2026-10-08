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

@section('page-header')
<section class="relative w-full pt-16 md4:pt-0 banners">
    <div class="absolute inset-0 bg-slate-900" aria-hidden="true"></div>
    <header class="pointer-events-none absolute inset-x-0 top-0 z-20 hidden md4:block header-nav">
    <div class="pointer-events-auto mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="flex h-16 items-center justify-between md1:h-20 mt-2.5">
            <a href="/" class="flex items-center gap-2">
                <img class="header-logo selectable h-[70px] w-[100px] object-contain" src="/front/imgs/logo2.svg" data-default-src="/front/imgs/logo2.svg" data-sticky-src="/front/imgs/logo.svg" alt="Junex" loading="lazy" />
            </a>
            <div class="flex items-center gap-[35px]">
            <nav class="hidden items-center gap-[26px] text-[16px] font-poppins-medium uppercase tracking-wide text-white md4:flex">
                <a class="relative transition duration-200 hover:text-white after:absolute after:left-1/2 after:-translate-x-1/2 after:-bottom-[14px] after:h-[5px] after:w-[34px] after:rounded-[5px] after:bg-themeBg-d after:opacity-0 after:transition-all after:duration-200 hover:after:opacity-100" href="/index.html">Home</a>

                <a class="relative transition duration-200 hover:text-white after:absolute after:left-1/2 after:-translate-x-1/2 after:-bottom-[14px] after:h-[5px] after:w-[34px] after:rounded-[5px] after:bg-themeBg-d after:opacity-0 after:transition-all after:duration-200 hover:after:opacity-100" href="/aboutus.html">About Us</a>

                <div class="relative group">
                <a class="relative inline-flex items-center gap-1 transition duration-200 hover:text-white after:absolute after:left-1/2 after:-translate-x-1/2 after:-bottom-[14px] after:h-[5px] after:w-[34px] after:rounded-[5px] after:bg-themeBg-d after:opacity-0 after:transition-all after:duration-200 group-hover:after:opacity-100" href="/products.html">
                    Product
                </a>

                <div class="pointer-events-none absolute left-1/2 -translate-x-1/2 top-full z-40 pt-[26px] mt-0 w-[240px] opacity-0 transition duration-150 group-hover:pointer-events-auto group-hover:opacity-100">
                    <div class="relative overflow-visible bg-white shadow-lg ring-1 ring-black/10">
                    <a href="/products.html" class="flex items-center justify-between px-4 py-3 text-f14  transition hover:bg-slate-50 font-poppins-regular">All Products</a>

                    <div class="h-px w-full bg-slate-200"></div>

                    <div class="relative submenu-parent">
                        <a href="#" class="flex items-center justify-between px-4 py-3 text-f14  transition hover:bg-slate-50 font-poppins-regular">
                        Sportswear
                        <svg viewBox="0 0 20 20" class="h-4 w-4 text-slate-500" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 5.23a.75.75 0 011.06 0l4.25 4.24a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 01-1.06-1.06L10.94 10 7.21 6.29a.75.75 0 010-1.06z" clip-rule="evenodd" />
                        </svg>
                        </a>

                        <div class="submenu-third pointer-events-none absolute left-full top-0 z-50 ml-0 w-[240px] opacity-0 transition duration-150">
                        <div class="overflow-hidden bg-white shadow-lg ring-1 ring-black/10">
                            <a href="#" class="block px-4 py-3 text-f14 font-poppins-regular transition hover:bg-slate-50">Yoga Wear</a>
                            <div class="h-px w-full bg-slate-200"></div>
                            <a href="#" class="block px-4 py-3 text-f14 font-poppins-regular transition hover:bg-slate-50">Gym Sets</a>
                            <div class="h-px w-full bg-slate-200"></div>
                            <a href="#" class="block px-4 py-3 text-f14 font-poppins-regular transition hover:bg-slate-50">Leggings</a>
                        </div>
                        </div>
                    </div>

                    <div class="h-px w-full bg-slate-200"></div>

                    <a href="#" class="flex items-center justify-between px-4 py-3 text-f14  transition hover:bg-slate-50 font-poppins-regular">Accessories</a>
                    </div>
                </div>
                </div>

                <div class="relative group">
                <a class="relative inline-flex items-center gap-1 transition duration-200 hover:text-white after:absolute after:left-1/2 after:-translate-x-1/2 after:-bottom-[14px] after:h-[5px] after:w-[34px] after:rounded-[5px] after:bg-themeBg-d after:opacity-0 after:transition-all after:duration-200 group-hover:after:opacity-100" href="/customerservices.html">
                    Custom Service
                </a>

                <div class="pointer-events-none absolute left-1/2 -translate-x-1/2 top-full z-40 pt-[26px] mt-0 w-[240px] opacity-0 transition duration-150 group-hover:pointer-events-auto group-hover:opacity-100">
                    <div class="relative overflow-visible bg-white shadow-lg ring-1 ring-black/10">
                    <a href="/customerservices.html" class="block px-4 py-3 text-f14 font-poppins-regular transition hover:bg-slate-50">OEM / ODM</a>
                    <div class="h-px w-full bg-slate-200"></div>
                    <a href="/customerservices.html" class="block px-4 py-3 text-f14 font-poppins-regular transition hover:bg-slate-50">Logo & Label</a>
                    <div class="h-px w-full bg-slate-200"></div>
                    <a href="/customerservices.html" class="block px-4 py-3 text-f14 font-poppins-regular transition hover:bg-slate-50">Packaging</a>
                    </div>
                </div>
                </div>

                <a class="relative transition duration-200 hover:text-white after:absolute after:left-1/2 after:-translate-x-1/2 after:-bottom-[14px] after:h-[5px] after:w-[34px] after:rounded-[5px] after:bg-themeBg-d after:opacity-0 after:transition-all after:duration-200 hover:after:opacity-100" href="/productcategory.html">Catalog</a>
                <a class="relative transition duration-200 hover:text-white after:absolute after:left-1/2 after:-translate-x-1/2 after:-bottom-[14px] after:h-[5px] after:w-[34px] after:rounded-[5px] after:bg-themeBg-d after:opacity-0 after:transition-all after:duration-200 hover:after:opacity-100" href="/contactus.html">Contact Us</a>
        </nav>
        
        <div class="flex items-center gap-[35px] text-white/90">
            <button type="button" class="hidden h-8 w-8 items-center justify-center md4:inline-flex search-trigger" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48" class="h-6 w-6" aria-hidden="true">
                <path stroke-linejoin="round" stroke-width="4" stroke="currentColor" d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4 4 11.611 4 21s7.611 17 17 17Z" data-follow-stroke="#000" />
                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="4" stroke="currentColor" d="M26.657 14.343A7.975 7.975 0 0 0 21 12c-2.209 0-4.209.895-5.657 2.343M33.222 33.222l8.485 8.485" data-follow-stroke="#000" />
            </svg>
            </button>
            <div class="language-switcher relative ml-auto hidden cursor-pointer select-none items-center gap-2 md4:flex">
            <img class="h-[26px] w-[26px] rounded-full object-cover" src="/front/imgs/us-flag.svg" alt="US" loading="lazy" />
            <span class="text-[15px] font-poppins-medium font-[500]">ENGLISH</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-white" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
            <div class="language-dropdown absolute left-1/2 top-full z-30 mt-3 w-[170px]">
                <div class="overflow-hidden bg-white shadow-lg ring-1 ring-black/10">
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-[15px] text-themeText-a transition hover:bg-slate-50">
                    <img class="h-[26px] w-[26px] rounded-full object-cover" src="/front/imgs/us-flag.svg" alt="US" loading="lazy" />
                    <span>ENGLISH</span>
                </a>
                <div class="h-px w-full bg-slate-200"></div>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-[15px] text-themeText-a transition hover:bg-slate-50">
                    <img class="h-[26px] w-[26px] rounded-full object-cover" src="/front/imgs/eu-flag.svg" alt="EU" loading="lazy" />
                    <span>ENGLISH</span>
                </a>
                <div class="h-px w-full bg-slate-200"></div>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-[15px] text-themeText-a transition hover:bg-slate-50">
                    <img class="h-[26px] w-[26px] rounded-full object-cover" src="/front/imgs/tx-flag.svg" alt="TX" loading="lazy" />
                    <span>ENGLISH</span>
                </a>
                </div>
            </div>
            </div>
            <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded bg-white/10 text-white md4:hidden" aria-label="Menu">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                <path d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h16v2H4v-2z" />
            </svg>
            </button>
        </div>
            </div>
        </div>
    </div>
    </header>
    <div class="swiper banners-swiper h-[520px] w-full md1:h-[620px] md4:h-[720px]">
    <div class="swiper-wrapper">
        <div class="swiper-slide relative">
        <img class="absolute inset-0 h-full w-full object-cover" src="/front/imgs/banner.png" alt="Banner" loading="lazy" />
        <div class="absolute inset-0 bg-black/30" aria-hidden="true"></div>
        <div class="relative z-10 flex h-full items-center">
            <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
            <div class="mx-auto max-w-[720px] text-center text-white">
                <h1 class="text-[18px] font-semibold leading-tight sm1:text-[20px] sm2:text-[22px] sm3:text-[24px] sm4:text-[26px] sm6:text-[28px] md1:text-[30px] md2:text-[32px] md3:text-[34px] md4:text-[36px] mb-6">
                Premium Clothing Manufacturer<br />at Competitive Prices
                </h1>
                <p class="mt-4 text-[11px] leading-6 text-white sm2:text-[12px] sm4:text-[13px] sm6:text-[14px] md2:text-[15px] md4:text-[16px] mb-8">
                As A Trusted Clothing Manufacturer, We Deliver Exceptional Quality And Craftsmanship In Every Garment. With Deep Industry Experience, We Offer Reliable.
                </p> 
                <a href="#" class="mt-7 flex w-fit items-center justify-center bg-slate-900 px-[24px] py-[22px] text-[12px] sm3:text-[13px] sm6:text-[14px] md2:text-[15px] md4:text-[16px] font-poppins-medium uppercase tracking-wide text-white transition hover:bg-slate-800 mx-auto">
                Get In Touch
                </a>
            </div>
            </div>
        </div>
        </div>
        <div class="swiper-slide relative">
        <img class="absolute inset-0 h-full w-full object-cover" src="/front/imgs/banner.png" alt="Banner" loading="lazy" />
        <div class="absolute inset-0 bg-black/30" aria-hidden="true"></div>
        <div class="relative z-10 flex h-full items-center">
            <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
            <div class="mx-auto max-w-[720px] text-center text-white">
                <h1 class="text-[18px] font-semibold leading-tight sm1:text-[20px] sm2:text-[22px] sm3:text-[24px] sm4:text-[26px] sm6:text-[28px] md1:text-[30px] md2:text-[32px] md3:text-[34px] md4:text-[36px] mb-6">
                Premium Clothing Manufacturer<br />at Competitive Prices
                </h1>
                <p class="mt-4 text-[11px] leading-6 text-white sm2:text-[12px] sm4:text-[13px] sm6:text-[14px] md2:text-[15px] md4:text-[16px] mb-8">
                As A Trusted Clothing Manufacturer, We Deliver Exceptional Quality And Craftsmanship In Every Garment. With Deep Industry Experience, We Offer Reliable.
                </p> 
                <a href="#" class="mt-7 flex w-fit items-center justify-center bg-slate-900 px-[24px] py-[22px] text-[12px] sm3:text-[13px] sm6:text-[14px] md2:text-[15px] md4:text-[16px] font-poppins-medium uppercase tracking-wide text-white transition hover:bg-slate-800 mx-auto">
                Get In Touch
                </a>
            </div>
            </div>
        </div>
        </div>
        <div class="swiper-slide relative">
        <img class="absolute inset-0 h-full w-full object-cover" src="/front/imgs/banner.png" alt="Banner" loading="lazy" />
        <div class="absolute inset-0 bg-black/30" aria-hidden="true"></div>
        <div class="relative z-10 flex h-full items-center">
            <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
            <div class="mx-auto max-w-[720px] text-center text-white">
                <h1 class="text-[20px] font-semibold leading-tight sm2:text-[22px] sm6:text-[24px] md1:text-[30px] md3:text-[34px] md4:text-[36px] mb-6">
                Premium Clothing Manufacturer<br />at Competitive Prices
                </h1>
                <p class="mt-4 text-[12px] leading-6 text-white sm6:text-[13px] md1:text-[14px] md3:text-[15px] md4:text-[16px] mb-8">
                As A Trusted Clothing Manufacturer, We Deliver Exceptional Quality And Craftsmanship In Every Garment. With Deep Industry Experience, We Offer Reliable.
                </p> 
                <a href="#" class="mt-7 flex w-fit items-center justify-center bg-slate-900 px-[24px] py-[22px] text-[14px] sm6:text-[15px] md4:text-[16px] font-poppins-medium uppercase tracking-wide text-white transition hover:bg-slate-800 mx-auto">
                Get In Touch
                </a>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="absolute bottom-8 left-1/2 z-20 w-[180px] -translate-x-1/2 md1:bottom-10 md1:w-[220px]">
        <div class="swiper-pagination banners-pagination"></div>
    </div>
    </div>
</section>
@endsection 

@section('content')
<section class="w-full bg-[#F7F7F7] lg1:px-0 px-4 partners">
    <div class="mx-auto w-full max-w-[1200px] px-0">
    <div class="py-[26px] md1:py-[40px]">
        <div class="flex flex-wrap items-center justify-around gap-x-[30px] gap-y-4">
        <div class="flex items-center justify-center">
            <img class="transition-transform duration-200 will-change-transform" src="/front/imgs/brands/01.png" alt="Brand logo 1" loading="lazy" />
        </div>
        <div class="flex items-center justify-center">
            <img class="transition-transform duration-200 will-change-transform" src="/front/imgs/brands/02.png" alt="Brand logo 2" loading="lazy" />
        </div>
        <div class="flex items-center justify-center">
            <img class="transition-transform duration-200 will-change-transform" src="/front/imgs/brands/03.png" alt="Brand logo 3" loading="lazy" />
        </div>
        <div class="flex items-center justify-center">
            <img class="transition-transform duration-200 will-change-transform" src="/front/imgs/brands/04.png" alt="Brand logo 4" loading="lazy" />
        </div>
        <div class="flex items-center justify-center">
            <img class="transition-transform duration-200 will-change-transform" src="/front/imgs/brands/05.png" alt="Brand logo 5" loading="lazy" />
        </div>
        <div class="flex items-center justify-center">
            <img class="transition-transform duration-200 will-change-transform" src="/front/imgs/brands/06.png" alt="Brand logo 6" loading="lazy" />
        </div>
        <div class="flex items-center justify-center">
            <img class="transition-transform duration-200 will-change-transform" src="/front/imgs/brands/07.png" alt="Brand logo 7" loading="lazy" />
        </div>
        <div class="flex items-center justify-center">
            <img class="transition-transform duration-200 will-change-transform" src="/front/imgs/brands/08.png" alt="Brand logo 8" loading="lazy" />
        </div>
        </div>
    </div>
    </div>
</section>
<section class="w-full bg-white about-us">
    <div class="about-us-bg mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="py-6 md1:py-7 md4:py-9">
        <div class="grid grid-cols-1 items-center gap-10 md4:grid-cols-2 md4:gap-12 lg1:gap-14 pb-10">
        <div class="relative">
            <div class="absolute -left-5 -bottom-5 h-16 w-16 bg-themeBg-d md1:-left-6 md1:-bottom-6 md1:h-40 md1:w-[100px]" aria-hidden="true"></div>
            <div class="relative overflow-hidden bg-slate-200 shadow-sm">
            <img class="block h-auto w-full object-cover" src="/front/imgs/video-play.png" alt="Brand solutions video" loading="lazy" />
            <button type="button" class="absolute left-1/2 top-1/2 flex h-14 w-14 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white/80 text-slate-900 shadow-md backdrop-blur transition hover:bg-white md1:h-16 md1:w-16" aria-label="Play video">
                <svg viewBox="0 0 24 24" class="h-6 w-6 md1:h-7 md1:w-7" fill="currentColor" aria-hidden="true">
                <path d="M8 5.5v13l11-6.5-11-6.5z" />
                </svg>
            </button>
            </div>
        </div>

        <div class="relative">
            <div class="pointer-events-none absolute inset-0 bg-[url('imgs/brands-bg.png')] bg-right bg-no-repeat bg-contain opacity-20" aria-hidden="true"></div>
            <div class="relative">
            <h2 class="text-[22px] font-extrabold uppercase tracking-wide  sm6:text-[24px] md1:text-[28px] md4:text-[32px] text-themeText-f">
                Junex Active Wear Brands Solutions
            </h2>
            <div class="mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
            <p class="mt-4 leading-6 poppins-regular :mt-5  font-themeColor-g text-f16">
                Ectionwear Champions Sustainable Development In Yoga Apparel. Committed To Eco-Friendly Practices, We Fuse Style.
            </p>

            <ul class="mt-5 space-y-3 md1:mt-6 md1:space-y-4">
                <li class="flex items-center gap-3">
                <span class="inline-flex h-5 w-5 flex-none items-center justify-center rounded-full">
                    <img src="/front/icons/icon001.png" alt="" class="h-4 w-4 object-contain" loading="lazy" />
                </span>
                <p class="text-f14 leading-6  font-themeText-g">
                    Environmentally Friendly Fabrics : Adopting The BLUESIGNcertified Fiber And Recycled Nylon Blend Technology, Dyeing With E.
                </p>
                </li>
                <li class="flex items-center gap-3">
                <span class="inline-flex h-5 w-5 flex-none items-center justify-center rounded-full">
                    <img src="/front/icons/icon001.png" alt="" class="h-4 w-4 object-contain" loading="lazy" />
                </span>
                <p class="text-f14 leading-6  font-themeText-g">
                    Environmentally Friendly Fabrics : 100% Biodegradable Soy And Packaging Truly Certified, Naturally Decomposing Within 60 Days.
                </p>
                </li>
                <li class="flex items-center gap-3">
                <span class="inline-flex h-5 w-5 flex-none items-center justify-center rounded-full">
                    <img src="/front/icons/icon001.png" alt="" class="h-4 w-4 object-contain" loading="lazy" />
                </span>
                <p class="text-f14 leading-6  font-themeText-g">
                    Reduce Fast Fashion : Adopting The BLUESIGN-Certified Fiber And Recycled Nylon Blend Technology, Dyeing With EU REAC.
                </p>
                </li>
            </ul>
            <a href="#" class="mt-7 inline-flex h-12 items-center justify-center bg-slate-900 px-7 text-[12px] font-semibold uppercase tracking-wide text-white transition hover:bg-slate-800 md1:mt-8" aria-label="Learn more">
                Learn More
            </a>
            </div>
        </div>
        </div>
    </div>
    </div>
</section>
<section class="w-full bg-[#F7F7F7] home_cates">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="py-6 md1:py-10 md4:py-14">
        <div class="text-center">
        <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
            Junex Product Category
        </h2>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 max-w-[825px] leading-6 text-slate-600 text-f16 font-poppins-regular text-themeText-g">
            Junzhuosport, As A Mature Sportswear/ Yoga Wear/ Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focuses On Offering Eco-Friendly & Recycled & Sustainable Fabric
        </p>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-5 md4:grid-cols-2 mb-4">
        <div class="space-y-6">
            <article class="home_cates_big relative h-[282px] overflow-hidden bg-[url('/front/imgs/jpclbg.png')] bg-center bg-no-repeat bg-cover shadow-sm">
            <div class="home_cates_big_grid grid h-full grid-cols-1 sm7:grid-cols-2 max-[600px]:grid max-[600px]:grid-cols-1 max-[600px]:grid-rows-1">
                <div class="pointer-events-none hidden bg-black/35 max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-10 max-[600px]:block max-[600px]:h-full max-[600px]:w-full" aria-hidden="true"></div>
                <div class="home_cates_big_img relative flex h-full items-center justify-center max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-0">
                <img class="h-full w-auto max-w-full object-contain" src="/front/imgs/jpcl001.png" alt="Recent new products" loading="lazy" />
                </div>
                <div class="home_cates_big_text relative pr-5 pl-2 py-5 flex items-center max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-20 max-[600px]:flex max-[600px]:flex-col max-[600px]:items-center max-[600px]:justify-center max-[600px]:text-center">
                <div class="pointer-events-none absolute inset-0 bg-[url('imgs/brands-bg.png')] bg-right bg-no-repeat bg-contain opacity-10" aria-hidden="true"></div>
                <div class="relative">
                    <h3 class="font-poppins-semibold text-f28 uppercase tracking-wide text-slate-900 max-[600px]:text-white">
                    <span class="text-themeBg-d">Recent</span> New<br />Products
                    </h3>
                    <p class="mt-3 font-poppins-regular text-[14px] leading-5 text-slate-600 max-[600px]:text-white/90">
                    Custom High Waist Yoga Leggings<br />Set Stretchy Breathable Active-
                    </p>
                    <a href="#" class="mt-5 inline-flex h-[40px] items-center justify-center bg-slate-900 px-3 font-poppins-regular text-f14 uppercase tracking-wide text-white transition hover:bg-slate-800 max-[600px]:mx-auto">
                    Learn More
                    </a>
                </div>
                </div>
            </div>
            </article>

            <article class="home_cates_big relative h-[282px] overflow-hidden bg-[url('/front/imgs/jpclbg.png')] bg-center bg-no-repeat bg-cover shadow-sm">
            <div class="home_cates_big_grid grid h-full grid-cols-1 sm7:grid-cols-2 max-[600px]:grid max-[600px]:grid-cols-1 max-[600px]:grid-rows-1">
                <div class="pointer-events-none hidden bg-black/35 max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-10 max-[600px]:block max-[600px]:h-full max-[600px]:w-full" aria-hidden="true"></div>
                <div class="home_cates_big_img order-2 relative flex h-full items-center justify-center sm7:order-2 max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-0">
                <img class="h-full w-auto max-w-full object-contain" src="/front/imgs/jpcl003.png" alt="Sewn series" loading="lazy" />
                </div>
                <div class="home_cates_big_text order-1 relative p-6 md1:p-7 flex items-center max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-20 max-[600px]:flex max-[600px]:flex-col max-[600px]:items-center max-[600px]:justify-center max-[600px]:text-center">
                <div class="pointer-events-none absolute inset-0 bg-[url('imgs/brands-bg.png')] bg-right bg-no-repeat bg-contain opacity-10" aria-hidden="true"></div>
                <div class="relative">
                    <h3 class="font-poppins-semibold text-f28 uppercase tracking-wide text-slate-900 max-[600px]:text-white">
                    <span class="text-themeBg-d">S</span>ewn Series
                    </h3>
                    <p class="mt-3 font-poppins-regular text-[14px] leading-5 text-slate-600 max-[600px]:text-white/90">
                    Custom High Waist Yoga Leggings<br />Set Stretchy Breathable Active-
                    </p>
                    <a href="#" class="mt-5 inline-flex h-[40px] items-center justify-center bg-slate-900 px-3 font-poppins-regular text-f14 uppercase tracking-wide text-white transition hover:bg-slate-800 max-[600px]:mx-auto">
                    Learn More
                    </a>
                </div>
                </div>
            </div>
            </article>

            <article class="home_cates_big relative h-[282px] overflow-hidden bg-[url('/front/imgs/jpclbg.png')] bg-center bg-no-repeat bg-cover shadow-sm">
            <div class="home_cates_big_grid grid h-full grid-cols-1 sm7:grid-cols-2 max-[600px]:grid max-[600px]:grid-cols-1 max-[600px]:grid-rows-1">
                <div class="pointer-events-none hidden bg-black/35 max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-10 max-[600px]:block max-[600px]:h-full max-[600px]:w-full" aria-hidden="true"></div>
                <div class="home_cates_big_img relative flex h-full items-center justify-center max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-0">
                <img class="h-full w-auto max-w-full object-contain" src="/front/imgs/jpcl002.png" alt="Bestseller recommendation" loading="lazy" />
                </div>
                <div class="home_cates_big_text relative pr-5 pl-2 py-5 flex items-center max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-20 max-[600px]:flex max-[600px]:flex-col max-[600px]:items-center max-[600px]:justify-center max-[600px]:text-center">
                <div class="pointer-events-none absolute inset-0 bg-[url('imgs/brands-bg.png')] bg-right bg-no-repeat bg-contain opacity-10" aria-hidden="true"></div>
                <div class="relative">
                    <h3 class="font-poppins-semibold text-f28 uppercase tracking-wide text-slate-900 max-[600px]:text-white">
                    <span class="text-themeBg-d">B</span>estseller<br />Recommendation
                    </h3>
                    <p class="mt-3 font-poppins-regular text-[14px] leading-5 text-slate-600 max-[600px]:text-white/90">
                    Custom High Waist Yoga Leggings<br />Set Stretchy Breathable Active-
                    </p>
                    <a href="#" class="mt-5 inline-flex h-[40px] items-center justify-center bg-slate-900 px-3 font-poppins-regular text-f14 uppercase tracking-wide text-white transition hover:bg-slate-800 max-[600px]:mx-auto">
                    Learn More
                    </a>
                </div>
                </div>
            </div>
            </article>
        </div>
        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-x-4 gap-y-6 sm6:grid-cols-3 md1:gap-x-5">
            <a href="#" class="group relative flex h-[180px] flex-col items-center justify-center gap-3 overflow-hidden bg-white px-4 py-6 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="pointer-events-none absolute inset-0 bg-[url('/front/imgs/jpcbg.png')] bg-center bg-no-repeat bg-cover opacity-100" aria-hidden="true"></div>
                <img class="relative" src="/front/imgs/jpc001.png" alt="Sports top" loading="lazy" />
                <span class="relative font-poppins-semibold text-f20 uppercase tracking-wide text-slate-900">Sports Top</span>
            </a>
            <a href="#" class="group relative flex h-[180px] flex-col items-center justify-center gap-3 overflow-hidden bg-white px-4 py-6 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="pointer-events-none absolute inset-0 bg-[url('/front/imgs/jpcbg.png')] bg-center bg-no-repeat bg-cover opacity-100" aria-hidden="true"></div>
                <img class="relative" src="/front/imgs/jpc002.png" alt="Sports bra" loading="lazy" />
                <span class="relative font-poppins-semibold text-f20 uppercase tracking-wide text-slate-900">Sports Bra</span>
            </a>
            <a href="#" class="group relative flex h-[180px] flex-col items-center justify-center gap-3 overflow-hidden bg-white px-4 py-6 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="pointer-events-none absolute inset-0 bg-[url('/front/imgs/jpcbg.png')] bg-center bg-no-repeat bg-cover opacity-100" aria-hidden="true"></div>
                <img class="relative" src="/front/imgs/jpc003.png" alt="Bodysuit" loading="lazy" />
                <span class="relative font-poppins-semibold text-f20 uppercase tracking-wide text-slate-900">Bodysuit</span>
            </a>
            <a href="#" class="group relative flex h-[180px] flex-col items-center justify-center gap-3 overflow-hidden bg-white px-4 py-6 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="pointer-events-none absolute inset-0 bg-[url('/front/imgs/jpcbg.png')] bg-center bg-no-repeat bg-cover opacity-100" aria-hidden="true"></div>
                <img class="relative" src="/front/imgs/jpc004.png" alt="Shorts" loading="lazy" />
                <span class="relative font-poppins-semibold text-f20 uppercase tracking-wide text-slate-900">Shorts</span>
            </a>
            <a href="#" class="group relative flex h-[180px] flex-col items-center justify-center gap-3 overflow-hidden bg-white px-4 py-6 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="pointer-events-none absolute inset-0 bg-[url('/front/imgs/jpcbg.png')] bg-center bg-no-repeat bg-cover opacity-100" aria-hidden="true"></div>
                <img class="relative" src="/front/imgs/jpc005.png" alt="Coat" loading="lazy" />
                <span class="relative font-poppins-semibold text-f20 uppercase tracking-wide text-slate-900">Coat</span>
            </a>
            <a href="#" class="group relative flex h-[180px] flex-col items-center justify-center gap-3 overflow-hidden bg-white px-4 py-6 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="pointer-events-none absolute inset-0 bg-[url('/front/imgs/jpcbg.png')] bg-center bg-no-repeat bg-cover opacity-100" aria-hidden="true"></div>
                <img class="relative" src="/front/imgs/jpc006.png" alt="Trousers" loading="lazy" />
                <span class="relative font-poppins-semibold text-f20 uppercase tracking-wide text-slate-900">Trousers</span>
            </a>
            <a href="#" class="group relative flex h-[180px] flex-col items-center justify-center gap-3 overflow-hidden bg-white px-4 py-6 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="pointer-events-none absolute inset-0 bg-[url('/front/imgs/jpcbg.png')] bg-center bg-no-repeat bg-cover opacity-100" aria-hidden="true"></div>
                <img class="relative" src="/front/imgs/jpc007.png" alt="Weat suit" loading="lazy" />
                <span class="relative font-poppins-semibold text-f20 uppercase tracking-wide text-slate-900">Weat Suit</span>
            </a>
            <a href="#" class="group relative flex h-[180px] flex-col items-center justify-center gap-3 overflow-hidden bg-white px-4 py-6 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="pointer-events-none absolute inset-0 bg-[url('/front/imgs/jpcbg.png')] bg-center bg-no-repeat bg-cover opacity-100" aria-hidden="true"></div>
                <img class="relative" src="/front/imgs/jpc008.png" alt="Customed" loading="lazy" />
                <span class="relative font-poppins-semibold text-f20 uppercase tracking-wide text-slate-900">Customed</span>
            </a>
            <a href="#" class="group relative flex h-[180px] flex-col items-center justify-center gap-3 overflow-hidden bg-white px-4 py-6 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="pointer-events-none absolute inset-0 bg-[url('/front/imgs/jpcbg.png')] bg-center bg-no-repeat bg-cover opacity-100" aria-hidden="true"></div>
                <img class="relative" src="/front/imgs/jpc009.png" alt="View more" loading="lazy" />
                <span class="relative font-poppins-semibold text-f20 uppercase tracking-wide text-slate-900">View More</span>
            </a>
            </div>

            <article class="home_cates_big relative h-[282px] overflow-hidden bg-[url('/front/imgs/jpclbg.png')] bg-center bg-no-repeat bg-cover shadow-sm">
            <div class="home_cates_big_grid grid h-full grid-cols-1 sm7:grid-cols-2 max-[600px]:grid max-[600px]:grid-cols-1 max-[600px]:grid-rows-1">
                <div class="pointer-events-none hidden bg-black/35 max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-10 max-[600px]:block max-[600px]:h-full max-[600px]:w-full" aria-hidden="true"></div>
                <div class="home_cates_big_text relative pr-5 pl-10 py-5 flex items-center max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-20 max-[600px]:flex max-[600px]:flex-col max-[600px]:items-center max-[600px]:justify-center max-[600px]:text-center">
                <div class="pointer-events-none absolute inset-0 bg-[url('imgs/brands-bg.png')] bg-right bg-no-repeat bg-contain opacity-10" aria-hidden="true"></div>
                <div class="relative">
                    <h3 class="font-poppins-semibold text-f28 uppercase tracking-wide text-slate-900 max-[600px]:text-white">
                    <span class="text-themeBg-d">S</span>eamless<br />Shorts Series
                    </h3>
                    <p class="mt-3 font-poppins-regular text-[14px] leading-5 text-slate-600 max-[600px]:text-white/90">
                    Custom High Waist Yoga Leggings<br />Set Stretchy Breathable Active-
                    </p>
                    <a href="#" class="mt-5 inline-flex h-[40px] items-center justify-center bg-slate-900 px-3 font-poppins-regular text-f14 uppercase tracking-wide text-white transition hover:bg-slate-800 max-[600px]:mx-auto">
                    Learn More
                    </a>
                </div>
                </div>
                <div class="home_cates_big_img relative flex h-full items-center justify-center max-[600px]:col-start-1 max-[600px]:row-start-1 max-[600px]:z-0">
                <img class="h-full w-auto max-w-full object-contain" src="/front/imgs/jpcl004.png" alt="Seamless shorts series" loading="lazy" />
                </div>
            </div>
            </article>
        </div>
        </div>
    </div>
    </div>
</section>
<section class="w-full bg-cover bg-center bg-no-repeat custom_serrvices" style="background-image: url('/front/imgs/index_jcs_bg.png')">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="pt-6 md1:pt-10 md4:pt-14">
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
<section class="w-full custom_process">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="pt-6 md1:pt-10 md4:pt-14">
        <div class="text-center">
        <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f ">
            Junex Order Process
        </h2>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 w-[100% - 30px] max-w-[825px] leading-6 text-f16 font-poppins-regular text-themeText-g">
            Junzhuosport, As A Mature Sportswear/ Yoga Wear/ Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focuses On Offering Eco-Friendly & Recycled & Sustainable Fabric
        </p>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-[15px] md4:grid-cols-[25.4%_50%_25.4%] md4:items-stretch">
        <div class="flex h-full flex-col gap-[15px]">
            <article class="flex flex-1 flex-col overflow-hidden shadow-sm bg-themeBg-g px-2 py-2">
            <div class="px-4 md1:py-[26px]">
                <div class="text-f20 font-poppins-medium">Step 02</div>
                <div class="mt-1 text-f22 font-poppins-semibold">Customized Design</div>
                <div class="mt-2 leading-5 font-poppins-regular text-f14">We Have Wide Selection Of Fabrics Available to Meet Different</div>
            </div>
            <div class="px-4 pb-10">
                <img class="object-contain" src="/front/imgs/jop01.png" alt="Step 02" loading="lazy" />
            </div>
            </article>

            <article class="flex flex-1 flex-col overflow-hidden shadow-sm bg-themeBg-g px-2 py-2">
            <div class="px-4 md1:py-[26px]">
                <div class="text-f20 font-poppins-medium">Step 03</div>
                <div class="mt-1 text-f22 font-poppins-semibold">Customized Fabric</div>
                <div class="mt-2 leading-5 font-poppins-regular text-f14">We Have Wide Selection Of Fabrics Available to Meet Different</div>
            </div>
            <div class="px-4 pb-10">
                <img class="object-contain" src="/front/imgs/jop02.png" alt="Step 03" loading="lazy" />
            </div>
            </article>
        </div>

        <div class="overflow-hidden bg-themeBg-g shadow-sm flex h-full flex-col justify-center">
            <div class="px-6 pt-6 text-center md1:px-7 md1:pt-7">
            <div class="font-poppins-semibold text-f32 text-slate-900">Step 01</div>
            </div>

            <div class="flex items-center justify-center px-4 pb-6 pt-4 md1:px-6 md1:pb-7">
            <img class="h-auto w-full max-w-[520px] object-cover" src="/front/imgs/jopcenter.png" alt="Product" loading="lazy" />
            </div>

            <div class="px-6 pb-6 text-center leading-5 md1:px-7 md1:pb-7 text-f16 font-poppins-regular">
            Heat Transfer,Embroidery,3M Reflective Silver,Digital Direct,Injection,Silicon Printing.
            </div>
        </div>

        <div class="flex h-full flex-col gap-[15px]">
            <article class="flex flex-1 flex-col overflow-hidden shadow-sm bg-themeBg-g px-2 py-2">
            <div class="px-4 md1:py-[26px]">
                <div class="text-f20 font-poppins-medium">Step 04</div>
                <div class="mt-1 text-f22 font-poppins-semibold">Customized Color</div>
                <div class="mt-2 leading-5 font-poppins-regular text-f14">We Have Wide Selection Of Fabrics Available to Meet Different</div>
            </div>
            <div class="px-4 pb-10">
                <img class="object-contain" src="/front/imgs/jop03.png" alt="Step 04" loading="lazy" />
            </div>
            </article>

            <article class="flex flex-1 flex-col overflow-hidden shadow-sm bg-themeBg-g px-2 py-2">
            <div class="px-4 md1:py-[26px]">
                <div class="text-f20 font-poppins-medium">Step 05</div>
                <div class="mt-1 text-f22 font-poppins-semibold">Custom Packaging</div>
                <div class="mt-2 leading-5 font-poppins-regular text-f14">We Have Wide Selection Of Fabrics Available to Meet Different</div>
            </div>
            <div class="px-4 pb-10">
                <img class="object-contain" src="/front/imgs/jop04.png" alt="Step 05" loading="lazy" />
            </div>
            </article>
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
<section class="w-full bg-white hot_styles">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="py-6 md1:py-10 md4:py-14">
        <div class="text-center">
        <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
            Junex Hot Styles
        </h2>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 max-w-[825px] leading-6 text-slate-600 text-f16 font-poppins-regular text-themeText-g">
            Junzhuosport, As A Mature Sportswear/ Yoga Wear/ Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focuses On Offering Eco-Friendly & Recycled & Sustainable Fabric
        </p>
        </div>

        <div class="relative mt-10">
        <div class="swiper hot-styles-swiper">
            <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="relative overflow-hidden bg-slate-100">
                <img class="w-full object-contain" src="/front/imgs/index_rc_01.png" alt="Hot style 1" loading="lazy" />
                <button type="button" class="collect-btn absolute top-[16px] right-[16px] z-10 flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white cursor-pointer" aria-label="Collect">
                    <img class="uncollect-icon h-[15px] w-[16px]" src="/front/icons/uncollect.png" alt="Uncollect" />
                    <img class="collect-icon hidden h-[15px] w-[16px]" src="/front/icons/collect.png" alt="Collect" />
                </button>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="relative overflow-hidden bg-slate-100">
                <img class="w-full object-contain" src="/front/imgs/index_rc_02.png" alt="Hot style 2" loading="lazy" />
                <button type="button" class="collect-btn absolute top-[16px] right-[16px] z-10 flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white cursor-pointer" aria-label="Collect">
                    <img class="uncollect-icon h-[15px] w-[16px]" src="/front/icons/uncollect.png" alt="Uncollect" />
                    <img class="collect-icon hidden h-[15px] w-[16px]" src="/front/icons/collect.png" alt="Collect" />
                </button>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="relative overflow-hidden bg-slate-100">
                <img class="w-full object-contain" src="/front/imgs/index_rc_03.png" alt="Hot style 3" loading="lazy" />
                <button type="button" class="collect-btn absolute top-[16px] right-[16px] z-10 flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white cursor-pointer" aria-label="Collect">
                    <img class="uncollect-icon h-[15px] w-[16px]" src="/front/icons/uncollect.png" alt="Uncollect" />
                    <img class="collect-icon hidden h-[15px] w-[16px]" src="/front/icons/collect.png" alt="Collect" />
                </button>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="relative overflow-hidden bg-slate-100">
                <img class="w-full object-contain" src="/front/imgs/index_rc_01.png" alt="Hot style 4" loading="lazy" />
                <button type="button" class="collect-btn absolute top-[16px] right-[16px] z-10 flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white cursor-pointer" aria-label="Collect">
                    <img class="uncollect-icon h-[15px] w-[16px]" src="/front/icons/uncollect.png" alt="Uncollect" />
                    <img class="collect-icon hidden h-[15px] w-[16px]" src="/front/icons/collect.png" alt="Collect" />
                </button>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="relative overflow-hidden bg-slate-100">
                <img class="w-full object-contain" src="/front/imgs/index_rc_02.png" alt="Hot style 5" loading="lazy" />
                <button type="button" class="collect-btn absolute top-[16px] right-[16px] z-10 flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white cursor-pointer" aria-label="Collect">
                    <img class="uncollect-icon h-[15px] w-[16px]" src="/front/icons/uncollect.png" alt="Uncollect" />
                    <img class="collect-icon hidden h-[15px] w-[16px]" src="/front/icons/collect.png" alt="Collect" />
                </button>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="relative overflow-hidden bg-slate-100">
                <img class="w-full object-contain" src="/front/imgs/index_rc_03.png" alt="Hot style 6" loading="lazy" />
                <button type="button" class="collect-btn absolute top-[16px] right-[16px] z-10 flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white cursor-pointer" aria-label="Collect">
                    <img class="uncollect-icon h-[15px] w-[16px]" src="/front/icons/uncollect.png" alt="Uncollect" />
                    <img class="collect-icon hidden h-[15px] w-[16px]" src="/front/icons/collect.png" alt="Collect" />
                </button>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="relative overflow-hidden bg-slate-100">
                <img class="w-full object-contain" src="/front/imgs/index_rc_01.png" alt="Hot style 7" loading="lazy" />
                <button type="button" class="collect-btn absolute top-[16px] right-[16px] z-10 flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white cursor-pointer" aria-label="Collect">
                    <img class="uncollect-icon h-[15px] w-[16px]" src="/front/icons/uncollect.png" alt="Uncollect" />
                    <img class="collect-icon hidden h-[15px] w-[16px]" src="/front/icons/collect.png" alt="Collect" />
                </button>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="relative overflow-hidden bg-slate-100">
                <img class="w-full object-contain" src="/front/imgs/index_rc_02.png" alt="Hot style 8" loading="lazy" />
                <button type="button" class="collect-btn absolute top-[16px] right-[16px] z-10 flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white cursor-pointer" aria-label="Collect">
                    <img class="uncollect-icon h-[15px] w-[16px]" src="/front/icons/uncollect.png" alt="Uncollect" />
                    <img class="collect-icon hidden h-[15px] w-[16px]" src="/front/icons/collect.png" alt="Collect" />
                </button>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="relative overflow-hidden bg-slate-100">
                <img class="w-full object-contain" src="/front/imgs/index_rc_03.png" alt="Hot style 9" loading="lazy" />
                <button type="button" class="collect-btn absolute top-[16px] right-[16px] z-10 flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white cursor-pointer" aria-label="Collect">
                    <img class="uncollect-icon h-[15px] w-[16px]" src="/front/icons/uncollect.png" alt="Uncollect" />
                    <img class="collect-icon hidden h-[15px] w-[16px]" src="/front/icons/collect.png" alt="Collect" />
                </button>
                </div>
            </div>
            </div>
            <button type="button" class="hot-styles-prev absolute left-[20px] top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center bg-black/50 text-white shadow transition hover:bg-black/70 disabled:bg-white/50 disabled:text-black/40 disabled:shadow-none" aria-label="Previous">
            <svg viewBox="0 0 20 20" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M12.78 15.53a.75.75 0 01-1.06 0l-5-5a.75.75 0 010-1.06l5-5a.75.75 0 111.06 1.06L8.31 10l4.47 4.47a.75.75 0 010 1.06z" clip-rule="evenodd" />
            </svg>
            </button>
            <button type="button" class="hot-styles-next absolute right-[20px] top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center bg-black/50 text-white shadow transition hover:bg-black/70 disabled:bg-white/50 disabled:text-black/40 disabled:shadow-none" aria-label="Next">
            <svg viewBox="0 0 20 20" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.22 4.47a.75.75 0 011.06 0l5 5a.75.75 0 010 1.06l-5 5a.75.75 0 11-1.06-1.06L11.69 10 7.22 5.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
            </svg>
            </button>
        </div>
        </div>
    </div>
    </div>
</section>
<section class="relative w-full overflow-hidden defined_services">
    <div class="absolute inset-0 bg-[url('/front/imgs/index_cs_bg.png')] bg-center bg-no-repeat bg-cover" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-black/55" aria-hidden="true"></div>
    <div class="relative mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="py-6 md1:py-10 md4:py-14">
        <div class="text-center">
        <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-white">
            Customize Services
        </h2>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        <p class="mx-auto mt-4 max-w-[760px] text-f16 leading-6 text-white">
            Junzhuosport, As A Mature Sportswear/ Yoga Wear/ Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focuses On Offering Eco-Friendly & Recycled & Sustainable Fabric
        </p>
        </div>

        <div class="mt-10 grid grid-cols-1 items-start gap-6 md4:grid-cols-2 md4:gap-7 lg1:gap-8">
        <div class="space-y-6 text-white">
            <div>
            <h3 class="text-f20 font-poppins-semibold">What Is Your Minimum Order Quantity?</h3>
            <p class="mt-2 text-f16 leading-5 text-white">
                We Accept Trial Orders Starting From 100 Pieces Per Design/Color To Help You Test The Market.
            </p>
            </div>

            <div>
            <h3 class="text-f20 font-poppins-semibold">How Long Will My Order Take?</h3>
            <p class="mt-2 text-f16 leading-5 text-white">
                For Samples, The Processing Time Is Approximately 7 Days. Larger Wholesale Orders Are Typically Completed Within 25 Days Or Less.
                We Ensure Efficient Service And Provide Real-Time Updates To Keep You Informed About Your Order Status Throughout Thecess.
            </p>
            </div>

            <div>
            <h3 class="text-f20 font-poppins-semibold">What Is Your Minimum Order Quantity?</h3>
            <p class="mt-2 text-f16 leading-5 text-white">
                We Accept Trial Orders Starting From 100 Pieces Per Design/Color To Help You Test The Market.
            </p>
            </div>
        </div>

        <div class="relative overflow-hidden">
            <img class="h-auto w-full object-contain" src="/front/imgs/index_cs_01.png" alt="Customize services products" loading="lazy" />
        </div>
        </div>
    </div>
    </div>
</section>
<section class="w-full bg-white ask_us">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="py-6 md1:py-10 md4:py-14">
        <div class="mx-auto max-w-[1200px] bg-themeBg-f">
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