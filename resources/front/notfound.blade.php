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
            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Page Not Found</span>
            </li>
        </ol>
        </nav>
    </div>
    </div>
</section>
 
<section class="notfopund w-full bg-themeBg-a py-10 sm6:py-12 md1:py-16 md4:py-20">
    <div class="mx-auto flex w-[1200px] max-w-[calc(100%-30px)] flex-col items-center gap-8 md3:flex-row md3:items-stretch">
    <div class="flex-1 rounded bg-themeBg-f px-5 py-8 shadow-sm ring-1 ring-themeBg-c md1:px-7 md1:py-10 md4:px-9 md4:py-12">
        <div class="inline-flex items-center rounded-full bg-themeBg-c px-3 py-1 text-f18 font-poppins-medium uppercase tracking-wide text-themeText-h">
        Oops! Page Not Found
        </div>
        <div class="mt-5 flex flex-col gap-2 md1:mt-6">
        <div class="text-f48 font-poppins-extrabold leading-none text-themeText-h">404</div>
        <h1 class="text-f26 font-poppins-semibold text-themeText-a md1:text-f30">
            The page you are looking for cannot be found.
        </h1>
        </div>
        <p class="mt-4 text-f14 font-poppins-regular leading-relaxed text-themeText-b md1:mt-5 md1:text-f16">
        The link you followed may be broken, the page may have been moved, renamed, or is temporarily unavailable.
        Please use the navigation below to get back on track or return to our home page.
        </p>
        <p class="mt-4 text-f14 font-poppins-regular text-themeText-b md1:text-f16">
        You will be redirected to the home page in
        <span id="notfound-countdown" class="font-poppins-semibold text-themeText-h">5</span>
        seconds.
        </p>
        <div class="mt-6 flex flex-wrap items-center gap-3 md1:gap-4">
        <a href="/" class="inline-flex h-11 items-center justify-center rounded bg-themeBg-d px-5 text-f14 font-poppins-medium uppercase tracking-wide text-white transition hover:bg-[#c22522] md1:h-12 md1:px-6">
            Back To Home
        </a>
        <a href="/products.html" class="inline-flex h-11 items-center justify-center rounded border border-themeBg-d bg-white px-4 text-f14 font-poppins-medium uppercase tracking-wide text-themeText-h transition hover:bg-themeBg-d hover:text-white md1:h-12 md1:px-5">
            View Products
        </a>
        </div>
    </div>

    <div class="flex-1 flex flex-col gap-5 rounded bg-themeBg-g px-5 py-8 ring-1 ring-themeBg-c md1:px-7 md1:py-10 md4:px-9 md4:py-12">
        <div>
        <h2 class="text-f22 font-poppins-semibold text-themeText-a md1:text-f24">
            Why am I seeing this page?
        </h2>
        <ul class="mt-3 space-y-2 text-f14 font-poppins-regular text-themeText-b md1:mt-4 md1:text-f16">
            <li>• The page address was typed incorrectly.</li>
            <li>• The page has been updated or removed from our website.</li>
            <li>• The product or article has been replaced by a new version.</li>
        </ul>
        </div>

        <div>
        <h3 class="text-f20 font-poppins-semibold text-themeText-a md1:text-f22">
            Popular destinations
        </h3>
        <div class="mt-3 grid grid-cols-1 gap-2 sm5:grid-cols-2">
            <a href="/" class="inline-flex items-center justify-between rounded bg-white px-4 py-3 text-left text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c transition hover:-translate-y-0.5 hover:bg-themeBg-d hover:text-white">
            <span>Home</span>
            <span aria-hidden="true">→</span>
            </a>
            <a href="/products.html" class="inline-flex items-center justify-between rounded bg-white px-4 py-3 text-left text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c transition hover:-translate-y-0.5 hover:bg-themeBg-d hover:text-white">
            <span>Product Center</span>
            <span aria-hidden="true">→</span>
            </a>
            <a href="/customerservices.html" class="inline-flex items-center justify-between rounded bg-white px-4 py-3 text-left text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c transition hover:-translate-y-0.5 hover:bg-themeBg-d hover:text-white">
            <span>Custom Services</span>
            <span aria-hidden="true">→</span>
            </a>
            <a href="/contactus.html" class="inline-flex items-center justify-between rounded bg-white px-4 py-3 text-left text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c transition hover:-translate-y-0.5 hover:bg-themeBg-d hover:text-white">
            <span>Contact Us</span>
            <span aria-hidden="true">→</span>
            </a>
        </div>
        </div>

        <div class="mt-1 rounded bg-themeBg-n/60 px-4 py-3 text-f12 font-poppins-regular text-white md1:text-f14">
        If you continue to experience problems, please
        <a href="/contactus.html" class="font-poppins-medium text-themeText-o underline underline-offset-4 hover:text-white">contact our sales team</a>
        and we will be happy to help.
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