<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Responses\AdminLogoutResponse;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use Laravel\Fortify\Fortify;
use App\Http\Responses\AdminRegisterResponse;
use App\Http\Responses\AdminLoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Fortify::ignoreRoutes();
        $this->app->singleton(RegisterResponseContract::class, AdminRegisterResponse::class);
        $this->app->singleton(LoginResponseContract::class, AdminLoginResponse::class);
        $this->app->singleton(LogoutResponseContract::class, AdminLogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::loginView("Admin.Views.login");
        Fortify::registerView("Admin.Views.register");
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
//        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
//        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }
}
