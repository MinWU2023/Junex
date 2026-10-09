<?php

namespace App\Http\Controllers;

use App\Services\GeoLiteService;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Product\Models\Product;
use App\Services\InquiryAttachmentService;
use Illuminate\Mail\Message;
use Illuminate\Http\Request;
use App\Services\TdkService;
use Illuminate\Support\Facades\Cache;
use App\Services\SeoTemplateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use App\Services\SettingService;
use App\Services\ProductService;
use App\Services\FrontMenuService;
use App\Services\FrontLocaleService;
use App\Services\WhyChooseService;
use App\Modules\Setting\Models\BrandSolution;
use App\Modules\Setting\Models\HomeProductCategory;
use App\Modules\Setting\Models\HotStyleTab;
use App\Modules\Setting\Models\ExcitingUpdate;
use App\Modules\Product\Models\ProductVideo;
use App\Modules\Admin\Models\User;
use App\Modules\User\Models\Customer;
use App\Modules\User\Models\CustomerPrefer;
use App\Modules\Blog\Models\Blog;

class HomeController extends Controller
{
    private $settingService;
    private $productService;
    private $frontMenuService;
    private $frontLocaleService;

    public function __construct(SettingService $settingService, ProductService $productService, FrontMenuService $frontMenuService, FrontLocaleService $frontLocaleService)
    {
        $this->settingService = $settingService;
        $this->productService = $productService;
        $this->frontMenuService = $frontMenuService;
        $this->frontLocaleService = $frontLocaleService;
    }

    public function index(Request $request, WhyChooseService $whyChooseService)
    {
        $setting = app('settings')['setting'];
        $banner = $this->getBannersByArea('Home');

        $heroBanners = $banner->map(function ($item) {
            return [
                'path' => front_image_url($item->path ?? ''),
                'path_mobile' => front_image_url($item->path_mobile ?? ''),
                'alt' => $item->alt ?? ($item->name ?? 'Banner'),
                'url' => !empty($item->url) ? $item->url : null,
                'title' => $item->name ?? '',
                'description' => $item->description ?? '',
                'button_text' => $item->button_text !== null && $item->button_text !== '' ? $item->button_text : 'Get More',
            ];
        });
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'home', (new SeoTemplateService())->getHome());
        $schemaOrgHtml = page_schema_org_html('home');

        $limit = (int)($setting->hot_product_list_num ?? 10);
        if ($limit <= 0) {
            $limit = 10;
        }
        if ($limit > 18) {
            $limit = 18;
        }

        $customerId = 0;
        $ip = $request->ip();
        if ($ip) {
            $customer = Customer::query()->where('ip', $ip)->orderByDesc('id')->first();
            if ($customer) {
                $customerId = (int)$customer->id;
            }
        }

        $favoriteIds = [];
        if ($customerId > 0) {
            $favoriteIds = CustomerPrefer::query()
                ->where('customer_id', $customerId)
                ->pluck('product_id')
                ->unique()
                ->values()
                ->all();
        }

        $markFavorites = function ($products) use ($favoriteIds) {
            $products->load('url');
            $products->transform(function ($product) use ($favoriteIds) {
                $product->is_favorite = in_array((int)$product->id, $favoriteIds) ? 1 : 0;
                return $product;
            });
            return $products;
        };

        $hotProducts = $markFavorites($this->productService->getHotProducts($limit));
        $newProducts = $markFavorites($this->productService->getNewProducts($limit));
        $recommendProducts = $markFavorites($this->productService->getRecommendProducts($limit));

        if ($newProducts->isEmpty()) {
            $newProducts = $hotProducts;
        }
        if ($recommendProducts->isEmpty()) {
            $recommendProducts = $hotProducts;
        }

        $productPool = [
            'new' => $newProducts,
            'hot' => $hotProducts,
            'recommend' => $recommendProducts,
        ];

        $hotStyleTabs = HotStyleTab::query()
            ->active()
            ->with([
                'translations',
                'products' => function ($q) {
                    $q->active()->with(['translations', 'productMainImage', 'url']);
                },
            ])
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->get()
            ->map(function ($tab) use ($productPool, $markFavorites, $limit) {
                $sourceType = (string)($tab->source_type ?: 'flag');
                if ($sourceType === 'category') {
                    $products = $tab->products instanceof \Illuminate\Support\Collection
                        ? $tab->products->take($limit)->values()
                        : collect($tab->products)->take($limit)->values();
                    $products = $markFavorites($products);
                } else {
                    $source = (string)($tab->product_source ?: 'hot');
                    $products = $productPool[$source] ?? $productPool['hot'];
                }

                return [
                    'key' => (string)($tab->tab_key ?: ('tab_' . $tab->id)),
                    'label' => (string)($tab->label ?: ''),
                    'products' => $products,
                ];
            })
            ->filter(function ($tab) {
                return trim((string)($tab['key'] ?? '')) !== ''
                    && trim((string)($tab['label'] ?? '')) !== '';
            })
            ->values()
            ->all();

        if (empty($hotStyleTabs)) {
            $hotStyleTabs = [
                ['key' => 'new', 'label' => 'New Arrivals', 'products' => $newProducts],
                ['key' => 'best', 'label' => 'Best Sellers', 'products' => $hotProducts],
                ['key' => 'bundles', 'label' => 'Bundles & Save', 'products' => $recommendProducts],
            ];
        }

        $fallbackBlogImage = front_webp_url('/front/imgs/index_rc_01.png');
        $mapBlogCard = static function ($blog, $fallbackBlogImage, $id = null) {
            if (!$blog) {
                return null;
            }
            $date = !empty($blog->customer_at)
                ? $blog->customer_at
                : ($blog->updated_at ?: $blog->created_at);

            $img = $blog->path
                ? front_image_url($blog->path)
                : $fallbackBlogImage;
            if ($img === '') {
                $img = $fallbackBlogImage;
            }
            $url = $blog->url ? ('/' . ltrim($blog->url->url, '/')) : '#';

            $dateText = '';
            if (!empty($date)) {
                try {
                    $dateText = \Illuminate\Support\Carbon::parse($date)->format('F d, Y');
                } catch (\Throwable $e) {
                    $dateText = is_string($date) ? $date : '';
                }
            }

            return [
                'id' => $id ?? $blog->id,
                'date' => $dateText,
                'title' => (string)($blog->name ?? ''),
                'image' => $img,
                'url' => $url,
                'button_text' => 'Learn More',
                'alt' => (string)($blog->name ?? 'Blog cover'),
            ];
        };

        $excitingUpdates = [];
        try {
            $excitingUpdates = ExcitingUpdate::query()
                ->active()
                ->with(['blog.translations', 'blog.url'])
                ->whereNotNull('blog_id')
                ->whereHas('blog', function ($q) {
                    $q->active();
                })
                ->orderByDesc('sort')
                ->orderByDesc('id')
                ->limit(12)
                ->get()
                ->map(function ($item) use ($mapBlogCard, $fallbackBlogImage) {
                    return $mapBlogCard($item->blog, $fallbackBlogImage, $item->id);
                })
                ->filter()
                ->values()
                ->all();
        } catch (\Throwable $e) {
            $excitingUpdates = [];
        }

        $videoRecommends = [];

        // 后台未配置精彩动态时，取最新发布的 8 篇博客
        if (empty($excitingUpdates)) {
            try {
                $query = Blog::query()
                    ->with(['translations', 'url'])
                    ->active();
                if (\Illuminate\Support\Facades\Schema::hasColumn('blogs', 'is_draft')) {
                    $query->where(function ($q) {
                        $q->where('is_draft', 0)->orWhereNull('is_draft');
                    });
                }
                $excitingUpdates = $query
                    ->orderByDesc('customer_at')
                    ->orderByDesc('id')
                    ->limit(8)
                    ->get()
                    ->map(function ($blog) use ($mapBlogCard, $fallbackBlogImage) {
                        return $mapBlogCard($blog, $fallbackBlogImage);
                    })
                    ->filter()
                    ->values()
                    ->all();
            } catch (\Throwable $e) {
                $excitingUpdates = [];
            }
        }

        $aboutUs = [
            'tree' => null,
            'media_image' => '',
            'title' => '',
            'description' => '',
            'features' => [],
            'button' => ['text' => '', 'url' => ''],
        ];

        $whyChoose = $whyChooseService->getWhyChoose();

        if (trim($aboutUs['media_image']) === '') {
            $aboutUs['media_image'] = 'front/imgs/video-play.png';
        }
        $aboutUs['media_image_url'] = front_image_url($aboutUs['media_image']);
        if (trim($aboutUs['title']) === '') {
            $aboutUs['title'] = 'Junex Active Wear Brands Solutions';
        }
        if (trim($aboutUs['description']) === '') {
            $aboutUs['description'] = 'Ectionwear Champions Sustainable Development In Yoga Apparel. Committed To Eco-Friendly Practices, We Fuse Style.';
        }
        if (empty($aboutUs['features'])) {
            $aboutUs['features'] = [
                [
                    'sign' => 'fallback_feature_01',
                    'name' => '卖点01',
                    'icon' => 'front/icons/icon001.png',
                    'text' => 'Environmentally Friendly Fabrics : Adopting The BLUESIGNcertified Fiber And Recycled Nylon Blend Technology, Dyeing With E.',
                ],
                [
                    'sign' => 'fallback_feature_02',
                    'name' => '卖点02',
                    'icon' => 'front/icons/icon001.png',
                    'text' => 'Environmentally Friendly Fabrics : 100% Biodegradable Soy And Packaging Truly Certified, Naturally Decomposing Within 60 Days.',
                ],
                [
                    'sign' => 'fallback_feature_03',
                    'name' => '卖点03',
                    'icon' => 'front/icons/icon001.png',
                    'text' => 'Reduce Fast Fashion : Adopting The BLUESIGN-Certified Fiber And Recycled Nylon Blend Technology, Dyeing With EU REAC.',
                ],
            ];
        }
        foreach ($aboutUs['features'] as $i => $row) {
            if (!is_array($row)) {
                continue;
            }
            $aboutUs['features'][$i]['icon_url'] = front_image_url((string)($row['icon'] ?? ''));
        }
        if (trim((string)($aboutUs['button']['text'] ?? '')) === '') {
            $aboutUs['button']['text'] = 'Learn More';
        }
        if (trim((string)($aboutUs['button']['url'] ?? '')) === '') {
            $aboutUs['button']['url'] = '#';
        }

        $normalizeImageUrl = static function (?string $src): string {
            return front_image_url($src);
        };

        $mapFeatures = static function ($features) use ($normalizeImageUrl): array {
            $out = [];
            if (!is_array($features)) {
                return $out;
            }
            foreach ($features as $i => $row) {
                $text = is_array($row) ? (string)($row['text'] ?? '') : (string)$row;
                $text = trim($text);
                if ($text === '') {
                    continue;
                }
                $icon = is_array($row) ? (string)($row['icon'] ?? '') : '';
                if ($icon === '') {
                    $icon = 'front/icons/icon001.png';
                }
                $iconUrl = $normalizeImageUrl($icon);
                $out[] = [
                    'sign' => 'feature_' . ($i + 1),
                    'name' => '',
                    'icon' => $icon,
                    'icon_url' => $iconUrl,
                    'text' => $text,
                ];
            }
            return $out;
        };

        $brandSolutionSlides = BrandSolution::query()
            ->active()
            ->with(['translations'])
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->get()
            ->map(function ($slide) use ($normalizeImageUrl, $mapFeatures) {
                $features = $mapFeatures($slide->features);
                return [
                    'media_image_url' => $normalizeImageUrl($slide->path),
                    'title' => (string)($slide->title ?? ''),
                    'description' => (string)($slide->description ?? ''),
                    'features' => $features,
                    'button' => [
                        'text' => (string)($slide->button_text ?? 'Learn More'),
                        'url' => (string)($slide->button_url ?: '#'),
                    ],
                ];
            })
            ->filter(function ($slide) {
                return trim((string)($slide['media_image_url'] ?? '')) !== ''
                    || trim((string)($slide['title'] ?? '')) !== '';
            })
            ->values()
            ->all();

        $productCategoryCards = HomeProductCategory::query()
            ->active()
            ->with(['translations'])
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->get()
            ->map(function ($item) use ($normalizeImageUrl) {
                return [
                    'image' => $normalizeImageUrl($item->path),
                    'alt' => (string)($item->alt ?? ''),
                    'title_html' => (string)($item->title ?? ''),
                    'description' => (string)($item->description ?? ''),
                    'url' => (string)($item->button_url ?: '#'),
                    'button_text' => (string)($item->button_text ?: 'Learn More'),
                ];
            })
            ->filter(function ($card) {
                return trim((string)($card['image'] ?? '')) !== ''
                    || trim(strip_tags((string)($card['title_html'] ?? ''))) !== '';
            })
            ->values()
            ->all();

        if (empty($productCategoryCards)) {
            $productCategoryCards = [
                [
                    'image' => front_webp_url('/front/imgs/jpcl001.png'),
                    'alt' => 'Recent new products',
                    'title_html' => '<span class="text-brand-red">Recent</span> New<br />Products',
                    'description' => 'Custom High Waist Yoga Leggings<br />Set Stretchy Breathable Active-',
                    'url' => '#',
                    'button_text' => 'Learn More',
                ],
                [
                    'image' => front_webp_url('/front/imgs/jpcl002.png'),
                    'alt' => 'Bestseller recommendation',
                    'title_html' => '<span class="text-brand-red">B</span>estseller<br />Recommendation',
                    'description' => 'Custom High Waist Yoga Leggings<br />Set Stretchy Breathable Active-',
                    'url' => '#',
                    'button_text' => 'Learn More',
                ],
                [
                    'image' => front_webp_url('/front/imgs/jpcl003.png'),
                    'alt' => 'Sewn series',
                    'title_html' => '<span class="text-brand-red">S</span>ewn Series',
                    'description' => 'Custom High Waist Yoga Leggings<br />Set Stretchy Breathable Active-',
                    'url' => '#',
                    'button_text' => 'Learn More',
                ],
                [
                    'image' => front_webp_url('/front/imgs/jpcl004.png'),
                    'alt' => 'Seamless shorts series',
                    'title_html' => '<span class="text-brand-red">S</span>eamless<br />Shorts Series',
                    'description' => 'Custom High Waist Yoga Leggings<br />Set Stretchy Breathable Active-',
                    'url' => '#',
                    'button_text' => 'Learn More',
                ],
            ];
        }

        if (!empty($brandSolutionSlides)) {
            $aboutUsSlides = $brandSolutionSlides;
            $first = $aboutUsSlides[0];
            $aboutUs['media_image_url'] = $first['media_image_url'];
            $aboutUs['title'] = $first['title'];
            $aboutUs['description'] = $first['description'];
            $aboutUs['features'] = $first['features'];
            $aboutUs['button'] = $first['button'];
        } else {
            $aboutUsSlides = [
                [
                    'media_image_url' => $aboutUs['media_image_url'],
                    'title' => $aboutUs['title'],
                    'description' => $aboutUs['description'],
                    'features' => $aboutUs['features'],
                    'button' => $aboutUs['button'],
                ],
            ];

            $aboutUsExtraImages = [
                front_webp_url('/front/imgs/aboutus-solu-left.png'),
                front_webp_url('/front/imgs/video-play.png'),
            ];
            foreach ($aboutUsExtraImages as $extraImage) {
                if ($extraImage === ($aboutUs['media_image_url'] ?? '')) {
                    continue;
                }
                $aboutUsSlides[] = [
                    'media_image_url' => $extraImage,
                    'title' => $aboutUs['title'],
                    'description' => $aboutUs['description'],
                    'features' => $aboutUs['features'],
                    'button' => $aboutUs['button'],
                ];
                if (count($aboutUsSlides) >= 3) {
                    break;
                }
            }
            while (count($aboutUsSlides) < 3) {
                $aboutUsSlides[] = $aboutUsSlides[0];
            }
        }

        $injectToView = (bool)$request->get('inject', true);

        if (!$injectToView) {
            return response()->json([
                'setting' => $setting,
                'banner' => $banner,
                'hero_banners' => $heroBanners,
                'hot_products' => $hotProducts,
                'about_us' => $aboutUs,
                'about_us_slides' => $aboutUsSlides,
                'tdk' => $tdk,
            ]);
        }

        $nav = $this->frontMenuService->build();
        $locales = $this->frontLocaleService->build();

        return view('front.index', compact('setting', 'banner', 'heroBanners', 'hotProducts', 'hotStyleTabs', 'excitingUpdates', 'videoRecommends', 'aboutUs', 'aboutUsSlides', 'whyChoose', 'productCategoryCards', 'injectToView', 'nav', 'locales', 'tdk', 'schemaOrgHtml'));

    }

    public function aboutUs(Request $request, WhyChooseService $whyChooseService)
    {
        $injectToView = (bool)$request->get('inject', true);
        $setting = app('settings')['setting'];
        $pageBanner = $this->getBannersByArea('About Us');
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'about-us');


        $data = [
            'injectToView' => $injectToView,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $this->buildBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'About Us', 'url' => null],
            ]),
            'tdk' => $tdk,
        ];

        $data['whyChoose'] = $whyChooseService->getWhyChoose();

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.about-us', $data);
    }

    public function contactUs(Request $request)
    {
        $injectToView = (bool)$request->get('inject', true);
        $setting = app('settings')['setting'];
        $pageBanner = $this->getBannersByArea('Contact Us');
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'contact-us');

        $data = [
            'injectToView' => $injectToView,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $this->buildBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Contact Us', 'url' => null],
            ]),
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.contact-us', $data);
    }

    public function customerServices(Request $request, WhyChooseService $whyChooseService)
    {
        $injectToView = (bool)$request->get('inject', true);
        $setting = app('settings')['setting'];
        $pageBanner = $this->getBannersByArea('Customer Services');
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'customer-services');

        $data = [
            'injectToView' => $injectToView,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $this->buildBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Customer Services', 'url' => null],
            ]),
            'tdk' => $tdk,
        ];

        $data['whyChoose'] = $whyChooseService->getWhyChoose();

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.customer-services', $data);
    }

    public function privacyPolicy(Request $request)
    {
        $injectToView = (bool)$request->get('inject', true);
        $setting = app('settings')['setting'];
        $pageBanner = $this->getBannersByArea('Common');
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'privacy-policy');

        $page = page_by_url_path('privacy-policy');
        $pageName = 'Privacy Policy';
        $pageContent = '';
        $createdLabel = '';

        if ($page) {
            $page->loadMissing(['translations']);
            $name = trim((string)($page->name ?? ''));
            if ($name !== '') {
                $pageName = $name;
            }
            $pageContent = front_html_prefer_webp((string)($page->content ?? ''));
            if ($page->created_at) {
                $createdLabel = date('F Y', strtotime($page->created_at));
            }
            if ($page->updated_at) {
                $createdLabel = date('F Y', strtotime($page->updated_at));
            }
        }

        $data = [
            'injectToView' => $injectToView,
            'pageBanner' => $pageBanner,
            'page' => $page,
            'pageName' => $pageName,
            'pageContent' => $pageContent,
            'createdLabel' => $createdLabel,
            'breadcrumbs' => $this->buildBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => $pageName, 'url' => null],
            ]),
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.privacy-policy', $data);
    }

    public function notFound(Request $request)
    {
        $injectToView = (bool)$request->get('inject', true);
        $setting = app('settings')['setting'];
        $pageBanner = $this->getBannersByArea('Common');
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'notfound');
        if (empty($tdk['title'])) {
            $siteName = $setting->site_name ?? config('app.name');
            $tdk = [
                'title' => '404 - ' . __('Page Not Found') . ' | ' . $siteName,
                'description' => __('The page you are looking for cannot be found.'),
                'keywords' => '',
            ];
        }

        $data = [
            'injectToView' => $injectToView,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $this->buildBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Not Found', 'url' => null],
            ]),
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data, 404);
        }

        return front_not_found_response('front.notfound', $data);
    }

    public function inquirySuccessFront(Request $request)
    {
        $payload = session('inquiry_success');
        if (!is_array($payload)) {
            return redirect('/');
        }

        $email = trim((string)($payload['email'] ?? ''));
        session()->forget('inquiry_success');
        $request->attributes->set('inquiry_success_email', $email);

        $injectToView = (bool)$request->get('inject', true);
        $setting = app('settings')['setting'];
        $pageBanner = $this->getBannersByArea('Inquiry');
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'inquirysuccess');

        $data = [
            'injectToView' => $injectToView,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $this->buildBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Inquiry', 'url' => null],
            ]),
            'tdk' => $tdk,
            'inquirySuccessEmail' => $email,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.inquirysuccess', $data);
    }

    public function inquiryStore(Request $request)
    {
        $injectToView = (bool)$request->get('inject', true);

        $data = $request->only([
            'title', 'content', 'email', 'tel', 'msg_name', 'msg_company', 'msg_country', 'source_url'
        ]);

        $data['ip'] = $request->ip();
        $data['client'] = $request->header('User-Agent');
        $data['add_date'] = date('Y-m-d H:i:s');

        $sourceUrl = trim((string)($data['source_url'] ?? ''));
        if ($sourceUrl === '') {
            $sourceUrl = $request->headers->get('referer') ?: $request->fullUrl();
        }
        if (!preg_match('#^https?://#i', $sourceUrl)) {
            $sourceUrl = $request->getSchemeAndHttpHost() . '/' . ltrim($sourceUrl, '/');
        }
        $data['source_url'] = $sourceUrl;

        try {
            DB::beginTransaction();

            $inquiry = Inquiry::create($data);

            // 处理多个关联产品 ID
            $productIds = $request->get('product_ids', []);
            if (!is_array($productIds)) {
                $productIds = explode(',', $productIds);
            }
            $productIds = array_filter(array_map('intval', $productIds));

            if (!empty($productIds)) {
                $syncData = [];
                foreach ($productIds as $pid) {
                    $syncData[$pid] = ['quantity' => 1];
                }
                $inquiry->products()->sync($syncData);
            }

            app(InquiryAttachmentService::class)->storeForInquiry($inquiry, null, $request);

            DB::commit();

            remember_inquiry_success((string)($inquiry->email ?? ''));

            if (!$injectToView) {
                return response()->json([
                    'success' => true,
                    'inquiry' => $inquiry->load('products'),
                    'injectToView' => $injectToView,
                    'redirect' => route('inquirysuccess'),
                ]);
            }

            return redirect()->route('inquirysuccess');

        } catch (\Exception $e) {
            DB::rollBack();
            if (!$injectToView) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['msg' => $e->getMessage()])->withInput();
        }
    }

    public function inquiryPopupStore(Request $request, GeoLiteService $geoLiteService)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'tel' => 'nullable|string|max:255',
            'content' => 'required|string',
            'source_url' => 'nullable|string|max:2048',
        ]);

        $ip = $request->ip();
        $location = '';
        try {
            $location = $geoLiteService->getLocationByIp($ip);
        } catch (\Throwable $e) {
            $location = '';
        }

        $client = ismobile() ? 'mobile' : 'pc';

        $sourceUrl = trim((string)($validated['source_url'] ?? ''));
        if ($sourceUrl === '') {
            $sourceUrl = $request->fullUrl();
        }
        if (!preg_match('#^https?://#i', $sourceUrl)) {
            $sourceUrl = $request->getSchemeAndHttpHost() . '/' . ltrim($sourceUrl, '/');
        }

        try {
            DB::beginTransaction();

            $inquiry = Inquiry::create([
                'title' => 'Leave A Message',
                'content' => $validated['content'],
                'email' => $validated['email'],
                'tel' => $validated['tel'] ?? '',
                'ip' => $ip,
                'location' => $location,
                'source_url' => $sourceUrl,
                'client' => $client,
                'add_date' => (int)date('Ym'),
            ]);

            $allowAdminIds = User::ALLOW_ADMIN_ID;
            if (!is_array($allowAdminIds)) {
                $allowAdminIds = [];
            }
            if (!empty($allowAdminIds)) {
                $syncData = [];
                foreach ($allowAdminIds as $adminId) {
                    $syncData[(int)$adminId] = ['is_del' => 0];
                }
                if (!empty($syncData)) {
                    $inquiry->users()->syncWithoutDetaching($syncData);
                }
            }

            DB::commit();

            $setting = app('settings')['setting'];
            $addresseeRaw = trim((string)($setting->mail_addressee ?? ''));
            if ($addresseeRaw !== '' && !empty($setting->mail_mailer)) {
                try {
                    $addressees = array_values(array_filter(array_map('trim', explode(',', str_replace('，', ',', $addresseeRaw)))));
                    if (!empty($addressees)) {
                        $to = array_shift($addressees);
                        $cc = $addressees;

                        $html = View::make('emails.inquiry_popup_notification', [
                            'inquiry' => $inquiry,
                            'products' => [],
                        ])->render();

                        $fromAddress = trim((string)($setting->mail_from_address ?? ''));
                        if ($fromAddress === '') {
                            $fromAddress = (string)config('mail.from.address');
                        }
                        $fromName = trim((string)($setting->mail_from_name ?? ''));
                        if ($fromName === '') {
                            $fromName = (string)config('mail.from.name');
                        }

                        Mail::html($html, function (Message $message) use ($to, $cc, $inquiry, $fromAddress, $fromName) {
                            $message->to($to);
                            if (!empty($cc)) {
                                $message->cc($cc);
                            }
                            if ($fromAddress) {
                                $message->from($fromAddress, $fromName ?: null);
                            }
                            $message->replyTo($inquiry->email);
                            $message->subject('New Inquiry - Leave A Message');
                        });
                    }
                } catch (\Throwable $e) {
                    Log::error('api/inquiry-popup mail send failed', [
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'inquiry_id' => $inquiry->id,
                    ]);
                }
            }

            remember_inquiry_success((string)($inquiry->email ?? ''));

            return response()->json([
                'success' => true,
                'id' => $inquiry->id,
                'redirect' => route('inquirysuccess'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('api/inquiry-popup failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json([
                'success' => false,
                'message' => (bool)config('app.debug') ? $e->getMessage() : 'Submit failed',
            ], 500);
        }
    }

    public function askUsInquiryStore(Request $request, GeoLiteService $geoLiteService)
    {
        $validated = $request->validate(array_merge([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tel' => 'nullable|string|max:255',
            'content' => 'required|string',
            'quantity' => 'nullable|string|max:255',
            'source_url' => 'nullable|string|max:2048',
            'product_id' => 'nullable|integer|min:0',
        ], InquiryAttachmentService::validationRules()));

        $ip = $request->ip();
        $location = '';
        try {
            $location = $geoLiteService->getLocationByIp($ip);
        } catch (\Throwable $e) {
            $location = '';
        }

        $client = ismobile() ? 'mobile' : 'pc';

        $sourceUrl = trim((string)($validated['source_url'] ?? ''));
        if ($sourceUrl === '') {
            $sourceUrl = $request->fullUrl();
        }
        if (!preg_match('#^https?://#i', $sourceUrl)) {
            $sourceUrl = $request->getSchemeAndHttpHost() . '/' . ltrim($sourceUrl, '/');
        }

        $productId = (int)($validated['product_id'] ?? 0);
        if ($productId < 0) {
            $productId = 0;
        }

        $quantity = trim((string)($validated['quantity'] ?? ''));
        $content = (string)$validated['content'];

        try {
            DB::beginTransaction();

            $inquiry = Inquiry::create([
                'title' => trim((string)$validated['name']) . ' - Ask Us',
                'content' => $content,
                'quantity' => $quantity !== '' ? mb_substr($quantity, 0, 255) : null,
                'msg_name' => trim((string)$validated['name']),
                'email' => $validated['email'],
                'tel' => trim((string)($validated['tel'] ?? '')),
                'ip' => $ip,
                'location' => $location,
                'source_url' => $sourceUrl,
                'client' => $client,
                'add_date' => (int)date('Ym'),
            ]);

            if ($productId > 0) {
                $productExists = Product::query()->where('id', $productId)->exists();
                if ($productExists) {
                    // quantity 为字符串区间（如 0~100），原样入库，不再强转 int
                    $pivotQty = $quantity !== '' ? mb_substr($quantity, 0, 255) : '1';
                    $inquiry->products()->syncWithoutDetaching([
                        $productId => ['quantity' => $pivotQty],
                    ]);
                }
            }

            app(InquiryAttachmentService::class)->storeForInquiry($inquiry, null, $request);

            DB::commit();

            $setting = app('settings')['setting'];
            $addresseeRaw = trim((string)($setting->mail_addressee ?? ''));
            if ($addresseeRaw !== '' && !empty($setting->mail_mailer)) {
                try {
                    $addressees = array_values(array_filter(array_map('trim', explode(',', str_replace('，', ',', $addresseeRaw)))));
                    if (!empty($addressees)) {
                        $to = array_shift($addressees);
                        $cc = $addressees;

                        $html = View::make('emails.ask_us_inquiry_notification', [
                            'inquiry' => $inquiry,
                            'quantity' => $quantity,
                            'name' => $validated['name'],
                        ])->render();

                        $fromAddress = trim((string)($setting->mail_from_address ?? ''));
                        if ($fromAddress === '') {
                            $fromAddress = (string)config('mail.from.address');
                        }
                        $fromName = trim((string)($setting->mail_from_name ?? ''));
                        if ($fromName === '') {
                            $fromName = (string)config('mail.from.name');
                        }

                        Mail::html($html, function (Message $message) use ($to, $cc, $inquiry, $fromAddress, $fromName) {
                            $message->to($to);
                            if (!empty($cc)) {
                                $message->cc($cc);
                            }
                            if ($fromAddress) {
                                $message->from($fromAddress, $fromName ?: null);
                            }
                            $message->replyTo($inquiry->email);
                            $message->subject('New Inquiry - Ask Us');
                        });
                    }
                } catch (\Throwable $e) {
                    Log::error('api/ask-us-inquiry mail send failed', [
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'inquiry_id' => $inquiry->id,
                    ]);
                }
            }

            remember_inquiry_success((string)($inquiry->email ?? ''));

            return response()->json([
                'success' => true,
                'id' => $inquiry->id,
                'redirect' => route('inquirysuccess'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('api/ask-us-inquiry failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json([
                'success' => false,
                'message' => (bool)config('app.debug') ? $e->getMessage() : 'Submit failed',
            ], 500);
        }
    }
}
