@php
    $defaults = \App\Services\ContactUsBlockService::defaultContactUs();
    $cu = array_replace_recursive($defaults, $contactUs ?? []);
    $header = $cu['header'] ?? [];
    $form = $cu['form'] ?? [];
    $right = $cu['right'] ?? [];
    $map = $cu['map'] ?? [];
@endphp
<section class="infos w-full bg-themeBg-a py-16 sec-pad sec-bg-white">
    <div class="mx-auto flex w-full max-w-[1200px] flex-col px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
        <div class="mx-auto flex w-full max-w-[1160px] flex-col items-center text-center">
            <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f ">{{ $header['title'] ?? $defaults['header']['title'] }}</h2>
            <p class="mt-4 text-f16 font-poppins-regular text-themeText-g ">
            {{ $header['subtitle'] ?? $defaults['header']['subtitle'] }}
            </p>
        </div>

        <div class="mt-10 flex w-full flex-col mt-4 gap-8 md4:flex-row md4:gap-10">
            <div class="flex w-full flex-col mt-4 bg-themeBg-g ring-1 ring-black/5 md4:w-[62%] ask_us_form">
            <div class="h-4 w-full bg-[url('/front/imgs/index_form_top_bg.png')] bg-no-repeat bg-top bg-left" aria-hidden="true"></div>
            <div class="flex w-full flex-col mt-4 p-6 md1:p-8">
                <div class="flex items-center gap-3">
                <div class="flex h-[40px] w-[50px] items-center justify-center" aria-hidden="true">
                    <img src="/front/icons/contactus/leaveamessage.svg" alt="{{ $form['title'] ?? 'Leave a message' }}" class="h-[40px] w-[50px] object-contain" loading="lazy" />
                </div>
                <h3 class="text-f26 font-poppins-semibold text-themeText-g">{{ $form['title'] ?? $defaults['form']['title'] }}</h3>
                </div>
                <p class="mt-3 text-f14 font-poppins-regular text-themeText-g">
                {{ $form['subtitle'] ?? $defaults['form']['subtitle'] }}
                </p>

                <form class="mt-6 flex w-full flex-col mt-4 gap-6" action="#" onsubmit="return false" method="post" enctype="multipart/form-data">
                @include('front.partials.inquiry-form-hidden-fields')
                <div class="flex w-full flex-col gap-1">
                    <label class="form-field-label text-f14 font-poppins-regular text-themeText-g">{{ $form['label_name'] ?? 'Name' }}<x-front.form-required /></label>
                    <input name="name" required class="h-11 w-full rounded bg-white px-4 text-f14 font-poppins-regular text-themeText-p ring-1 ring-themeBg-c placeholder:text-themeText-a focus:outline-none focus:ring-2 focus:ring-themeBg-d" type="text" placeholder="{{ $form['placeholder_name'] ?? $defaults['form']['placeholder_name'] }}" />
                </div>

                <div class="flex w-full flex-col gap-1">
                    <label class="form-field-label text-f14 font-poppins-regular text-themeText-g">{{ $form['label_email'] ?? 'E-Mail' }}<x-front.form-required /></label>
                    <input name="email" required class="h-11 w-full rounded bg-white px-4 text-f14 font-poppins-regular text-themeText-p ring-1 ring-themeBg-c placeholder:text-themeText-a focus:outline-none focus:ring-2 focus:ring-themeBg-d" type="email" placeholder="{{ $form['placeholder_email'] ?? $defaults['form']['placeholder_email'] }}" />
                </div>

                <div class="flex w-full flex-col gap-1">
                    <label class="text-f14 font-poppins-regular text-themeText-g">{{ $form['label_quantity'] ?? 'Quantity' }}</label>
                    <div class="relative">
                    <select name="quantity" class="h-11 w-full appearance-none rounded bg-white px-4 pr-10 text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c focus:outline-none focus:ring-2 focus:ring-themeBg-d">
                        <option value="" selected>{{ $form['placeholder_quantity'] ?? 'Please Select Quantity' }}</option>
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
                    <label class="form-field-label text-f14 font-poppins-regular text-themeText-g">{{ $form['label_tel'] ?? 'Tel/ WhatsApp' }}</label>
                    <input name="tel" class="h-11 w-full rounded bg-white px-4 text-f14 font-poppins-regular text-themeText-p ring-1 ring-themeBg-c placeholder:text-themeText-a focus:outline-none focus:ring-2 focus:ring-themeBg-d" type="text" placeholder="{{ $form['placeholder_tel'] ?? $defaults['form']['placeholder_tel'] }}" />
                </div>

                <div class="flex w-full flex-col gap-1">
                    <label class="form-field-label text-f14 font-poppins-regular text-themeText-g">{{ $form['label_content'] ?? 'Content' }}<x-front.form-required /></label>
                    <textarea name="content" required class="min-h-[140px] w-full resize-none rounded bg-white px-4 py-3 text-f14 font-poppins-regular text-themeText-b ring-1 ring-themeBg-c placeholder:text-themeText-a focus:outline-none focus:ring-2 focus:ring-themeBg-d" placeholder="{{ $form['placeholder_content'] ?? $defaults['form']['placeholder_content'] }}"></textarea>
                </div>

                @include('front.partials.inquiry-attachment-field', [
                    'labelClass' => 'form-field-label text-f14 font-poppins-regular text-themeText-g',
                ])

                <div class="mt-2 flex w-full justify-center">
                    <button type="submit" class="inline-flex h-[50px] items-center justify-center bg-black px-4 text-f14 font-poppins-medium uppercase tracking-wide text-white transition hover:bg-black/90">{{ $form['button_text'] ?? 'Send Inquiry Now' }}</button>
                </div>
                </form>
            </div>
            </div>

            <div class="flex w-full flex-col mt-4 gap-8 md4:w-[38%]">
            <div class="flex w-full flex-col mt-4">
                <h3 class="text-f26 font-poppins-semibold text-themeText-f">{{ $right['touch_title'] ?? $defaults['right']['touch_title'] }}</h3>
                <div class="relative mt-3">
                <div class="h-[5px] w-16 bg-themeBg-d relative z-10" aria-hidden="true"></div>
                <div class="absolute left-0 top-0 h-[5px] w-full bg-themeBg-g" aria-hidden="true"></div>
                </div>
                <p class="mt-4 text-f14 font-poppins-regular text-themeText-g">
                {{ $right['touch_desc'] ?? $defaults['right']['touch_desc'] }}
                </p>

                <div class="mt-6 flex flex-col gap-8">
                <div class="flex items-start gap-4">
                    <div class="flex h-[60px] w-[60px] min-h-[60px] min-w-[60px] shrink-0 items-center justify-center bg-themeBg-d" aria-hidden="true">
                    <img src="/front/icons/contactus/phone.svg" alt="Phone icon" class="h-auto w-9" loading="lazy" />
                    </div>
                    <div class="flex flex-col">
                    <div class="text-f18 font-poppins-medium uppercase tracking-wide text-themeBg-d">{{ $right['phone_title'] ?? $defaults['right']['phone_title'] }}</div>
                    __CONTACT_PHONES_HTML__
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="flex h-[60px] w-[60px] min-h-[60px] min-w-[60px] shrink-0 items-center justify-center bg-themeBg-d" aria-hidden="true">
                    <img src="/front/icons/contactus/email.svg" alt="Email icon" class="h-auto w-9" loading="lazy" />
                    </div>
                    <div class="flex flex-col">
                    <div class="text-f18 font-poppins-medium uppercase tracking-wide text-themeBg-d">{{ $right['email_title'] ?? $defaults['right']['email_title'] }}</div>
                    __CONTACT_EMAILS_HTML__
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="flex h-[60px] w-[60px] min-h-[60px] min-w-[60px] shrink-0 items-center justify-center bg-themeBg-d" aria-hidden="true">
                    <img src="/front/icons/contactus/address.svg" alt="Address icon" class="h-auto w-9" loading="lazy" />
                    </div>
                    <div class="flex flex-col">
                    <div class="text-f18 font-poppins-medium uppercase tracking-wide text-themeBg-d">{{ $right['address_title'] ?? $defaults['right']['address_title'] }}</div>
                    <div class="mt-1 text-f14 font-poppins-regular leading-relaxed text-themeText-b">__CONTACT_ADDRESS__</div>
                    </div>
                </div>
                </div>
            </div>

            <div class="flex w-full flex-col mt-4">
                <h3 class="text-f26 font-poppins-semibold text-themeText-g">{{ $right['social_title'] ?? $defaults['right']['social_title'] }}</h3>
                <div class="relative mt-3">
                <div class="h-[5px] w-16 bg-themeBg-d relative z-10" aria-hidden="true"></div>
                <div class="absolute left-0 top-0 h-[5px] w-full bg-themeBg-g" aria-hidden="true"></div>
                </div>
                <p class="mt-4 text-f14 font-poppins-regular text-themeText-g">
                {{ $right['social_desc'] ?? $defaults['right']['social_desc'] }}
                </p>

                <div class="mt-5 flex items-center gap-2">
                @{{ sns_icons }}
                </div>
            </div>
            </div>
        </div>
    </div>
</section>

<section class="maps flex w-full justify-center bg-themeBg-a sec-bg-white">
    <div class="mx-auto flex w-full max-w-[100%] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
        <div class="w-full overflow-hidden bg-themeBg-g ring-1 ring-black/5">
            <iframe
            title="Google Map"
            class="h-[220px] w-full sm6:h-[260px] md1:h-[320px] md4:h-[420px] lg1:h-[480px]"
            src="{{ $map['iframe_src'] ?? $defaults['map']['iframe_src'] }}"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allowfullscreen
            ></iframe>
        </div>
    </div>
</section>
