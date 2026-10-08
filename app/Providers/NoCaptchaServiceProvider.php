<?php


namespace App\Providers;


use App\Extend\NoCaptcha;
use Illuminate\Support\ServiceProvider;

class NoCaptchaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $app = $this->app;

//        $this->bootConfig();

        $app['validator']->extend('noCaptcha', function ($attribute, $value) use ($app) {
            return $app['noCaptcha']->verifyResponse($value, $app['request']->getClientIp());
        });

        if ($app->bound('form')) {
            $app['form']->macro('noCaptcha', function ($attributes = []) use ($app) {
                return $app['noCaptcha']->display($attributes, $app->getLocale());
            });
        }
    }

    /**
     * Booting configure.
     */
    protected function bootConfig()
    {
//        $path = __DIR__.'/config/captcha.php';
//
//        $this->mergeConfigFrom($path, 'captcha');
//
//        if (function_exists('config_path')) {
//            $this->publishes([$path => config_path('captcha.php')]);
//        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('noCaptcha', function ($app) {
            return new NoCaptcha(
                $app['config']['noCaptcha.secret'],
                $app['config']['noCaptcha.sitekey'],
                $app['config']['noCaptcha.options']
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['noCaptcha'];
    }
}
