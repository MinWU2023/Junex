<section id="ask-us" class="w-full bg-white ask_us scroll-mt-20 sec-bg-white">
    <div class="sec-pad mx-auto w-full max-w-[1200px] px-4 py-16 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="text-center">
            <h2 class="text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">
                __SECTION_TITLE__
            </h2>
            <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-brand-red" aria-hidden="true"></div>
            <p class="mx-auto mt-4 max-w-[825px] text-f14 font-poppins-regular leading-6 text-themeText-g">
                __SECTION_SUBTITLE__
            </p>
        </div>

        <form class="ask-us-form mt-8 md1:mt-10" action="#" onsubmit="return false" method="post" enctype="multipart/form-data">
            @include('front.partials.inquiry-form-hidden-fields')
            <div class="grid grid-cols-1 gap-4 md1:grid-cols-2">
                {{-- Name --}}
                <div class="relative">
                    <input
                        type="text"
                        name="name"
                        required
                        placeholder="{{ $askUs['placeholder_name'] ?? 'Please Enter Your Name' }}"
                        class="peer ask-us-input h-[50px] w-full px-4 py-3 pl-7 text-slate-900"
                    />
                    <span class="ask-us-req absolute left-4 top-1/2 -translate-y-1/2 text-sm opacity-0 peer-placeholder-shown:opacity-100" aria-hidden="true">*</span>
                </div>

                {{-- E-Mail --}}
                <div class="relative">
                    <input
                        type="email"
                        name="email"
                        required
                        placeholder="{{ $askUs['placeholder_email'] ?? 'Please Enter Your Email Address' }}"
                        class="peer ask-us-input h-[50px] w-full px-4 py-3 pl-7 text-slate-900"
                    />
                    <span class="ask-us-req absolute left-4 top-1/2 -translate-y-1/2 text-sm opacity-0 peer-placeholder-shown:opacity-100" aria-hidden="true">*</span>
                </div>

                {{-- Quantity (optional) — custom dropdown for consistent mobile/desktop alignment --}}
                <div class="inquiry-select" data-inquiry-select>
                    <input type="hidden" name="quantity" value="" data-inquiry-select-input />
                    <button
                        type="button"
                        class="inquiry-select__trigger ask-us-input"
                        data-inquiry-select-trigger
                        aria-haspopup="listbox"
                        aria-expanded="false"
                    >
                        <span class="inquiry-select__label" data-inquiry-select-label>{{ $askUs['placeholder_quantity'] ?? 'Please Select Quantity' }}</span>
                        <span class="inquiry-select__chevron" aria-hidden="true">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                    </button>
                    <ul class="inquiry-dropdown-menu" data-inquiry-select-menu role="listbox" hidden>
                        <li role="option" class="inquiry-dropdown-menu__item is-placeholder" data-value="" data-label="{{ $askUs['placeholder_quantity'] ?? 'Please Select Quantity' }}">{{ $askUs['placeholder_quantity'] ?? 'Please Select Quantity' }}</li>
                        <li role="option" class="inquiry-dropdown-menu__item" data-value="0~100" data-label="0~100">0~100</li>
                        <li role="option" class="inquiry-dropdown-menu__item" data-value="101~500" data-label="101~500">101~500</li>
                        <li role="option" class="inquiry-dropdown-menu__item" data-value="501~1000" data-label="501~1000">501~1000</li>
                        <li role="option" class="inquiry-dropdown-menu__item" data-value="1001~5000" data-label="1001~5000">1001~5000</li>
                        <li role="option" class="inquiry-dropdown-menu__item" data-value="5000+" data-label="5000+">5000+</li>
                    </ul>
                </div>

                {{-- Tel / WhatsApp --}}
                <div class="relative">
                    <input
                        type="tel"
                        name="tel"
                        required
                        placeholder="{{ $askUs['placeholder_tel'] ?? 'Please Enter Your Telephone Number Or WhatsApp Number' }}"
                        class="peer ask-us-input h-[50px] w-full px-4 py-3 pl-7 text-slate-900"
                    />
                    <span class="ask-us-req absolute left-4 top-1/2 -translate-y-1/2 text-sm opacity-0 peer-placeholder-shown:opacity-100" aria-hidden="true">*</span>
                </div>

                {{-- Content --}}
                <div class="relative md1:col-span-2">
                    <textarea
                        name="content"
                        rows="5"
                        required
                        placeholder="{{ $askUs['placeholder_content'] ?? 'Please Enter The Content' }}"
                        class="peer ask-us-input min-h-[120px] w-full resize-y px-4 py-3 pl-7 text-slate-900"
                    ></textarea>
                    <span class="ask-us-req absolute left-4 top-3.5 text-sm opacity-0 peer-placeholder-shown:opacity-100" aria-hidden="true">*</span>
                </div>

                <div class="md1:col-span-2">
                    @include('front.partials.inquiry-attachment-field', [
                        'labelClass' => 'form-field-label mb-1 block text-f14 font-poppins-regular text-themeText-g',
                    ])
                </div>
            </div>

            <div class="mt-6 flex justify-center md1:mt-8">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center bg-black px-8 py-3.5 text-sm font-bold uppercase tracking-wider text-white transition-colors hover:bg-gray-800"
                >
                    {{ $askUs['button_text'] ?? 'Send Inquiry Now' }}
                </button>
            </div>
        </form>
    </div>
</section>
