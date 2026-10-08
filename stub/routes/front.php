<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;


use Spatie\Honeypot\ProtectAgainstSpam;

if (app()->environment() === 'production') {
    $middleware = ['optimize', 'locale', 'cachepage'];
} else {
    $middleware = ['locale'];
}
Route::group(['middleware' => $middleware], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/products', [ProductController::class, 'category'])->name('products');
    Route::get('/products_p{page}', [ProductController::class, 'category']);
    Route::get('/news', [NewsController::class, 'index'])->name('news');
    Route::get('/news_p{page}', [NewsController::class, 'index']);

    Route::get('robots.txt', function (){
        $robots = file_get_contents(storage_path('robots.txt'));
        $robots.="\nSitemap: https://" .request()->getHost()."/sitemap.xml";
        return response($robots, 200)->header('Content-Type', 'text/plain');
    })->name('robots.txt');
});
