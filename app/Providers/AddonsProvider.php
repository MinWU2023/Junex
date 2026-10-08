<?php

namespace App\Providers;

use App\Services\AddonsService;
use Illuminate\Support\ServiceProvider;

class AddonsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $dyyseoAddons = new AddonsService();
        $providers = $dyyseoAddons->getProvidersMap();
        if ($providers) {
            array_map(function ($provider) {
                app()->register($provider);
            }, $providers);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
