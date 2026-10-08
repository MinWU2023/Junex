<section id="ask-us" class="w-full bg-themeBg-f ask_us scroll-mt-20 sec-bg-color">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
    <div class="sec-pad py-16">
        <div class="mx-auto max-w-[1200px] bg-white">
        <img class="w-full object-cover" src="/front/imgs/index_form_top_bg.png" alt="" loading="lazy" aria-hidden="true" />
        <div class="border border-slate-200 px-4 py-8 sm6:px-8 md1:px-10">
            <div class="text-center">
            <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
                {{ $askUs['title'] ?? 'To Power Your Brand With Us' }}
            </h2>
            <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
            <p class="mx-auto mt-4 max-w-[825px] leading-6  text-themeText-g text-f14">
                {{ $askUs['subtitle'] ?? 'Junzhuosport, As A Mature Sportswear/ Yoga Wear/ Fitness Clothing Wholesale Supplier And Custom Gym Wear Manufacturer, Focuses On Offering Eco-Friendly & Recycled & Sustainable Fabric' }}
            </p>
            </div>

            <form class="mt-8" action="#" onsubmit="return false" method="post" enctype="multipart/form-data">
            @include('front.partials.inquiry-form-hidden-fields')
            <div class="grid grid-cols-1 gap-x-6 gap-y-5 md4:grid-cols-2">
                <label class="block">
                <span class="form-field-label text-f14 font-poppins-regular text-slate-700">Name<x-front.form-required /></span>
                <input type="text" name="name" required placeholder="{{ $askUs['placeholder_name'] ?? 'Please Enter Your Name' }}" class="mt-2 h-[50px] w-full rounded border border-slate-200 bg-white px-3 text-f14 text-slate-900 outline-none ring-0 placeholder:text-slate-400 focus:border-themeBg-d" />
                </label>

                <label class="block">
                <span class="form-field-label text-f14 font-poppins-regular text-slate-700">E-Mail<x-front.form-required /></span>
                <input type="email" name="email" required placeholder="{{ $askUs['placeholder_email'] ?? 'Please Enter Your Email Address' }}" class="mt-2 h-[50px] w-full rounded border border-slate-200 bg-white px-3 text-f14 text-slate-900 outline-none ring-0 placeholder:text-slate-400 focus:border-themeBg-d" />
                </label>

                <label class="block">
                <span class="text-f14 font-poppins-regular text-slate-700">Quantity</span>
                <select name="quantity" class="mt-2 h-[50px] w-full rounded border border-slate-200 bg-white px-3 text-f14 text-slate-600 outline-none ring-0 focus:border-themeBg-d">
                    <option value="" selected>{{ $askUs['placeholder_quantity'] ?? 'Please Select Quantity' }}</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                </select>
                </label>

                <label class="block">
                <span class="form-field-label text-f14 font-poppins-regular text-slate-700">Tel / WhatsAPP<x-front.form-required /></span>
                <input type="tel" name="tel" required placeholder="{{ $askUs['placeholder_tel'] ?? 'Please Enter Your Telephone Number Or WhatsApp Number' }}" class="mt-2 h-[50px] w-full rounded border border-slate-200 bg-white px-3 text-f14 text-slate-900 outline-none ring-0 placeholder:text-slate-400 focus:border-themeBg-d" />
                </label>
            </div>

            <label class="mt-5 block">
                <span class="form-field-label text-f14 font-poppins-regular text-slate-700">Content<x-front.form-required /></span>
                <textarea name="content" rows="8" required placeholder="{{ $askUs['placeholder_content'] ?? 'Please Enter The Content' }}" class="mt-2 w-full resize-y rounded border border-slate-200 bg-white px-3 py-3 text-f14 text-slate-900 outline-none ring-0 placeholder:text-slate-400 focus:border-themeBg-d"></textarea>
            </label>

            <div class="mt-5">
                @include('front.partials.inquiry-attachment-field', [
                    'labelClass' => 'form-field-label text-f14 font-poppins-regular text-slate-700',
                ])
            </div>

            <div class="mt-7 flex justify-center">
                <button type="submit" class="inline-flex h-[50px] items-center justify-center bg-slate-900 px-4 text-f15 font-poppins-medium uppercase tracking-wide text-white transition hover:bg-slate-800">
                {{ $askUs['button_text'] ?? 'Send Inquiry Now' }}
                </button>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>
</section>
