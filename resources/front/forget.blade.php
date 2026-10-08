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
<section class="w-full bg-themeBg-a">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="py-10 md1:py-12 md4:py-16">
            <div class="mx-auto w-full max-w-[728px] bg-white shadow-[0_18px_40px_rgba(0,0,0,0.12)] ring-1 ring-black/5">
                <div class="px-5 py-7 sm6:px-8 md1:px-12">
                    <h1 class="text-center text-f26 md1:text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">Forgot Password</h1>
                    <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>

                    @if (session('status'))
                        <div class="mt-6 rounded bg-green-50 px-4 py-3 text-f14 text-green-700 ring-1 ring-green-200">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-6 rounded bg-red-50 px-4 py-3 text-f14 text-red-700 ring-1 ring-red-200 whitespace-nowrap overflow-hidden text-ellipsis">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="auth_error hidden mt-6 rounded bg-red-50 px-4 py-3 text-f14 text-red-700 ring-1 ring-red-200 whitespace-nowrap overflow-hidden text-ellipsis"></div>

                    <p class="mt-7 text-f14 md1:text-f16 font-poppins-regular text-themeText-g leading-6">
                        Enter the email address associated with your account. If it exists in our system, we will send you reset instructions.
                    </p>

                    <form class="auth_form mt-7 space-y-6" method="post" action="{{ route('forget.submit') }}">
                        @csrf
                        <input type="hidden" name="redirect" value="{{ old('redirect', request('redirect', $redirect ?? '/')) }}" />

                        <div>
                            <label class="block text-f14 font-poppins-regular text-themeText-g">Email <span class="text-themeBg-d">*</span></label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Please enter your email"
                                class="mt-2 h-[46px] md1:h-[51px] w-full rounded border border-themeBg-h bg-white px-3 text-f14 text-themeText-a placeholder-themeText-i outline-none transition focus:border-themeBg-d"
                                required
                            />
                        </div>

                        <button type="submit" class="h-[48px] md1:h-[54px] w-full bg-themeText-f font-poppins-medium text-f16 uppercase tracking-wide text-white transition hover:opacity-90">
                            Send Reset Instructions
                        </button>

                        <div class="text-center text-f14 font-poppins-regular text-themeText-g">
                            <a href="{{ route('login', ['redirect' => request('redirect', $redirect ?? '/')]) }}" class="text-themeText-h transition hover:underline">Back to login</a>
                        </div>
                    </form>

                    @if (session('success'))
                        <script>
                            window.addEventListener('load', function () {
                                if (typeof window.showMessage === 'function') {
                                    window.showMessage({ type: 'success', message: @json(session('success')), duration: 2000 });
                                }
                                setTimeout(function () {
                                    window.location.href = @json(session('success_redirect', '/'));
                                }, 2000);
                            });
                        </script>
                    @endif
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

<script>
    (function () {
        var form = document.querySelector('.auth_form');
        if (!form) return;

        var errorBox = document.querySelector('.auth_error');
        var showError = function (msg) {
            if (!errorBox) return;
            errorBox.textContent = msg || 'Invalid request.';
            errorBox.classList.remove('hidden');
        };
        var hideError = function () {
            if (!errorBox) return;
            errorBox.textContent = '';
            errorBox.classList.add('hidden');
        };

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            hideError();

            var submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.disabled = true;

            var fd = new FormData(form);
            ajax.post(form.action, fd, {
                headers: { 'Accept': 'application/json' }
            }).then(function (res) {
                if (typeof window.showMessage === 'function') {
                    window.showMessage({ type: 'success', message: res.message || 'Success', duration: 2000 });
                }
                setTimeout(function () {
                    window.location.href = (res && res.redirect) ? res.redirect : '/';
                }, 2000);
            }).catch(function (err) {
                var msg = (err && err.response && err.response.message) ? err.response.message : (err && err.message ? err.message : 'Request failed.');
                if (err && err.response && err.response.errors) {
                    var firstKey = Object.keys(err.response.errors)[0];
                    if (firstKey && err.response.errors[firstKey] && err.response.errors[firstKey][0]) {
                        msg = err.response.errors[firstKey][0];
                    }
                }
                showError(msg);
            }).finally(function () {
                if (submitBtn) submitBtn.disabled = false;
            });
        });
    })();
</script>
@endsection
</x-layout>
