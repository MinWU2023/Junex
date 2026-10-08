<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Modules\Admin\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Facades\Agent;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Str;

class AuthenticatedController extends AuthenticatedSessionController
{

    /**
     * Attempt to authenticate a new session.
     *
     * @param \Laravel\Fortify\Http\Requests\LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request)
    {
        $settings = app('settings');
        if (isset($settings['setting']) && is_object($settings['setting']) && $settings['setting']->login_pwd_encrypt == 1) {
            $request->merge(['password' => base64_decode(urldecode($request->input('password')))]);
        }
        return $this->loginAdminPipeline($request)->then(function ($request) {
//            Auth::logoutOtherDevices(\request()->input('password'));
            $admin = \auth()->user();
            $request->session()->forget('forceChangePassword');
            if ($admin->id === 2) {
                if (time() - strtotime($admin->created_at) > 60 * 60 * 24 * 90 && \request()->get('password') === 'website') {
                    $request->session()->put('forceChangePassword', true); //超过90天还是初始密码,强制修改
                    Log::info('需要强制修改密码');
                }
//                Log::info('登陆成功,密码:'.\request()->get('password').',创建时间:'.$admin->created_at);
            }
            if ($admin->id > 1){
                DB::table('admin_logs')->insert([
                    'user_id' => $admin->id,
                    'ip' => GetUserIP(),
                    'browser' => Agent::getUserAgent(),
                    'modelName'=>'login',
                    'path' => \request()->path(),
                    'name'=>date('Y-m-d H:i:s').' 用户'.$admin->email.'账号密码登陆网站',
                    'created_at'=>date('Y-m-d H:i:s')
                ]);
            }
            $admin->login_token = Str::random(100);
            $request->session()->put('login_token', $admin->login_token);
            $admin->save();
            LoginLog::login();
            return app(LoginResponse::class);
        });
    }


    public function createWx(Request $request)
    {
        return view('Admin.Views.wxlogin');
    }


    /**
     * Get the authentication pipeline instance.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Pipeline\Pipeline
     */
    protected function loginAdminPipeline(LoginRequest $request)
    {
        if (Fortify::$authenticateThroughCallback) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                call_user_func(Fortify::$authenticateThroughCallback, $request)
            ));
        }

        if (is_array(config('fortify.pipelines.login'))) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                config('fortify.pipelines.login')
            ));
        }

        return (new Pipeline(app()))->send($request)->through(array_filter([
            config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
            Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
            AttemptToAuthenticate::class,
            PrepareAuthenticatedSession::class,
        ]));
    }


    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Laravel\Fortify\Contracts\LogoutResponse
     */
    public function destroy(Request $request): LogoutResponse
    {
        $this->guard->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return app(LogoutResponse::class);
    }

}
