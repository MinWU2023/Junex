<?php
use Illuminate\Support\Facades\Route;
use App\Modules\LaraPersonate\Controllers\ImpersonateController;
use App\Modules\Admin\Controllers\AdminUserController;
use App\Http\Controllers\LandPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MyInquiryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ReviewApiController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\NewStyleController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/sitemap.xml', function () {
    $file = public_path('sitemap.xml');
    if (!is_file($file)) {
        try {
            app(\App\Services\FrontPageCatalogService::class)->generateSitemap();
        } catch (\Throwable $e) {
            abort(404);
        }
    }
    if (!is_file($file)) {
        abort(404);
    }
    return response()->file($file, ['Content-Type' => 'application/xml; charset=UTF-8']);
})->name('sitemap');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/videos', [VideoController::class, 'index'])->name('videos');
Route::get('/video/{slug}', [VideoController::class, 'show'])->name('video.show');

Route::get('/about-us', [HomeController::class, 'aboutUs']);

Route::get('/contact-us', [HomeController::class, 'contactUs']);

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');

Route::get('/api/reviews', [ReviewApiController::class, 'index'])->name('api.reviews.index');

Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/newstyle', [NewStyleController::class, 'index'])->name('newstyle');

Route::get('/myinquirys', [MyInquiryController::class, 'index'])->name('myinquirys');
Route::get('/inquiry-list', [MyInquiryController::class, 'index'])->name('inquiry.list');
Route::post('/myinquirys', [MyInquiryController::class, 'store'])->name('myinquirys.store');
Route::post('/inquiry-list', [MyInquiryController::class, 'store'])->name('inquiry.list.store');

Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');

Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.submit');

Route::get('/forget', [CustomerAuthController::class, 'showForget'])->name('forget');
Route::post('/forget', [CustomerAuthController::class, 'forget'])->name('forget.submit');

Route::get('/customer-services', [HomeController::class, 'customerServices'])->name('customer-services');

Route::get('/faqs', [FaqController::class, 'index'])->name('faqs');

Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');

Route::get('/notfound', [HomeController::class, 'notFound'])->name('notfound');

Route::get('/inquirysuccess', [HomeController::class, 'inquirySuccessFront'])->name('inquirysuccess');

Route::post('/inquiry', [HomeController::class, 'inquiryStore'])->name('inquiry.store');

Route::post('/api/inquiry-popup', [HomeController::class, 'inquiryPopupStore'])->name('api.inquiry.popup.store');

Route::post('/api/ask-us-inquiry', [HomeController::class, 'askUsInquiryStore'])->name('api.askus.inquiry.store');

Route::post('/addreview', [ReviewApiController::class, 'store'])->name('addreview');

Route::post('/collect', [CollectController::class, 'toggle'])->name('collect');

Route::post('/getUser', [UserApiController::class, 'getUser'])->name('getUser');

Route::post('/api/prefer', [UserApiController::class, 'prefer'])->name('api.prefer');

Route::post('/api/refer', [UserApiController::class, 'prefer'])->name('api.refer');

Route::get('/apiLogin',[AdminUserController::class,'apiLogin']);
Route::get('download/{token}', [AdminUserController::class, 'download']);

Route::post('/inquiryStore', [AdminUserController::class, 'inquiry'])->middleware(\Spatie\Honeypot\ProtectAgainstSpam::class);
Route::get('/inquirySuccess', [AdminUserController::class, 'inquirySuccess']);

Route::get('/preProduct/{id}', [AdminUserController::class, 'preProduct']);
Route::get('/lock',[LandPageController::class,'lock']);
Route::post('lockSubmit', [LandPageController::class, 'lockSubmit'])->name('lock.submit');
Route::group(['prefix' => 'impersonate', 'as' => 'impersonate.', 'middleware' => 'web'], function () {
    # :/impersonate/list
    Route::get('list', [ImpersonateController::class, 'list'])->name('list');

    # :/impersonate/signin
    Route::post('signin', [ImpersonateController::class, 'signin'])->name('signin');

    # :/impersonate/logout
    Route::post('logout', [ImpersonateController::class, 'logout'])->name('logout');
});
