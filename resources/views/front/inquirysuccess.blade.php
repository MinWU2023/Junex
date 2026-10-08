<x-layout>
@section('tdk')
@include('front.partials.seo-head')
@endsection

@section('page-css-header')
<link type="text/css" rel="stylesheet" href="/front/css/pages/home.css" />
@endsection

@if(isset($pageBanner) && $pageBanner->count())
@section('pagebanner')
@include('front.partials.page-banner-bg')
@endsection
@endif

@section('page-js-header')

@endsection 


@section('content')
<section class="w-full breadcrumb bg-themeBg-a md4:bg-themeBg-g">
    <div>
    <div class="mx-auto w-full max-w-[1200px] px-4 py-4 sm2:px-5 md1:px-6 lg1:px-0">
        <nav aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center gap-x-3 gap-y-1">
            @if(isset($breadcrumbs) && count($breadcrumbs))
                @foreach($breadcrumbs as $index => $crumb)
                    @if($index === 0)
                        <li class="inline-flex items-center">
                            @if(!empty($crumb['url']))
                                <a href="{{ $crumb['url'] }}" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                                    <img src="{{ front_webp_url('/front/imgs/breadcrumbs-home.png') }}" alt="Home" class="w-[14px] h-[14px]" />
                                    <span class="font-poppins-regular  text-f14 text-themeText-p">{{ $crumb['label'] }}</span>
                                </a>
                            @else
                                <span class="inline-flex items-center gap-2">
                                    <img src="{{ front_webp_url('/front/imgs/breadcrumbs-home.png') }}" alt="Home" class="w-[14px] h-[14px]" />
                                    <span class="font-poppins-regular  text-f14 text-themeText-p">{{ $crumb['label'] }}</span>
                                </span>
                            @endif
                        </li>
                    @else
                        <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
                            <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6" />
                            </svg>
                        </li>
                        <li class="inline-flex items-center">
                            @if(!empty($crumb['url']))
                                <a href="{{ $crumb['url'] }}" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                                    <span class="font-poppins-regular  text-f14 text-themeText-p">{{ $crumb['label'] }}</span>
                                </a>
                            @else
                                <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">{{ $crumb['label'] }}</span>
                            @endif
                        </li>
                    @endif
                @endforeach
            @else
            <li class="inline-flex items-center">
            <a href="#" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                <img src="{{ front_webp_url('/front/imgs/breadcrumbs-home.png') }}" alt="Home" class="w-[14px] h-[14px]" />
                <span class="font-poppins-regular  text-f14 text-themeText-p">Home</span>
            </a>
            </li>

            <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
            <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18l6-6-6-6" />
            </svg>
            </li>

            <li class="inline-flex items-center">
            <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Inquiry Success</span>
            </li>
            @endif
        </ol>
        </nav>
    </div>
    </div>
</section>
 
<section class="inquiry-success w-full bg-themeBg-a py-10 sm6:py-12 md1:py-16 md4:py-20">
    <div class="mx-auto flex w-[1200px] max-w-[calc(100%-30px)] flex-col items-center gap-8 md3:flex-row md3:items-stretch">
    <!-- Left: Success message -->
    <div class="flex-1 rounded bg-themeBg-f px-5 py-8 shadow-sm ring-1 ring-themeBg-c md1:px-7 md1:py-10 md4:px-9 md4:py-12">
        <div class="inline-flex items-center rounded-full bg-themeBg-c px-3 py-1 text-f18 font-poppins-medium uppercase tracking-wide text-themeText-h">
        Thank You For Your Inquiry
        </div>
        <div class="mt-5 flex flex-col gap-2 md1:mt-6">
        <div class="text-f32 font-poppins-semibold text-themeText-a md1:text-f36">
            Your message has been sent successfully.
        </div>
        <p class="text-f14 font-poppins-regular leading-relaxed text-themeText-b md1:text-f16">
            Our professional sales team will review your request and contact you within 24 hours with detailed quotation,
            product suggestions and shipping solutions tailored to your business.
        </p>
        </div>

        <p class="mt-4 text-f14 font-poppins-regular text-themeText-b md1:text-f16">
        You will be redirected to the home page in
        <span id="inquiry-success-countdown" class="font-poppins-semibold text-themeText-h">5</span>
        seconds. If you do not want to wait, you can also use the buttons below to continue browsing.
        </p>

        <div class="mt-6 flex flex-wrap items-center gap-3 md1:gap-4">
        <a href="/" class="inline-flex h-11 items-center justify-center rounded bg-themeBg-d px-5 text-f14 font-poppins-medium uppercase tracking-wide text-white transition hover:bg-[#c22522] md1:h-12 md1:px-6">
            Back To Home
        </a>
        <a href="/products.html" class="inline-flex h-11 items-center justify-center rounded border border-themeBg-d bg-white px-4 text-f14 font-poppins-medium uppercase tracking-wide text-themeText-h transition hover:bg-themeBg-d hover:text-white md1:h-12 md1:px-5">
            View More Products
        </a>
        </div>
    </div>

    <!-- Right: Extra info / quick links -->
    <div class="flex-1 flex flex-col gap-5 rounded bg-themeBg-g px-5 py-8 ring-1 ring-themeBg-c md1:px-7 md1:py-10 md4:px-9 md4:py-12">
        <div>
        <h2 class="text-f22 font-poppins-semibold text-themeText-a md1:text-f24">
            What happens next?
        </h2>
        <ul class="mt-3 space-y-2 text-f14 font-poppins-regular text-themeText-b md1:mt-4 md1:text-f16">
            <li>Our team checks your inquiry details such as quantity, target price and destination port.</li>
            <li>We select matching products, confirm specifications and prepare a clear quotation sheet.</li>
            <li>If necessary, our sales engineer will contact you for more information about your project.</li>
        </ul>
        </div>

        <div>
        <h3 class="text-f20 font-poppins-semibold text-themeText-a md1:text-f22">
            Continue exploring our services
        </h3>
        <div class="mt-3 grid grid-cols-1 gap-2 sm5:grid-cols-2">
            <a href="/customerservices.html" class="inline-flex items-center justify-between rounded bg-white px-4 py-3 text-left text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c transition hover:-translate-y-0.5 hover:bg-themeBg-d hover:text-white">
            <span>OEM / ODM Custom Service</span>
            <span aria-hidden="true"></span>
            </a>
            <a href="/products.html" class="inline-flex items-center justify-between rounded bg-white px-4 py-3 text-left text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c transition hover:-translate-y-0.5 hover:bg-themeBg-d hover:text-white">
            <span>Hot-Selling Products</span>
            <span aria-hidden="true"></span>
            </a>
            <a href="/index.html#about" class="inline-flex items-center justify-between rounded bg-white px-4 py-3 text-left text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c transition hover:-translate-y-0.5 hover:bg-themeBg-d hover:text-white">
            <span>About Our Factory</span>
            <span aria-hidden="true"></span>
            </a>
            <a href="/contactus.html" class="inline-flex items-center justify-between rounded bg-white px-4 py-3 text-left text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c transition hover:-translate-y-0.5 hover:bg-themeBg-d hover:text-white">
            <span>Contact Information</span>
            <span aria-hidden="true"></span>
            </a>
        </div>
        </div>

        <div class="mt-1 rounded bg-themeBg-n/70 px-4 py-3 text-f12 font-poppins-regular text-white md1:text-f14">
        For urgent projects, you can reach us directly by phone or WhatsApp on the numbers shown in the footer below.
        Our team is always ready to support your business with fast response and reliable service.
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
