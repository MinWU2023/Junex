<?php

namespace App\Providers;

use App\Modules\Page\Models\Page;
use App\Modules\Url\Contracts\UrlModelContract;
use App\Modules\Url\Models\Url;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\ControllerDispatcher;
use Illuminate\Routing\Route as Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UrlServiceProvider extends ServiceProvider
{

    /**
     * Create a new service provider instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->registerRoutes();
        $this->registerRouteBindings();
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

    /**
     * @return void
     */
    protected function registerRoutes()
    {
        Route::macro('customUrl', function () {
            if (app()->environment() === 'production') {
                $middleware = ['web', 'optimize', 'locale', 'cachepage', 'homeLock'];
            } else {
                $middleware = ['web', 'locale', 'homeLock'];
            }
            Route::middleware($middleware)->get('{all}_p{page}', function ($url = '/') {
                $url = preg_replace('/\_p\\d+/', '', $url);
                $url = Url::withTrashed()->whereUrl($url)->first();
                if (!$url) {
                    abort(404);
                }
                $model = $url->urlable;
                if (!$model) {
                    abort(404);
                }

                // Overlap: dedicated front route wins over CMS single page
                if ($model instanceof Page) {
                    $dedicated = front_dispatch_dedicated_route($url->url);
                    if ($dedicated !== null) {
                        return $dedicated;
                    }
                }

                $controller = $model->getUrlOptions()->routeController;
                $action = $model->getUrlOptions()->routeAction;
                return (new ControllerDispatcher(app()))->dispatch(
                    app(Router::class)->setAction([
                        'uses' => $controller . '@' . $action,
                        'model' => $model,
                    ]), app($controller), $action
                );
            })->where('all', '(.*)');
            Route::middleware($middleware)->get('{all}', function ($url = '/') {
                $url = preg_replace('/\_p\\d+/', '', $url);
                $url = Url::withTrashed()->whereUrl($url)->first();
                if (!$url) {
                    abort(404);
                }
                if ($url->trashed()) {
                    $redirect_url = Url::query()->where([
                        'urlable_id' => $url->urlable_id,
                        'urlable_type' => $url->urlable_type
                    ])->first();
                    if ($redirect_url) {
                        return redirect($redirect_url->url);
                    }
                    return redirect('/');
                }
                $model = $url->urlable;
                if (!$model) {
                    abort(404);
                }

                // Overlap: dedicated front route wins over CMS single page
                if ($model instanceof Page) {
                    $dedicated = front_dispatch_dedicated_route($url->url);
                    if ($dedicated !== null) {
                        return $dedicated;
                    }
                }

                $controller = $model->getUrlOptions()->routeController;

                $action = $model->getUrlOptions()->routeAction;

                return (new ControllerDispatcher(app()))->dispatch(
                    app(Router::class)->setAction([
                        'uses' => $controller . '@' . $action,
                        'model' => $model,
                    ]), app($controller), $action
                );
            })->where('all', '(.*)');
        });
    }

    /**
     * @return void
     */
    protected function registerRouteBindings()
    {

        Route::model('url', UrlModelContract::class);
    }
}
