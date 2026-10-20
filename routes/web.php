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
use App\Http\Controllers\FrontLangController;
use App\Http\Controllers\FixProductBrandJunkController;


// Avoid /front/lang/*.js — nginx may 404 missing public static files before Laravel.
Route::get('/front/i18n/{locale}.js', [FrontLangController::class, 'script'])
    ->where('locale', '[A-Za-z_-]+')
    ->name('front.lang.js');
Route::get('/front/lang/{locale}.js', [FrontLangController::class, 'script'])
    ->where('locale', '[A-Za-z_-]+');

// 线上语言包诊断（确认 json 路径/是否生效，排除静态缓存误判）
Route::get('/__lang_check', [FrontLangController::class, 'diagnose'])->name('front.lang.check');
Route::get('/lang_check', [FrontLangController::class, 'diagnose']);

// 清理产品详情误译品牌 HTML（JUNIO / about-us 蓝链）。默认 dry-run；?apply=1 写库
Route::get('/__fix_product_junio', FixProductBrandJunkController::class);
Route::get('/fix_product_junio', FixProductBrandJunkController::class);

// 为产品详情西班牙语段落开头 JUNEX 添加 about-us 深蓝链接。默认 dry-run；?apply=1 写库
Route::get('/__fix_product_junex_link', [FixProductBrandJunkController::class, 'linkJunexAbout']);
Route::get('/fix_product_junex_link', [FixProductBrandJunkController::class, 'linkJunexAbout']);

Route::get('/', [HomeController::class, 'index'])->name('home');

// 按访问域名对应的语言，输出 public/sitemap_{lang}.xml
Route::get('/sitemap.xml', function (\Illuminate\Http\Request $request) {
    $catalog = app(\App\Services\FrontPageCatalogService::class);
    $file = $catalog->resolveSitemapFile($request->getHost());
    if ($file === null) {
        try {
            $catalog->generateSitemap();
        } catch (\Throwable $e) {
            abort(404);
        }
        $file = $catalog->resolveSitemapFile($request->getHost());
    }
    if ($file === null || !is_file($file)) {
        abort(404);
    }
    return response()->file($file, ['Content-Type' => 'application/xml; charset=UTF-8']);
})->name('sitemap');

// 伪 robots.txt：读取 public/robot_temp.txt 模板，{domain} 替换为当前访问域名
Route::get('/robots.txt', function (\Illuminate\Http\Request $request) {
    $tpl = public_path('robot_temp.txt');
    $content = is_file($tpl) ? (string)file_get_contents($tpl) : "User-agent: *\nAllow: /\nSitemap: {domain}/sitemap.xml\n";
    $domain = rtrim($request->getSchemeAndHttpHost(), '/');
    $content = str_replace('{domain}', $domain, $content);
    return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
})->name('robots');

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
