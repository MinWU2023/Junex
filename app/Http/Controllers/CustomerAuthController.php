<?php

namespace App\Http\Controllers;

use App\Modules\User\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerAuthController extends Controller
{
    public function showLogin(Request $request)
    {
        $redirect = (string)$request->query('redirect', '/');
        $setting = app('settings')['setting'];
        $pageBanner = $this->getBannersByArea('Common');
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'login');

        $data = [
            'redirect' => $redirect,
            'tdk' => $tdk,
            'pageBanner' => $pageBanner,
        ];
        return view('front.login', $data);
    }

    public function login(Request $request)
    {
        $redirect = (string)$request->input('redirect', '/');

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $remember = (bool)$request->boolean('remember');

        if ($this->isNeedAuth()) {
            $ip = $request->ip();
            if ($ip) {
                $customer = Customer::query()->where('ip', $ip)->orderByDesc('id')->first();
                if ($customer) {
                    $customer->email = $credentials['email'];
                    $customer->username = Str::before($credentials['email'], '@') ?: $credentials['email'];
                    $customer->password = Hash::make($credentials['password']);
                    $customer->save();

                    Auth::guard('cust')->login($customer, $remember);
                    $request->session()->regenerate();

                    if ($request->expectsJson()) {
                        return response()->json([
                            'ok' => true,
                            'message' => 'Login successful.',
                            'redirect' => $redirect ?: '/',
                        ]);
                    }

                    return redirect()
                        ->route('login', ['redirect' => $redirect])
                        ->with([
                            'success' => 'Login successful.',
                            'success_redirect' => $redirect ?: '/',
                        ]);
                }
            }
        }

        if (Auth::guard('cust')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => true,
                    'message' => 'Login successful.',
                    'redirect' => $redirect ?: '/',
                ]);
            }

            return redirect()
                ->route('login', ['redirect' => $redirect])
                ->with([
                    'success' => 'Login successful.',
                    'success_redirect' => $redirect ?: '/',
                ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => false,
                'message' => 'The provided credentials are incorrect.',
                'errors' => [
                    'email' => ['The provided credentials are incorrect.'],
                ],
            ], 422);
        }

        return back()
            ->withInput($request->only(['email', 'redirect']))
            ->withErrors([
                'email' => 'The provided credentials are incorrect.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('cust')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showRegister(Request $request)
    {
        $redirect = (string)$request->query('redirect', '/');
        $setting = app('settings')['setting'];
        $pageBanner = $this->getBannersByArea('Common');
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'register');

        $data = [
            'redirect' => $redirect,
            'tdk' => $tdk,
            'pageBanner' => $pageBanner,
        ];
        return view('front.register', $data);
    }

    public function register(Request $request)
    {
        $redirect = (string)$request->input('redirect', '/');

        $data = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:customers,username'],
            'email' => ['required', 'email', 'max:255', 'unique:customers,email'],
            'telephone' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $customer = Customer::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'telephone' => $data['telephone'] ?? null,
            'country' => $data['country'] ?? null,
            'ip' => $request->ip(),
        ]);

        Auth::guard('cust')->login($customer);
        $request->session()->regenerate();

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Registration successful.',
                'redirect' => $redirect ?: '/',
            ]);
        }

        return redirect()
            ->route('register', ['redirect' => $redirect])
            ->with([
                'success' => 'Registration successful.',
                'success_redirect' => $redirect ?: '/',
            ]);
    }

    public function showForget(Request $request)
    {
        $redirect = (string)$request->query('redirect', '/');
        $setting = app('settings')['setting'];
        $pageBanner = $this->getBannersByArea('Common');
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'forget');

        $data = [
            'tdk' => $tdk,
            'pageBanner' => $pageBanner,
        ];
        return view('front.forget', $data);
    }

    public function forget(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Minimal flow: do not reveal whether the email exists.
        // If you want full reset-token + email sending, we can extend this later.
        $redirect = (string)$request->input('redirect', '/');

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'If the email exists, reset instructions have been sent.',
                'redirect' => $redirect ?: '/',
            ]);
        }

        return redirect()
            ->route('forget', ['redirect' => $redirect])
            ->with([
                'success' => 'If the email exists, reset instructions have been sent.',
                'success_redirect' => $redirect ?: '/',
            ]);
    }

    private function isNeedAuth(): bool
    {
        $path = base_path('resources/needauth.txt');
        if (!is_file($path)) {
            return false;
        }

        $value = trim((string)file_get_contents($path));
        return $value === '1';
    }
}
