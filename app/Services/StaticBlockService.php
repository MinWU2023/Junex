<?php

namespace App\Services;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyInquiryController;
use App\Http\Controllers\NewStyleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\VideoController;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Page\Models\Page;
use App\Modules\Page\Models\StaticBlock;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductTag;
use App\Modules\Url\Models\Url;
use Illuminate\Support\Facades\Schema;
use App\Services\WebpImageService;

class StaticBlockService
{
    /** @var array<string, string> */
    private array $requestCache = [];

    /** @var int[]|null */
    private ?array $currentPageIds = null;

    /** @var string[]|null */
    private ?array $currentPageKeys = null;

    public function html(string $sign): string
    {
        $sign = trim($sign);
        if ($sign === '') {
            return '';
        }

        if (array_key_exists($sign, $this->requestCache)) {
            return $this->requestCache[$sign];
        }

        $html = '';

        try {
            $this->resolveCurrentAssociation();
            $currentPageIds = $this->currentPageIds ?? [];
            $currentPageKeys = $this->currentPageKeys ?? [];
            $isHome = $this->isHomePage($currentPageKeys);

            // 首页只用 ask_us_home；其他页面只用 ask_us（防止 CMS 关联错乱互相串）
            if ($sign === 'ask_us_home' && !$isHome) {
                $this->requestCache[$sign] = '';
                return '';
            }
            if ($sign === 'ask_us' && $isHome) {
                $this->requestCache[$sign] = '';
                return '';
            }

            // Keep {!! static_block_html() !!} in templates; hide output when the current page is not associated.
            if ($currentPageIds === [] && $currentPageKeys === []) {
                $this->requestCache[$sign] = '';
                return '';
            }

            $query = StaticBlock::query()
                ->active()
                ->where('sign', $sign)
                ->where(function ($q) use ($currentPageIds, $currentPageKeys) {
                    $hasReal = $currentPageIds !== [];
                    $hasVirtual = $currentPageKeys !== [] && Schema::hasTable('static_block_page_keys');

                    if ($hasReal) {
                        $q->whereHas('pages', function ($pageQuery) use ($currentPageIds) {
                            $pageQuery->whereIn('pages.id', $currentPageIds);
                        });
                    }

                    if ($hasVirtual) {
                        $method = $hasReal ? 'orWhereHas' : 'whereHas';
                        $q->{$method}('pageKeys', function ($keyQuery) use ($currentPageKeys) {
                            $keyQuery->whereIn('page_key', $currentPageKeys);
                        });
                    }

                    // No association context that can match page_keys table: still require real pages.
                    if (!$hasReal && !$hasVirtual) {
                        $q->whereRaw('1 = 0');
                    }
                });

            $block = $query->with(['translations'])->first();

            if ($block) {
                $locale = (string)app()->getLocale();
                $fallback = (string)(config('translatable.fallback_locale') ?: config('app.fallback_locale', 'en'));

                $content = null;
                $translation = $block->translate($locale, false);
                if ($translation && trim((string)($translation->content ?? '')) !== '') {
                    $content = (string)$translation->content;
                }

                if ($content === null && $fallback !== '' && $fallback !== $locale) {
                    $fallbackTranslation = $block->translate($fallback, false);
                    if ($fallbackTranslation && trim((string)($fallbackTranslation->content ?? '')) !== '') {
                        $content = (string)$fallbackTranslation->content;
                    }
                }

                if ($content === null) {
                    $content = (string)($block->content ?? '');
                }

                $html = $this->processPlaceholders($content, $sign);
                if ($sign === 'contact_us' && ContactUsBlockService::isCopyMissing($html)) {
                    $html = $this->processPlaceholders(ContactUsBlockService::renderFullHtml(), $sign);
                }
                if (in_array($sign, ['ask_us', 'ask_us_home'], true) && $this->isAskUsFormMissing($html)) {
                    $html = $this->processPlaceholders($this->renderAskUsTemplate($sign), $sign);
                }
                if ($this->isEmptyShellHtml($html)) {
                    $html = '';
                }
            }

            // contact-us page: if block missing/unassociated, still render from template
            if ($html === '' && $sign === 'contact_us') {
                $keys = $this->currentPageKeys ?? [];
                if (in_array('contact-us', $keys, true)) {
                    $html = $this->processPlaceholders(ContactUsBlockService::renderFullHtml(), $sign);
                }
            }

            // 首页：关联缺失时仍渲染 ask_us_home
            if ($html === '' && $sign === 'ask_us_home' && $isHome) {
                $html = $this->processPlaceholders($this->renderAskUsTemplate('ask_us_home'), $sign);
            }

            // 非首页常用页：关联缺失时仍渲染 ask_us
            if ($html === '' && $sign === 'ask_us' && !$isHome) {
                $keys = $this->currentPageKeys ?? [];
                $askUsKeys = [
                    'products', 'product-category', 'product-tag', 'product',
                    'about-us', 'customer-services', 'search', 'reviews',
                ];
                if (array_intersect($keys, $askUsKeys) !== []) {
                    $html = $this->processPlaceholders($this->renderAskUsTemplate('ask_us'), $sign);
                }
            }
        } catch (\Throwable $e) {
            $html = '';
        }

        if ($html !== '') {
            $html = WebpImageService::rewriteHtmlImagesToWebp($html);
        }

        $this->requestCache[$sign] = $html;

        return $html;
    }

    /**
     * 是否首页（仅 home，不含其它路由误带的 path）。
     *
     * @param string[] $pageKeys
     */
    private function isHomePage(array $pageKeys): bool
    {
        if (in_array('home', $pageKeys, true)) {
            return true;
        }

        $path = trim((string)(function_exists('request') ? request()->path() : ''), '/');
        return $path === '' || $path === '/';
    }

    /**
     * ask_us / ask_us_home: DB HTML missing the inquiry form → re-render from blade template.
     */
    private function isAskUsFormMissing(string $html): bool
    {
        $html = trim($html);
        if ($html === '' || $this->isEmptyShellHtml($html)) {
            return true;
        }
        if (!preg_match('/<form\b/i', $html)) {
            return true;
        }
        if (!preg_match('/\bname\s*=\s*["\']name["\']/i', $html)) {
            return true;
        }
        // 附件上传区缺失时强制用模板重渲染（历史静态块 HTML 常缺少回显列表）
        if (!preg_match('/js-inquiry-attachment/i', $html)) {
            return true;
        }
        // quantity 仍是纯数字选项时，刷新为字符串区间（如 0~100）
        if (preg_match('/name\s*=\s*["\']quantity["\']/i', $html)
            && !preg_match('/0\s*~\s*100|0~100/i', $html)
        ) {
            return true;
        }

        return false;
    }

    private function renderAskUsTemplate(string $sign): string
    {
        $view = $sign === 'ask_us_home'
            ? 'static_block_templates.ask_us_home'
            : 'static_block_templates.ask_us';

        try {
            return (string)view($view, ['askUs' => []])->render();
        } catch (\Throwable $e) {
            return '';
        }
    }

    /**
     * Hide CMS shells that only retain layout/padding (no real text / media).
     * Prevents large blank white gaps from empty static blocks.
     */
    private function isEmptyShellHtml(string $html): bool
    {
        $html = trim($html);
        if ($html === '') {
            return true;
        }

        $text = trim(html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;
        // Ignore leftover placeholder tokens
        $text = trim(str_replace(
            ['__SECTION_TITLE__', '__SECTION_SUBTITLE__', '__CSRF_TOKEN__', '__CSRF_FIELD__', '{{ sns_icons }}', '{{sns_icons}}', '__SNS_ICONS__'],
            '',
            $text
        ));

        if (mb_strlen($text) >= 20) {
            return false;
        }

        // Real image / background media counts as content
        if (preg_match('/<img\b[^>]*\bsrc=(["\'])(?!\s*\1)(?!["\'])[^"\']+\1/i', $html)) {
            return false;
        }
        if (preg_match('/background-image\s*:\s*url\(\s*[\'"]?(?!["\'\)]|\s*\))[^)\'"]+/i', $html)) {
            return false;
        }

        return true;
    }

    private function processPlaceholders(string $html, string $sign = ''): string
    {
        if ($html === '') {
            return '';
        }

        if (str_contains($html, '__CSRF_TOKEN__')) {
            $html = str_replace('__CSRF_TOKEN__', csrf_token(), $html);
        }

        if (str_contains($html, '__CSRF_FIELD__')) {
            $html = str_replace('__CSRF_FIELD__', (string)csrf_field(), $html);
        }

        if (str_contains($html, '{{ email }}') || str_contains($html, '{{email}}')) {
            $email = e((string)request()->attributes->get('inquiry_success_email', ''));
            $html = str_replace(['{{ email }}', '{{email}}'], $email, $html);
        }

        if (
            str_contains($html, '{{ sns_icons }}')
            || str_contains($html, '{{sns_icons}}')
            || str_contains($html, '{{ SNS_ICONS }}')
            || str_contains($html, '__SNS_ICONS__')
            || str_contains($html, '&#123;&#123; sns_icons &#125;&#125;')
            || str_contains($html, '&#123;&#123;sns_icons&#125;&#125;')
        ) {
            $snsHtml = function_exists('sns_icons_html')
                ? sns_icons_html('contact')
                : '';
            $html = str_replace(
                [
                    '{{ sns_icons }}',
                    '{{sns_icons}}',
                    '{{ SNS_ICONS }}',
                    '__SNS_ICONS__',
                    '&#123;&#123; sns_icons &#125;&#125;',
                    '&#123;&#123;sns_icons&#125;&#125;',
                ],
                $snsHtml,
                $html
            );
        }

        if (str_contains($html, '<form') && !str_contains($html, 'js-inquiry-source-url')) {
            $html = preg_replace(
                '/(<form\b[^>]*>)/i',
                '$1<input type="hidden" name="source_url" value="" class="js-inquiry-source-url" />',
                $html,
                1
            ) ?? $html;
        }

        $needsSection = str_contains($html, '__SECTION_TITLE__')
            || str_contains($html, '__SECTION_SUBTITLE__')
            || in_array($sign, ['custom_serrvices', 'ask_us_home'], true);

        if ($needsSection && $sign !== '') {
            try {
                $section = app(\App\Services\SectionTitleService::class)->get($sign);
                $title = (string)($section['title'] ?? '');
                $subtitle = (string)($section['subtitle'] ?? '');

                if (str_contains($html, '__SECTION_TITLE__') || str_contains($html, '__SECTION_SUBTITLE__')) {
                    $html = str_replace('__SECTION_TITLE__', e($title), $html);
                    $html = str_replace('__SECTION_SUBTITLE__', e($subtitle), $html);
                } else {
                    // Inject into existing baked-in header markup
                    $html = preg_replace(
                        '/(<h2\b[^>]*>)(.*?)(<\/h2>)/is',
                        '${1}' . e($title) . '${3}',
                        $html,
                        1
                    ) ?? $html;

                    $html = preg_replace(
                        '/(<div class="mx-auto mt-3[^"]*"[^>]*><\/div>\s*<p\b[^>]*>)(.*?)(<\/p>)/is',
                        '${1}' . e($subtitle) . '${3}',
                        $html,
                        1
                    ) ?? $html;
                }
            } catch (\Throwable $e) {
                // keep original html
            }
        }

        if ($sign === 'contact_us' || str_contains($html, '__CONTACT_PHONES_HTML__')) {
            $html = ContactUsBlockService::applyContactLinkPlaceholders($html);
        }

        // CONTACT US (#ask-us) 锚点：库内 HTML 可能缺 id，渲染时补上
        if (in_array($sign, ['ask_us', 'ask_us_home'], true)) {
            $html = $this->ensureAskUsAnchor($html);
        }

        return $this->normalizeFormRequiredMarks($html);
    }

    private function ensureAskUsAnchor(string $html): string
    {
        if ($html === '' || !preg_match('/<section\b/i', $html)) {
            return $html;
        }

        if (!preg_match('/\bid\s*=\s*["\']ask-us["\']/i', $html)) {
            $html = preg_replace(
                '/<section\b([^>]*)>/i',
                '<section id="ask-us"$1>',
                $html,
                1
            ) ?? $html;
        }

        if (!preg_match('/\bscroll-mt-20\b/', $html)) {
            $html = preg_replace(
                '/(<section\b[^>]*\bclass=")([^"]*)(")/i',
                '$1$2 scroll-mt-20$3',
                $html,
                1
            ) ?? $html;
        }

        return $html;
    }

    private function normalizeFormRequiredMarks(string $html): string
    {
        if ($html === '' || !str_contains($html, '<form')) {
            return $html;
        }

        $html = preg_replace(
            '/<span class="text-themeBg-d">\s*\*\s*<\/span>/',
            '<span class="form-required-mark">*</span>',
            $html
        ) ?? $html;

        // tel 不在必填列表：联系我们等静态块 Label 无 * 时不应被运行时强制追加
        $requiredFields = ['name', 'email', 'content'];
        foreach ($requiredFields as $field) {
            $html = preg_replace_callback(
                '/(<label\b(?![^>]*\bform-field-label\b)[^>]*class=")([^"]*)(">)(.*?)(<\/label>\s*(?:<div[^>]*>\s*)?(?:<input\b|<textarea\b)[^>]*\bname="' . preg_quote($field, '/') . '")/is',
                static function (array $m): string {
                    if (str_contains($m[4], 'form-required-mark')) {
                        return $m[0];
                    }
                    return $m[1] . 'form-field-label ' . $m[2] . $m[3] . $m[4] . '<span class="form-required-mark">*</span>' . $m[5];
                },
                $html
            ) ?? $html;

            $html = preg_replace_callback(
                '/(<label\b[^>]*>)(.*?)(<\/label>\s*(?:<div[^>]*>\s*)?(?:<input\b|<textarea\b)[^>]*\bname="' . preg_quote($field, '/') . '")/is',
                static function (array $m): string {
                    if (str_contains($m[2], 'form-required-mark')) {
                        return $m[0];
                    }
                    return $m[1] . $m[2] . '<span class="form-required-mark">*</span>' . $m[3];
                },
                $html
            ) ?? $html;

            $html = preg_replace_callback(
                '/(<span class="([^"]*text-f14[^"]*)">)(.*?)(<\/span>\s*<(?:input|textarea)\b[^>]*\bname="' . preg_quote($field, '/') . '")/is',
                static function (array $m): string {
                    if (str_contains($m[3], 'form-required-mark')) {
                        return $m[0];
                    }
                    $class = str_contains($m[2], 'form-field-label')
                        ? $m[2]
                        : 'form-field-label ' . $m[2];
                    return '<span class="' . $class . '">' . $m[3] . '<span class="form-required-mark">*</span></span>' . $m[4];
                },
                $html
            ) ?? $html;
        }

        // contact_us 等：Tel 为可选项，去掉库内旧 HTML 残留的必填星号
        $stripTelStar = static function (string $inner): string {
            $inner = preg_replace(
                '/\s*<span class="(?:form-required-mark|text-themeBg-d)"[^>]*>\s*\*\s*<\/span>/i',
                '',
                $inner
            ) ?? $inner;
            $inner = preg_replace('/\s*\*\s*(?=$)/u', '', $inner) ?? $inner;

            return $inner;
        };

        $html = preg_replace_callback(
            '/(<label\b[^>]*>)(.*?)(<\/label>\s*(?:<div[^>]*>\s*)?<input\b[^>]*\bname="tel")/is',
            static function (array $m) use ($stripTelStar): string {
                return $m[1] . $stripTelStar($m[2]) . $m[3];
            },
            $html
        ) ?? $html;

        $html = preg_replace_callback(
            '/(<span class="[^"]*form-field-label[^"]*"[^>]*>)(.*?)(<\/span>\s*<input\b[^>]*\bname="tel")/is',
            static function (array $m) use ($stripTelStar): string {
                return $m[1] . $stripTelStar($m[2]) . $m[3];
            },
            $html
        ) ?? $html;

        return $html;
    }

    /**
     * Resolve current request into CMS page IDs and virtual page keys.
     */
    private function resolveCurrentAssociation(): void
    {
        if ($this->currentPageIds !== null && $this->currentPageKeys !== null) {
            return;
        }

        $ids = [];
        $keys = [];

        $route = function_exists('request') ? request()->route() : null;

        try {
            $urlable = null;
            try {
                if ($route) {
                    $urlable = Url::getUrlable(true);
                }
            } catch (\Throwable $e) {
                $urlable = null;
            }

            // customUrl 分发时 request()->route() 可能是闭包路由，action['model'] 为空；
            // 回退按当前 path 查 urls 表，保证分类/产品等虚拟 page_key 能解析到。
            if (!$urlable && function_exists('request')) {
                $pathForUrl = trim((string)request()->path(), '/');
                if ($pathForUrl !== '' && $pathForUrl !== '/') {
                    try {
                        $urlRow = Url::query()
                            ->where('url', $pathForUrl)
                            ->orWhere('url', '/' . $pathForUrl)
                            ->first();
                        if ($urlRow && $urlRow->urlable) {
                            $urlable = $urlRow->urlable;
                        }
                    } catch (\Throwable $e) {
                        // ignore url lookup failures
                    }
                }
            }

            if ($urlable instanceof Page && (int)$urlable->id > 0) {
                $ids[] = (int)$urlable->id;
                $pageKey = trim((string)($urlable->url_key ?? ''), '/');
                if ($pageKey !== '') {
                    $keys[] = $pageKey;
                }
            } elseif ($urlable instanceof Product) {
                $keys[] = 'product';
                $keys[] = 'products';
            } elseif ($urlable instanceof ProductCategory) {
                $keys[] = 'product-category';
                $keys[] = 'products';
                $catId = (int)$urlable->id;
                if ($catId > 0) {
                    $keys[] = 'pcat:' . $catId;
                }
                // 一级分类关联：当前分类及其祖先都带上 pcat:{rootId}
                try {
                    $walker = $urlable;
                    $guard = 0;
                    while ($walker && $guard < 30) {
                        $parentId = (int)($walker->parent_id ?? 0);
                        if ($parentId <= 0) {
                            $keys[] = 'pcat:' . (int)$walker->id;
                            break;
                        }
                        if (!$walker->relationLoaded('parent')) {
                            $walker->load('parent');
                        }
                        $walker = $walker->parent;
                        $guard++;
                    }
                } catch (\Throwable $e) {
                    // ignore tree walk failures
                }
            } elseif ($urlable instanceof ProductTag) {
                $keys[] = 'product-tag';
                $keys[] = 'products';
            } elseif ($urlable instanceof Blog || $urlable instanceof BlogCategory || $urlable instanceof BlogTag) {
                $keys[] = 'blogs';
            }
        } catch (\Throwable $e) {
            // no urlable on this route
        }

        $path = trim((string)(function_exists('request') ? request()->path() : ''), '/');
        $keys[] = ($path === '' || $path === '/') ? 'home' : $path;

        $action = '';
        $method = '';
        try {
            $action = (string)($route ? $route->getActionName() : '');
            $method = (string)($route ? $route->getActionMethod() : '');
        } catch (\Throwable $e) {
            $action = '';
            $method = '';
        }

        $controllerKeys = [
            ProductController::class => 'products',
            SearchController::class => 'search',
            ReviewController::class => 'reviews',
            BlogController::class => 'blogs',
            FaqController::class => 'faqs',
            NewStyleController::class => 'newstyle',
            MyInquiryController::class => 'myinquirys',
            VideoController::class => 'videos',
        ];
        foreach ($controllerKeys as $class => $key) {
            if ($action !== '' && str_starts_with($action, $class)) {
                $keys[] = $key;
                if ($class === ProductController::class) {
                    $productMethodKeys = [
                        'index' => 'products',
                        'show' => 'product',
                        'category' => 'product-category',
                        'tag' => 'product-tag',
                    ];
                    if (isset($productMethodKeys[$method])) {
                        $keys[] = $productMethodKeys[$method];
                    }
                }
                break;
            }
        }

        if ($action !== '' && str_starts_with($action, HomeController::class)) {
            $homeKeys = [
                'index' => 'home',
                'aboutUs' => 'about-us',
                'contactUs' => 'contact-us',
                'customerServices' => 'customer-services',
                'privacyPolicy' => 'privacy-policy',
                'notFound' => 'notfound',
                'inquirySuccessFront' => 'inquirysuccess',
            ];
            if (isset($homeKeys[$method])) {
                $keys[] = $homeKeys[$method];
            }
        } elseif ($action !== '' && str_starts_with($action, CustomerAuthController::class)) {
            $authKeys = [
                'showLogin' => 'login',
                'showRegister' => 'register',
                'showForget' => 'forget',
            ];
            if (isset($authKeys[$method])) {
                $keys[] = $authKeys[$method];
            }
        }

        $keys = array_values(array_unique(array_filter(array_map(function ($key) {
            return trim((string)$key, '/');
        }, $keys))));

        if ($keys !== []) {
            try {
                // Do not require pages.active / is_temp: CMS rows are often disabled or marked temp
                // for front routing, but still used for static-block association / SEO matching.
                $pages = Page::query()
                    ->where(function ($q) use ($keys) {
                        $q->whereIn('url_key', $keys);
                        foreach ($keys as $key) {
                            $q->orWhere('url_key', '/' . $key);
                        }
                    })
                    ->get(['id']);
                foreach ($pages as $page) {
                    $ids[] = (int)$page->id;
                }
            } catch (\Throwable $e) {
                // keep ids collected from urlable
            }
        }

        $this->currentPageIds = array_values(array_unique(array_filter($ids, function ($id) {
            return $id > 0;
        })));
        $this->currentPageKeys = $keys;
    }
}
