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
    <div>
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
                <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Privacy Policy</span>
                </li>
            </ol>
            </nav>
        </div>
    </div>
</section>

<!-- PLEASE SEND YOUR MESSAGE TO US -->
<section class="w-full bg-themeBg-a inquirylist">
    <div class="mx-auto w-full max-w-[1200px] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
    <div class="pt-12 md1:pt-14 md4:pt-16">

        <!-- Section Title -->
        <div class="flex flex-col items-center">
        <h2 class="text-f24 font-poppins-seminold text-themeText-f uppercase tracking-wide md1:text-f32 ">PLEASE SEND YOUR MESSAGE TO US</h2>
        <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        
        </div>

        <!-- Product Row List -->
        <div class="mt-8 flex flex-col md1:mt-12">

        <!-- Row 1 -->
        <div class="flex items-center gap-3 bg-themeBg-g border border-black/5 px-3 py-3 sm6:gap-4 sm6:px-4 sm6:py-4 md4:gap-5 md4:px-5">
            <div class="flex-shrink-0 h-[70px] w-[70px] overflow-hidden border border-black/5 sm6:h-[90px] sm6:w-[90px] md4:h-[100px] md4:w-[100px]">
            <img class="h-full w-full object-cover" src="/front/imgs/inquiry-demo.png" alt="Product" loading="lazy" />
            </div>
            <div class="flex-1 min-w-0 flex flex-col gap-[6px] sm6:gap-[10px]">
            <a href="#" class="line-clamp-1 text-f16 font-poppins-semibold text-themeText-f leading-[1.4] transition hover:text-themeBg-d sm6:text-f18">OEM Contrast Color Women Sports Bra Custom Gym Wear</a>
            <p class="text-f14 font-poppins-regular text-themeText-p leading-[1.4]  md1:text-f16"><span class="font-poppins-medium text-themeText-g">Model:</span> JZSB-001</p>
            <p class="text-f14 font-poppins-regular text-themeText-p leading-[1.4]  md1:text-f16"><span class="font-poppins-medium text-themeText-g">MOQ:</span> 200 Pieces</p>
            <!--<div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">Fashion bra</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">Soft fabric</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">High Stretch</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">OEM/ODM</span>
            </div>-->
            </div>
            <button type="button" class="flex-shrink-0 flex h-7 w-7 items-center justify-center rounded-full text-themeText-i transition hover:bg-black/5 hover:text-themeBg-d sm6:h-8 sm6:w-8" aria-label="Remove">
            <svg viewBox="0 0 24 24" class="h-4 w-4 sm6:h-[18px] sm6:w-[18px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Row 2 -->
        <div class="flex items-center gap-3 bg-themeBg-g border border-black/5 px-3 py-3 sm6:gap-4 sm6:px-4 sm6:py-4 md4:gap-5 md4:px-5">
            <div class="flex-shrink-0 h-[70px] w-[70px] overflow-hidden border border-black/5 sm6:h-[90px] sm6:w-[90px] md4:h-[100px] md4:w-[100px]">
            <img class="h-full w-full object-cover" src="/front/imgs/inquiry-demo.png" alt="Product" loading="lazy" />
            </div>
            <div class="flex-1 min-w-0 flex flex-col gap-[6px] sm6:gap-[10px]">
            <a href="#" class="line-clamp-1 text-f16 font-poppins-semibold text-themeText-f leading-[1.4] transition hover:text-themeBg-d sm6:text-f18">Custom Color-Block Sports Bra Gym Yoga Fitness Wear</a>
            <p class="text-f14 font-poppins-regular text-themeText-p leading-[1.4]  md1:text-f16"><span class="font-poppins-medium text-themeText-g">Model:</span> JZSB-002</p>
            <p class="text-f14 font-poppins-regular text-themeText-p leading-[1.4]  md1:text-f16"><span class="font-poppins-medium text-themeText-g">MOQ:</span> 200 Pieces</p>
            <!--<div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">Fashion bra</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">Soft fabric</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">High Stretch</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">OEM/ODM</span>
            </div>-->
            </div>
            <button type="button" class="flex-shrink-0 flex h-7 w-7 items-center justify-center rounded-full text-themeText-i transition hover:bg-black/5 hover:text-themeBg-d sm6:h-8 sm6:w-8" aria-label="Remove">
            <svg viewBox="0 0 24 24" class="h-4 w-4 sm6:h-[18px] sm6:w-[18px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Row 3 -->
        <div class="flex items-center gap-3 bg-themeBg-g border border-black/5 px-3 py-3 sm6:gap-4 sm6:px-4 sm6:py-4 md4:gap-5 md4:px-5">
            <div class="flex-shrink-0 h-[70px] w-[70px] overflow-hidden border border-black/5 sm6:h-[90px] sm6:w-[90px] md4:h-[100px] md4:w-[100px]">
            <img class="h-full w-full object-cover" src="/front/imgs/inquiry-demo.png" alt="Product" loading="lazy" />
            </div>
            <div class="flex-1 min-w-0 flex flex-col gap-[6px] sm6:gap-[10px]">
            <a href="#" class="line-clamp-1 text-f16 font-poppins-semibold text-themeText-f leading-[1.4] transition hover:text-themeBg-d sm6:text-f18">Women Adjustable Yoga Bra Lightweight Gym Wear</a>
            <p class="text-f14 font-poppins-regular text-themeText-p leading-[1.4]  md1:text-f16"><span class="font-poppins-medium text-themeText-g">Model:</span> JZSB-003</p>
            <p class="text-f14 font-poppins-regular text-themeText-p leading-[1.4]  md1:text-f16"><span class="font-poppins-medium text-themeText-g">MOQ:</span> 200 Pieces</p>
            <!--<div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">Fashion bra</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">Soft fabric</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">High Stretch</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">OEM/ODM</span>
            </div>-->
            </div>
            <button type="button" class="flex-shrink-0 flex h-7 w-7 items-center justify-center rounded-full text-themeText-i transition hover:bg-black/5 hover:text-themeBg-d sm6:h-8 sm6:w-8" aria-label="Remove">
            <svg viewBox="0 0 24 24" class="h-4 w-4 sm6:h-[18px] sm6:w-[18px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Row 4 -->
        <div class="flex items-center gap-3 bg-themeBg-g border border-black/5 px-3 py-3 sm6:gap-4 sm6:px-4 sm6:py-4 md4:gap-5 md4:px-5">
            <div class="flex-shrink-0 h-[70px] w-[70px] overflow-hidden border border-black/5 sm6:h-[90px] sm6:w-[90px] md4:h-[100px] md4:w-[100px]">
            <img class="h-full w-full object-cover" src="/front/imgs/inquiry-demo.png" alt="Product" loading="lazy" />
            </div>
            <div class="flex-1 min-w-0 flex flex-col gap-[6px] sm6:gap-[10px]">
            <a href="#" class="line-clamp-1 text-f16 font-poppins-semibold text-themeText-f leading-[1.4] transition hover:text-themeBg-d sm6:text-f18">OEM Contrast Color Women Sports Bra Custom Gym Wear</a>
            <p class="text-f14 font-poppins-regular text-themeText-p leading-[1.4]  md1:text-f16"><span class="font-poppins-medium text-themeText-g">Model:</span> JZSB-004</p>
            <p class="text-f14 font-poppins-regular text-themeText-p leading-[1.4]  md1:text-f16"><span class="font-poppins-medium text-themeText-g">MOQ:</span> 200 Pieces</p>
            <!--<div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">Fashion bra</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">Soft fabric</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">High Stretch</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">OEM/ODM</span>
            </div>-->
            </div>
            <button type="button" class="flex-shrink-0 flex h-7 w-7 items-center justify-center rounded-full text-themeText-i transition hover:bg-black/5 hover:text-themeBg-d sm6:h-8 sm6:w-8" aria-label="Remove">
            <svg viewBox="0 0 24 24" class="h-4 w-4 sm6:h-[18px] sm6:w-[18px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Row 5 -->
        <div class="flex items-center gap-3 bg-themeBg-g border border-black/5 px-3 py-3 sm6:gap-4 sm6:px-4 sm6:py-4 md4:gap-5 md4:px-5">
            <div class="flex-shrink-0 h-[70px] w-[70px] overflow-hidden border border-black/5 sm6:h-[90px] sm6:w-[90px] md4:h-[100px] md4:w-[100px]">
            <img class="h-full w-full object-cover" src="/front/imgs/inquiry-demo.png" alt="Product" loading="lazy" />
            </div>
            <div class="flex-1 min-w-0 flex flex-col gap-[6px] sm6:gap-[10px]">
            <a href="#" class="line-clamp-1 text-f16 font-poppins-semibold text-themeText-f leading-[1.4] transition hover:text-themeBg-d sm6:text-f18">OEM Contrast Color Women Sports Bra Custom Gym Wear</a>
            <p class="text-f14 font-poppins-regular text-themeText-p leading-[1.4]  md1:text-f16"><span class="font-poppins-medium text-themeText-g">Model:</span> JZSB-005</p>
            <p class="text-f14 font-poppins-regular text-themeText-p leading-[1.4]  md1:text-f16"><span class="font-poppins-medium text-themeText-g">MOQ:</span> 200 Pieces</p>
            <!--<div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">Fashion bra</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">Soft fabric</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">High Stretch</span>
                <span class="inline-flex items-center rounded-sm bg-themeBg-h px-2 py-0.5 text-f12 font-poppins-regular text-themeText-p">OEM/ODM</span>
            </div>-->
            </div>
            <button type="button" class="flex-shrink-0 flex h-7 w-7 items-center justify-center rounded-full text-themeText-i transition hover:bg-black/5 hover:text-themeBg-d sm6:h-8 sm6:w-8" aria-label="Remove">
            <svg viewBox="0 0 24 24" class="h-4 w-4 sm6:h-[18px] sm6:w-[18px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>
            </button>
        </div>

        </div>


    </div>
    </div>
</section>


<!-- Send Inquiry -->
<section class="send_inquiry w-full">
    <div class="mx-auto flex w-full max-w-[1200px] flex-col px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
    <div class="mt-2 mb-6 md1:mb-8  md4:mb-14">
        <!-- Form -->
        <form class="mt-8 flex flex-col gap-5 md1:mt-10">
        <!-- Row 1: Name + Email -->
        <div class="flex flex-col gap-5 sm6:flex-row sm6:gap-5">
            <div class="flex flex-1 flex-col gap-2">
            <label class="text-f14 font-poppins-regular text-themeText-g">Name <span class="text-themeBg-d">*</span></label>
            <input type="text" name="name" placeholder="Please enter your name" class="h-[42px] sm6:h-[46px] md1:h-[51px] w-full rounded border border-themeBg-h bg-white px-3 text-f14 font-poppins-regular text-themeText-a placeholder-themeText-i outline-none transition focus:border-themeBg-d" />
            </div>
            <div class="flex flex-1 flex-col gap-2">
            <label class="text-f14 font-poppins-regular text-themeText-g">E-Mail <span class="text-themeBg-d">*</span></label>
            <input type="email" name="email" placeholder="Please enter your email" class="h-[42px] sm6:h-[46px] md1:h-[51px] w-full rounded border border-themeBg-h bg-white px-3 text-f14 font-poppins-regular text-themeText-a placeholder-themeText-i outline-none transition focus:border-themeBg-d" />
            </div>
        </div>

        <!-- Row 2: Quantity + Tel -->
        <div class="flex flex-col gap-5 sm6:flex-row sm6:gap-5">
            <div class="flex flex-1 flex-col gap-2">
            <label class="text-f14 font-poppins-regular text-themeText-g">Quantity</label>
            <select name="quantity" class="h-[42px] sm6:h-[46px] md1:h-[51px] w-full appearance-none rounded border border-themeBg-h bg-white px-3 text-f14 font-poppins-regular text-themeText-a outline-none transition focus:border-themeBg-d">
                <option value="">Please select</option>
                <option value="1-100">1 - 100</option>
                <option value="101-500">101 - 500</option>
                <option value="501-1000">501 - 1000</option>
                <option value="1001-5000">1001 - 5000</option>
                <option value="5001+">5001+</option>
            </select>
            </div>
            <div class="flex flex-1 flex-col gap-2">
            <label class="text-f14 font-poppins-regular text-themeText-g">Tel/WhatsAPP <span class="text-themeBg-d">*</span></label>
            <input type="tel" name="tel" placeholder="Please enter your phone number" class="h-[42px] sm6:h-[46px] md1:h-[51px] w-full rounded border border-themeBg-h bg-white px-3 text-f14 font-poppins-regular text-themeText-a placeholder-themeText-i outline-none transition focus:border-themeBg-d" />
            </div>
        </div>

        <!-- Row 3: Content -->
        <div class="flex flex-col gap-2">
            <label class="text-f14 font-poppins-regular text-themeText-g">Content <span class="text-themeBg-d">*</span></label>
            <textarea name="content" rows="6" placeholder="Please enter the content" class="h-[120px] sm6:h-[140px] md1:h-[163px] w-full resize-none rounded border border-themeBg-h bg-white px-3 py-3 text-f14 font-poppins-regular text-themeText-a placeholder-themeText-i outline-none transition focus:border-themeBg-d"></textarea>
        </div>

        <!-- Submit -->
        <div class="flex justify-center">
            <button type="submit" class="h-[48px] sm6:h-[54px] md1:h-[60px] w-[200px] bg-themeText-f font-poppins-medium text-f18 uppercase tracking-wide text-white transition hover:opacity-90">SEND</button>
        </div>
        </form>

    </div>
    </div>
</section>
<!-- Send Inquiry End -->
@endsection 

@section('page-css-footer')

@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/pages/home.js" defer></script>
@endsection 
</x-layout>