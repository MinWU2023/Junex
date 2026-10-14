@php
    $inputId = $inputId ?? ('inquiry-attachments-' . uniqid());
    $labelClass = $labelClass ?? 'form-field-label text-f14 font-poppins-regular text-slate-700';
    $compact = !empty($compact);
@endphp
<div
    class="js-inquiry-attachment inquiry-attach {{ $compact ? 'inquiry-attach--compact' : '' }}"
    data-max-files="5"
    data-max-size="10485760"
>
    <label class="{{ $labelClass }}" for="{{ $inputId }}">{{ __('Attachment') }} <span class="font-normal text-slate-400">{{ __('(optional, max 5)') }}</span></label>

    <div
        class="js-inquiry-attach-zone inquiry-attach__zone relative mt-2 cursor-pointer rounded border border-dashed border-slate-300 bg-slate-50/60 px-4 py-6 text-center transition hover:border-themeBg-d hover:bg-white"
        tabindex="0"
        role="button"
        aria-label="{{ __('Upload attachments') }}"
    >
        <input
            id="{{ $inputId }}"
            class="js-inquiry-attachment-input absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0"
            type="file"
            name="attachments[]"
            multiple
            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.png,.jpg,.jpeg,.gif,.webp,.bmp,.zip,.rar,.7z,.txt,.csv,image/*,application/pdf"
        />
        <div class="pointer-events-none relative z-0">
            <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-white text-themeBg-d shadow-sm ring-1 ring-slate-200">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 16V7"/>
                    <path d="M8.5 10.5L12 7l3.5 3.5"/>
                    <path d="M4 16.5V18a2 2 0 002 2h12a2 2 0 002-2v-1.5"/>
                </svg>
            </div>
            <p class="mt-3 text-f14 font-poppins-medium text-slate-700">
                {{ __('Drag & drop files here, or') }} <span class="text-themeBg-d underline">{{ __('browse') }}</span>
            </p>
            <p class="mt-1 text-[12px] text-slate-400">
                {{ __('PDF / Office / Images / ZIP · each ≤ 10MB') }}
            </p>
        </div>
        <div class="js-inquiry-attach-overlay absolute inset-0 z-20 hidden items-center justify-center bg-white/80 text-f14 font-poppins-medium text-themeBg-d">
            {{ __('Drop files to upload') }}
        </div>
    </div>

    {{-- Selected files preview; removable via JS --}}
    <ul class="js-inquiry-attachment-list mt-3 flex flex-col gap-2" aria-live="polite"></ul>
</div>
