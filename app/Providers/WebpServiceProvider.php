<?php

namespace App\Providers;

use App\Libs\LaravelWebp\src\Webp;
use Illuminate\Support\ServiceProvider;

class WebpServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('webp', function () {
            return new Webp();
        });
    }
}
