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
                <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Contact Us</span>
                </li>
            </ol>
            </nav>
        </div>
    </div>
</section>
  

<section class="infos w-full bg-themeBg-a py-10 md1:py-12 md4:py-16">
    <div class="mx-auto flex w-full max-w-[1200px] flex-col px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
        <div class="mx-auto flex w-full max-w-[1160px] flex-col items-center text-center">
            <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f ">HEFEI SECOND PAGE TECH CO., LTD.</h2>
            <p class="mt-4 text-f16 font-poppins-regular text-themeText-g ">
            Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing Elit, Sed Do Eiusmod Tempor Incididunt Ut Labore Et Dolore Magna Aliqua. Quis Ipsum
            Suspendisse Ultrices Gravida. Risus Commodo Viverra Maecenas Accumsan Lacus Vel Facilisis Lorem Ipsum Dolor Sit Amet, Consectetur
            Adipiscing Elit, Sed Do Eiusmod Tempor Incididunt Ut Labore Et Dolore Magna Aliqua. Quis Ipsum Suspendisse Ultrices.
            </p>
        </div>

        <div class="mt-10 flex w-full flex-col mt-4 gap-8 md4:flex-row md4:gap-10">
            <div class="flex w-full flex-col mt-4 bg-themeBg-g ring-1 ring-black/5 md4:w-[62%]">
            <div class="h-4 w-full bg-[url('/front/imgs/index_form_top_bg.png')] bg-no-repeat bg-top bg-left" aria-hidden="true"></div>
            <div class="flex w-full flex-col mt-4 p-6 md1:p-8">
                <div class="flex items-center gap-3">
                <div class="flex h-[40px] w-[50px] items-center justify-center" aria-hidden="true">
                    <img src="/front/icons/contactus/leaveamessage.svg" alt="Leave a message" class="h-[40px] w-[50px] object-contain" loading="lazy" />
                </div>
                <h3 class="text-f26 font-poppins-semibold text-themeText-g">Leave A Message</h3>
                </div>
                <p class="mt-3 text-f14 font-poppins-regular text-themeText-g">
                If You Are Interested In Our Products And Want To Know More Details, Please Leave A Message Here. We Will Reply You As Soon As We Can.
                </p>

                <form class="mt-6 flex w-full flex-col mt-4 gap-6" action="#" onsubmit="return false" method="post">
                <div class="flex w-full flex-col gap-1">
                    <label class="text-f14 font-poppins-regular text-themeText-g">Name<span class="text-themeBg-d">*</span></label>
                    <input class="h-11 w-full rounded bg-white px-4 text-f14 font-poppins-regular text-themeText-p ring-1 ring-themeBg-c placeholder:text-themeText-a focus:outline-none focus:ring-2 focus:ring-themeBg-d" type="text" placeholder="Please Enter Your Name" />
                </div>

                <div class="flex w-full flex-col gap-1">
                    <label class="text-f14 font-poppins-regular text-themeText-g">E-Mail<span class="text-themeBg-d">*</span></label>
                    <input class="h-11 w-full rounded bg-white px-4 text-f14 font-poppins-regular text-themeText-p ring-1 ring-themeBg-c placeholder:text-themeText-a focus:outline-none focus:ring-2 focus:ring-themeBg-d" type="email" placeholder="Please Enter Your Email Address" />
                </div>

                <div class="flex w-full flex-col gap-1">
                    <label class="text-f14 font-poppins-regular text-themeText-g">Quantity</label>
                    <div class="relative">
                    <select class="h-11 w-full appearance-none rounded bg-white px-4 pr-10 text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c focus:outline-none focus:ring-2 focus:ring-themeBg-d">
                        <option value="" selected>Please Select Quantity</option>
                        <option value="1">1</option>
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <svg class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-themeText-a" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                    </div>
                </div>

                <div class="flex w-full flex-col gap-1">
                    <label class="text-f14 font-poppins-regular text-themeText-g">Tel/ WhatsApp<span class="text-themeBg-d">*</span></label>
                    <input class="h-11 w-full rounded bg-white px-4 text-f14 font-poppins-regular text-themeText-p ring-1 ring-themeBg-c placeholder:text-themeText-a focus:outline-none focus:ring-2 focus:ring-themeBg-d" type="text" placeholder="Please Enter Your Telephone Number Or WhatsApp Number" />
                </div>

                <div class="flex w-full flex-col gap-1">
                    <label class="text-f14 font-poppins-regular text-themeText-g">Content<span class="text-themeBg-d">*</span></label>
                    <textarea class="min-h-[140px] w-full resize-none rounded bg-white px-4 py-3 text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c placeholder:text-themeText-a focus:outline-none focus:ring-2 focus:ring-themeBg-d" placeholder="Please Enter The Content"></textarea>
                </div>

                <div class="mt-2 flex w-full justify-center">
                    <button type="button" class="inline-flex h-[50px] items-center justify-center bg-black px-4 text-f14 font-poppins-medium uppercase tracking-wide text-white transition hover:bg-black/90">Send Inquiry Now</button>
                </div>
                </form>
            </div>
            </div>

            <div class="flex w-full flex-col mt-4 gap-8 md4:w-[38%]">
            <div class="flex w-full flex-col mt-4">
                <h3 class="text-f26 font-poppins-semibold text-themeText-f">Get In Touch With</h3>
                <div class="relative mt-3">
                <div class="h-[5px] w-16 bg-themeBg-d relative z-10" aria-hidden="true"></div>
                <div class="absolute left-0 top-0 h-[5px] w-full bg-themeBg-g" aria-hidden="true"></div>
                </div>
                <p class="mt-4 text-f14 font-poppins-regular text-themeText-g">
                Ningguo Friend Trading Co.,Ltd Is Specialized In Research, And Of Shock Absorber Mount, Engine Mount, Stabilizer Links, Control Arm Bushing
                </p>

                <div class="mt-6 flex flex-col gap-8">
                <div class="flex items-start gap-4">
                    <div class="flex h-[60px] w-[60px] min-h-[60px] min-w-[60px] shrink-0 items-center justify-center bg-themeBg-d" aria-hidden="true">
                    <img src="/front/icons/contactus/phone.svg" alt="Phone icon" class="h-auto w-9" loading="lazy" />
                    </div>
                    <div class="flex flex-col">
                    <div class="text-f18 font-poppins-medium uppercase tracking-wide text-themeBg-d">Give Us A Call</div>
                    <div class="mt-1 text-f14 font-poppins-regular text-themeText-g">Phone : +86 181 5606 4977</div>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="flex h-[60px] w-[60px] min-h-[60px] min-w-[60px] shrink-0 items-center justify-center bg-themeBg-d" aria-hidden="true">
                    <img src="/front/icons/contactus/email.svg" alt="Email icon" class="h-auto w-9" loading="lazy" />
                    </div>
                    <div class="flex flex-col">
                    <div class="text-f18 font-poppins-medium uppercase tracking-wide text-themeBg-d">Email Us</div>
                    <div class="mt-1 text-f14 font-poppins-regular text-themeText-g">Email : sale@detugroup.com</div>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="flex h-[60px] w-[60px] min-h-[60px] min-w-[60px] shrink-0 items-center justify-center bg-themeBg-d" aria-hidden="true">
                    <img src="/front/icons/contactus/address.svg" alt="Address icon" class="h-auto w-9" loading="lazy" />
                    </div>
                    <div class="flex flex-col">
                    <div class="text-f18 font-poppins-medium uppercase tracking-wide text-themeBg-d">Address</div>
                    <div class="mt-1 text-f14 font-poppins-regular leading-relaxed text-themeText-b">G08-2 Building, B No.90-1 Heifu Xiang Qinghuai District Nanjing,210007 Jiangsu China</div>
                    </div>
                </div>
                </div>
            </div>

            <div class="flex w-full flex-col mt-4">
                <h3 class="text-f26 font-poppins-semibold text-themeText-g">Social Networks</h3>
                <div class="relative mt-3">
                <div class="h-[5px] w-16 bg-themeBg-d relative z-10" aria-hidden="true"></div>
                <div class="absolute left-0 top-0 h-[5px] w-full bg-themeBg-g" aria-hidden="true"></div>
                </div>
                <p class="mt-4 text-f14 font-poppins-regular text-themeText-g">
                Ningguo Friend Trading Co.,Ltd Is Specialized In Research, And Of Shock Absorber Mount, Engine Mount
                </p>

                <div class="mt-5 flex items-center gap-2">
                <a href="#" class="inline-flex h-8 w-8 items-center justify-center rounded bg-[#1DA1F2] text-white transition hover:opacity-90" aria-label="Twitter">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true"><path d="M22 5.92c-.73.33-1.52.55-2.35.65.85-.51 1.5-1.32 1.81-2.28-.8.47-1.69.82-2.63 1A4.12 4.12 0 0015.5 3c-2.27 0-4.1 1.86-4.1 4.16 0 .33.03.65.1.96-3.41-.18-6.43-1.83-8.46-4.35a4.2 4.2 0 00-.56 2.1c0 1.44.72 2.71 1.8 3.46-.67-.02-1.3-.21-1.85-.51v.05c0 2.02 1.42 3.7 3.3 4.09-.34.1-.7.15-1.08.15-.26 0-.52-.02-.76-.07.52 1.63 2 2.82 3.77 2.85A8.26 8.26 0 012 18.2 11.64 11.64 0 008.29 20c7.55 0 11.68-6.34 11.68-11.84 0-.18 0-.36-.01-.54A8.5 8.5 0 0022 5.92z"/></svg>
                </a>
                <a href="#" class="inline-flex h-8 w-8 items-center justify-center rounded bg-[#0A66C2] text-white transition hover:opacity-90" aria-label="LinkedIn">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5C4.98 4.88 3.87 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM0.5 23.5h4V7.98h-4V23.5zM8.5 7.98h3.83v2.12h.05c.53-1.01 1.84-2.08 3.79-2.08 4.05 0 4.8 2.71 4.8 6.24v9.24h-4v-8.2c0-1.95-.04-4.47-2.7-4.47-2.71 0-3.12 2.13-3.12 4.33v8.34h-4V7.98z"/></svg>
                </a>
                <a href="#" class="inline-flex h-8 w-8 items-center justify-center rounded bg-[#FF0000] text-white transition hover:opacity-90" aria-label="YouTube">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true"><path d="M23.5 6.2a3 3 0 00-2.1-2.12C19.6 3.6 12 3.6 12 3.6s-7.6 0-9.4.48A3 3 0 00.5 6.2 31.5 31.5 0 000 12a31.5 31.5 0 00.5 5.8 3 3 0 002.1 2.12c1.8.48 9.4.48 9.4.48s7.6 0 9.4-.48a3 3 0 002.1-2.12A31.5 31.5 0 0024 12a31.5 31.5 0 00-.5-5.8zM9.8 15.5V8.5l6.2 3.5-6.2 3.5z"/></svg>
                </a>
                <a href="#" class="inline-flex h-8 w-8 items-center justify-center rounded bg-[#E1306C] text-white transition hover:opacity-90" aria-label="Instagram">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true"><path d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm10 2H7a3 3 0 00-3 3v10a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3zm-5 3.5A4.5 4.5 0 1112 16a4.5 4.5 0 010-9zm0 2A2.5 2.5 0 1014.5 12 2.5 2.5 0 0012 9.5zM17.75 6.3a1.05 1.05 0 11-1.05 1.05 1.05 1.05 0 011.05-1.05z"/></svg>
                </a>
                <a href="#" class="inline-flex h-8 w-8 items-center justify-center rounded bg-[#BD081C] text-white transition hover:opacity-90" aria-label="Pinterest">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true"><path d="M12.1 2C6.6 2 2 6.1 2 11.6c0 4.1 2.5 7.7 6.1 9.2-.1-.8-.2-2 0-2.9.2-.8 1.4-5.3 1.4-5.3s-.4-.8-.4-2c0-1.9 1.1-3.3 2.5-3.3 1.2 0 1.7.9 1.7 1.9 0 1.2-.8 3-1.2 4.6-.3 1.4.7 2.5 2 2.5 2.4 0 4.2-2.6 4.2-6.3 0-3.3-2.3-5.6-5.6-5.6-3.8 0-6 2.9-6 5.9 0 1.2.4 2.4 1.1 3.1.1.1.1.2.1.4-.1.4-.3 1.2-.3 1.3-.1.2-.2.3-.4.2-1.6-.8-2.6-3.2-2.6-5.2 0-4.2 3-8 8.7-8 4.6 0 8.2 3.3 8.2 7.6 0 4.5-2.8 8.2-6.7 8.2-1.3 0-2.6-.7-3-1.5l-.8 3c-.3 1-.9 2.3-1.3 3.1.9.3 1.9.5 2.9.5 5.5 0 10.1-4.1 10.1-9.6C22.2 6.1 17.6 2 12.1 2z"/></svg>
                </a>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>

<section class="maps flex w-full justify-center bg-themeBg-a">
    <div class="mx-auto flex w-full max-w-[100%] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
        <div class="w-full overflow-hidden bg-themeBg-g ring-1 ring-black/5">
            <iframe
            title="Google Map"
            class="h-[220px] w-full sm6:h-[260px] md1:h-[320px] md4:h-[420px] lg1:h-[480px]"
            src="https://www.google.com/maps?q=Hefei%20Science%20%26%20Technology%20Museum&output=embed"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allowfullscreen
            ></iframe>
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