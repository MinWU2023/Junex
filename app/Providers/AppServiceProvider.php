<?php

namespace App\Providers;

use App\Modules\AddonsMarket\Models\Addon;
use App\Modules\FileInfo\Contracts\FilesServiceContract;
use App\Modules\FileInfo\Services\FilesService;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Inquiry\Models\Newsletter;
use App\Modules\Setting\Models\Locale;
use App\Observers\InquiryObserver;
use App\Services\SettingService;
use App\Utils\AcademyPaginator;
use Illuminate\Contracts\Config\Repository as ConfigContract;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(FilesServiceContract::class, FilesService::class);
        $this->app->singleton('mix', function () {
            return function (string $path, string $manifestDirectory = '') {
                if (!Str::startsWith($path, '/')) {
                    $path = "/{$path}";
                }
                if ($manifestDirectory && !Str::startsWith($manifestDirectory, '/')) {
                    $manifestDirectory = "/{$manifestDirectory}";
                }
                $manifestPath = public_path($manifestDirectory.'/mix-manifest.json');
                if (!is_file($manifestPath)) {
                    return config('app.mix_url').$manifestDirectory.$path;
                }
                return app(\Illuminate\Foundation\Mix::class)($path, $manifestDirectory);
            };
        });
        $this->app->singleton('settings', function ($app) {
            $settingService = $this->app->make(SettingService::class);
            $data = $settingService->getAllSetting();
            return $data;
        });
        $this->app->singleton('myAddons', function () {
            return collect(Addon::where('status', 1)->get())->map(function ($q) {
                return $q->sign;
            })->toArray();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(ConfigContract $config, TranslatorContract $translator)
    {
        Schema::defaultStringLength(191);

        // 同步静态资源缓存 Nginx 标记文件（失败不影响站点）
        try {
            app(\App\Services\StaticAssetCacheService::class)->syncMarker();
        } catch (\Throwable $e) {
            // ignore
        }

        if (Storage::disk('disk')->exists('lock')) {
            $templatePath = '\App';
            if (isset(app('settings')['setting']['template_path']) && app('settings')['setting']['template_path']) {
                $templatePath = app('settings')['setting']['template_path'];
            }
            if (isset(app('settings')['setting'])) {
                config([
                    'mail.default' => isset(app('settings')['setting']['mail_mailer']) ? app('settings')['setting']['mail_mailer'] : 'smtp',
                    'mail.mailers.smtp.host' => app('settings')['setting']['mail_host'],
                    'mail.mailers.smtp.port' => app('settings')['setting']['mail_port'],
                    'mail.mailers.smtp.encryption' => app('settings')['setting']['mail_encryption'],
                    'mail.mailers.smtp.username' => app('settings')['setting']['mail_username'],
                    'mail.mailers.smtp.password' => app('settings')['setting']['mail_password'],
                    'mail.from.address' => app('settings')['setting']['mail_from_address'],
                    'mail.from.name' => app('settings')['setting']['mail_from_name'],
                    'noCaptcha.secret' => app('settings')['setting']['nocaptcha_secret'],
                    'noCaptcha.sitekey' => app('settings')['setting']['nocaptcha_sitkey'],
                ]);
            }
            config([
                'app.productController' => $templatePath . '\Http\Controllers\ProductController',
                'app.newsController' => $templatePath . '\Http\Controllers\NewsController',
                'app.pageController' => $templatePath . '\Http\Controllers\PageController',
                'app.blogController' => $templatePath . '\Http\Controllers\BlogController',
                'app.downloadController' => $templatePath . '\Http\Controllers\DownloadController',
                'multilingual.banner' => [
                    'label' => 'banner列表',
                    'value' => [
                        'translateField' => [
                            [
                                'name' => 'name',
                                'label' => '标题',
                                'type' => 'text',
                                'require' => true
                            ],
                            [
                                'name' => 'alt',
                                'label' => 'alt属性',
                                'type' => 'text',
                                'require' => false
                            ],
                            [
                                'name' => 'description',
                                'label' => '描述',
                                'type' => 'text',
                                'require' => false
                            ],
                            [
                                'name' => 'button_text',
                                'label' => '按钮文案',
                                'type' => 'text',
                                'require' => false
                            ],
                        ],
                    ],
                    'model' => \App\Modules\Setting\Models\Banner::class
                ]
            ]);
            AcademyPaginator::injectIntoBuilder();
            $this->app->extend(\Astrotomic\Translatable\Locales::class, function ($app) use ($config, $translator) {
                return new \App\Extend\Locales($config, $translator);
            });
            Inquiry::observe(InquiryObserver::class);
        }
    }
}
