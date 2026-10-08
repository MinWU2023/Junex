<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AssetHttpsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(UrlGenerator $urlGenerator)
    {
        //
        if(config('app.redirect_https'))
        {
            $this->app['request']->server->set('HTTPS','on');
            $urlGenerator->forceScheme('https');
        }
    }
}
