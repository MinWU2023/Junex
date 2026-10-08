<x-layout>
@section('tdk')
<title>{{ $tdk['title'] ?? '' }}</title>
@if(!empty($tdk['description']))
<meta name="description" content="{{ $tdk['description'] }}" />
@endif
@if(!empty($tdk['keywords']))
<meta name="keywords" content="{{ $tdk['keywords'] }}" />
@endif
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
<section class="w-full bg-themeBg-a">
    <div class="mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="py-10 md1:py-12 md4:py-16">
            <div class="mx-auto w-full max-w-[728px] bg-white shadow-[0_18px_40px_rgba(0,0,0,0.12)] ring-1 ring-black/5">
                <div class="px-5 py-7 sm6:px-8 md1:px-12">
                    <h1 class="text-center text-f26 md1:text-f32 font-poppins-semibold uppercase tracking-wide text-themeText-f">Login</h1>
                    <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>

                    @if ($errors->any())
                        <div class="mt-6 rounded bg-red-50 px-4 py-3 text-f14 text-red-700 ring-1 ring-red-200 whitespace-nowrap overflow-hidden text-ellipsis">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="auth_error hidden mt-6 rounded bg-red-50 px-4 py-3 text-f14 text-red-700 ring-1 ring-red-200 whitespace-nowrap overflow-hidden text-ellipsis"></div>

                    <form class="auth_form mt-7 space-y-6" method="post" action="{{ route('login.submit') }}">
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

                        <div>
                            <label class="block text-f14 font-poppins-regular text-themeText-g">Password <span class="text-themeBg-d">*</span></label>
                            <input
                                type="password"
                                name="password"
                                placeholder="Please enter your password"
                                class="mt-2 h-[46px] md1:h-[51px] w-full rounded border border-themeBg-h bg-white px-3 text-f14 text-themeText-a placeholder-themeText-i outline-none transition focus:border-themeBg-d"
                                required
                            />
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <label class="inline-flex items-center gap-2 text-f14 font-poppins-regular text-themeText-g">
                                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-themeBg-h text-themeBg-d focus:ring-themeBg-d" />
                                Remember me
                            </label>

                            <a href="{{ route('forget', ['redirect' => request('redirect', $redirect ?? '/')]) }}" class="text-f14 font-poppins-regular text-themeText-h transition hover:underline">Forgot password?</a>
                        </div>

                        <button type="submit" class="h-[48px] md1:h-[54px] w-full bg-themeText-f font-poppins-medium text-f16 uppercase tracking-wide text-white transition hover:opacity-90">
                            Sign In
                        </button>

                        <div class="text-center text-f14 font-poppins-regular text-themeText-g">
                            Don’t have an account?
                            <a href="{{ route('register', ['redirect' => request('redirect', $redirect ?? '/')]) }}" class="text-themeText-h transition hover:underline">Create one</a>
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

