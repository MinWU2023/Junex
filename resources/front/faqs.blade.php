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
            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Faqs</span>
            </li>
        </ol>
        </nav>
    </div>
    </div>
</section>
<section class="faqs_item w-full pt-6 md1:pt-10 md4:pt-[64px] pb-4">
    <div class="mx-auto flex w-full max-w-[1200px] flex-col bg-themeBg-g p-10">
    <!-- Section Header -->
    <div class="mb-6 md1:mb-8">
        <h2 class="text-f24 font-poppins-semibold text-themeText-a">
        <span class="text-red-600">P</span>roducts
        </h2>
        <p class="mt-2 text-f14 font-poppins-regular text-themeText-d">
        Below Are Some Common Questions About Returns, And Exchanges
        </p>
    </div>

    <!-- FAQ List -->
    <div class="flex flex-col">
        <!-- FAQ Item 1 -->
        <div class="faq-accordion border-t border-gray-300">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">How Can I Find Out If A Product Is In Stock?</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            You can check product availability on each product page. If an item is out of stock, you can sign up for notifications to be alerted when it becomes available again.
            </p>
        </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="faq-accordion border-t border-gray-300">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">What Sizes Do You Offer?</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            We offer a wide range of sizes from XS to XL, and in some cases, we also have plus sizes. Check the size guide on each product page for specific measurements.
            </p>
        </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="faq-accordion border-t border-gray-300">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">How Can I Find Out If A Product Is In Stock?</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            You can check product availability on each product page. If an item is out of stock, you can sign up for notifications.
            </p>
        </div>
        </div>

        <!-- FAQ Item 4 - Expanded Example -->
        <div class="faq-accordion border-t border-gray-300">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">Shipping & Returns</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            We Offer A Wide Range Of Sizes From XS To XL, And In Some Cases, We Also Have Plus Sizes. Check The Size Guide On Each Product Page For Specific Measurements.
            </p>
        </div>
        </div>

        <!-- FAQ Item 5 -->
        <div class="faq-accordion border-t border-gray-300">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">What Sizes Do You Offer?</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            We offer sizes ranging from XS to XL. Please refer to our size guide for detailed measurements.
            </p>
        </div>
        </div>

        <!-- FAQ Item 6 -->
        <div class="faq-accordion border-t border-gray-300 border-b">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">Are Over-Ear Headphones Comfortable For Extended Periods Of Listening?</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            Yes, over-ear headphones are designed with comfort in mind, featuring padded ear cups and adjustable headbands for extended listening sessions.
            </p>
        </div>
        </div>
    </div>
    </div>
</section>
<section class="faqs_item w-full pb-[64px]">
    <div class="mx-auto flex w-full max-w-[1200px] flex-col bg-themeBg-g p-10">
    <!-- Section Header -->
    <div class="mb-6 md1:mb-8">
        <h2 class="text-f24 font-poppins-semibold text-themeText-a">
        <span class="text-red-600">P</span>roducts
        </h2>
        <p class="mt-2 text-f14 font-poppins-regular text-themeText-d">
        Below Are Some Common Questions About Returns, And Exchanges
        </p>
    </div>

    <!-- FAQ List -->
    <div class="flex flex-col">
        <!-- FAQ Item 1 -->
        <div class="faq-accordion border-t border-gray-300">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">How Can I Find Out If A Product Is In Stock?</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            You can check product availability on each product page. If an item is out of stock, you can sign up for notifications to be alerted when it becomes available again.
            </p>
        </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="faq-accordion border-t border-gray-300">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">What Sizes Do You Offer?</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            We offer a wide range of sizes from XS to XL, and in some cases, we also have plus sizes. Check the size guide on each product page for specific measurements.
            </p>
        </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="faq-accordion border-t border-gray-300">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">How Can I Find Out If A Product Is In Stock?</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            You can check product availability on each product page. If an item is out of stock, you can sign up for notifications.
            </p>
        </div>
        </div>

        <!-- FAQ Item 4 - Expanded Example -->
        <div class="faq-accordion border-t border-gray-300">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">Shipping & Returns</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            We Offer A Wide Range Of Sizes From XS To XL, And In Some Cases, We Also Have Plus Sizes. Check The Size Guide On Each Product Page For Specific Measurements.
            </p>
        </div>
        </div>

        <!-- FAQ Item 5 -->
        <div class="faq-accordion border-t border-gray-300">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">What Sizes Do You Offer?</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            We offer sizes ranging from XS to XL. Please refer to our size guide for detailed measurements.
            </p>
        </div>
        </div>

        <!-- FAQ Item 6 -->
        <div class="faq-accordion border-t border-gray-300 border-b">
        <button type="button" class="faq-trigger flex w-full items-center justify-between py-4 md1:py-5 text-left" aria-expanded="false">
            <span class="text-f18 font-poppins-regular text-themeText-f pr-4">Are Over-Ear Headphones Comfortable For Extended Periods Of Listening?</span>
            <svg class="faq-icon h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="faq-content hidden pb-4">
            <p class="text-f16 font-poppins-regular text-themeText-g leading-relaxed">
            Yes, over-ear headphones are designed with comfort in mind, featuring padded ear cups and adjustable headbands for extended listening sessions.
            </p>
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