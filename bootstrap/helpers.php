<?php



if (!function_exists('whatsapp_link')) {
    function whatsapp_link($phone)
    {
       if(ismobile()) {
        return "whatsapp://send?phone={$phone}";
       } else {
        return "https://web.whatsapp.com/send?phone={$phone}&text=Hello";
       }
    }
}

if (!function_exists('days_diff')) {
    function days_diff($date)
    {

        // 设置时区（可选）
        date_default_timezone_set('Asia/Shanghai');

        // 设置目标日期
        $targetDate = new DateTime($date);

        // 当前日期
        $today = new DateTime();

        // 获取时间戳
        $targetTimestamp = $targetDate->getTimestamp();
        $todayTimestamp = $today->getTimestamp();

        // 计算天数差（保留正负）
        $daysDifference = round(($targetTimestamp - $todayTimestamp) / (60 * 60 * 24));
        return intval($daysDifference);
    }
}

if (!function_exists('in_array_i')) {
    function in_array_i($needle, $haystack)
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
}

if (!function_exists('custom_multisort')) {
    function custom_multisort($data, $key)
    {
        // 提取 'age' 列
        if ($data) {
            $keys = array_column($data, $key);
            // 按照 'age' 升序排序
            array_multisort($keys, SORT_DESC, $data);
        }
        return  $data;
    }
}


if (!function_exists('str_insert')) {
    function getMonth($date, $monthsAgo)
    {
        // 将给定的日期转换为时间戳
        $timestamp = strtotime($date);
        // 计算指定月数之前的日期
        $previousTimestamp = strtotime("first day of -{$monthsAgo} month", $timestamp);
        // 返回 YYYY-MM 格式的字符串
        return date('Y-m', $previousTimestamp);
    }
}

if (!function_exists('str_insert')) {
    //合并多个空格为一个
    function str_insert($original, $insert, $position)
    {
        return substr($original, 0, $position) . $insert . substr($original, $position);
    }
}


if (!function_exists('last_month')) {
    //合并多个空格为一个
    function last_month($specifiedDate)
    {
        $specifiedDate = date("Y-m-d", strtotime($specifiedDate)); // 替换成你的指定日期
        // 创建 DateTime 对象，设置为指定日期
        $date = new DateTime($specifiedDate);
        // 增加一个月
        $date->add(new DateInterval('P1M')); // P1M 表示增加一个月
        // 获取下个月的日期
        $nextMonth = $date->format('Y-m');
        return $nextMonth;
    }
}

if (!function_exists('merge_spaces')) {
    //合并多个空格为一个
    function merge_spaces($string)
    {
        return preg_replace("/\s(?=\s)/", "\\1", trim($string));
    }
}

if (!function_exists('ismobile')) {
    function ismobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }

        //此条摘自TPM智能切换模板引擎，适合TPM开发
        if (isset($_SERVER['HTTP_CLIENT']) && 'PhoneClient' == $_SERVER['HTTP_CLIENT']) {
            return true;
        }

        //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset($_SERVER['HTTP_VIA'])) //找不到为flase,否则为true
        {
            return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
        }

        //判断手机发送的客户端标志,兼容性有待提高
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array(
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile',
            );
            //从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        //协议法，因为有可能不准确，放到最后判断
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }
}


if (!function_exists('GetUserIP')) {

    function GetUserIP()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //为了兼容百度的CDN，所以转成数组
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return $arr[0];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}

if (!function_exists('is_windows')) {
    function is_windows()
    {
        return PATH_SEPARATOR == ';' ? true : false;
    }
}


if (!function_exists('fu_null_val')) {
    function fu_null_val($date)
    {
        for ($i = 1; $i < 13; $i++) {
            if (!isset($date[$i])) {
                $date[$i] = 0;
            }
        }
        return $date;
    }
}
if (!function_exists('setEnvironmentValue')) {
    function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $oldValue = env($envKey);
        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }
}


if (!function_exists('before_day')) {
    function before_day($date)
    {
        $time = strtotime($date);
        return (int)ceil(($time - time()) / (60 * 60 * 24));
    }
}

if (!function_exists('type_to_title')) {
    function type_to_title($type)
    {
        $data = [
            '昨日流量',
            '最近一周流量',
            '最近一月流量',
            '最近两个月流量',
            '最近三个月流量'
        ];
        return $data[$type - 1];
    }
}

if (!function_exists('array_get')) {
    function array_get($array, $key, $default = null)
    {
        return \Illuminate\Support\Arr::get($array, $key, $default);
    }
}

if (!function_exists('str_finish')) {
    function str_finish($value, $cap)
    {
        return \Illuminate\Support\Str::finish($value, $cap);
    }
}
if (!function_exists('next_array')) {


    function next_array($array, $next): array
    {
        foreach ($array as $k => $value) {
            if ($value > $next) {
                $max = $k;
                break;
            }
        }
        return array_slice($array, $max);
    }
}

if (!function_exists('v')) {
    /**
     * 重写视图.
     *
     * @param $viewName
     * @param array $params
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function v($viewName, $params = [])
    {
        $namespace = config('meedu.system.theme.use', 'default');
        $viewName = preg_match('/::/', $viewName) ? $viewName : $namespace . '::' . $viewName;
        is_h5() && $viewName = str_replace('frontend', 'h5', $viewName);

        return view($viewName, $params);
    }
}

if (!function_exists('is_h5')) {
    /**
     * @return bool
     */
    function is_h5()
    {
        return (new Mobile_Detect())->isMobile();
    }
}

if (!function_exists('make_tree')) {
    /**
     * @param array $list
     * @param int $parentId
     * @return array
     */
    function make_tree(array $list, $parentId = 0)
    {
        $tree = [];
        if (empty($list)) {
            return $tree;
        }

        $newList = [];
        foreach ($list as $k => $v) {
            $newList[$v['id']] = $v;
        }

        foreach ($newList as $value) {
            if ($parentId == $value['parent_id']) {
                $tree[] = &$newList[$value['id']];
            } elseif (isset($newList[$value['parent_id']])) {
                $newList[$value['parent_id']]['children'][] = &$newList[$value['id']];
            }
        }

        return $tree;
    }
}

if (!function_exists('front_image_normalize')) {
    /**
     * Normalize image path only (no webp rewrite).
     * Output: absolute http(s)/data as-is, otherwise exactly one leading slash.
     */
    function front_image_normalize(?string $src): string
    {
        $src = trim((string)$src);
        if ($src === '') {
            return '';
        }
        if (str_starts_with($src, 'http://') || str_starts_with($src, 'https://') || str_starts_with($src, 'data:')) {
            return $src;
        }
        $src = preg_replace('#^/+#', '', $src) ?? $src;
        if ($src === '') {
            return '';
        }
        return '/' . $src;
    }
}

if (!function_exists('front_webp_url')) {
    /**
     * 前台图片展示：按命名规则匹配 /webps/… 对应文件是否存在，
     * 存在返回 webp，否则返回原图。不查数据库。
     *
     * 规则：/front/imgs/a.png → /webps/front/imgs/a.webp
     */
    function front_webp_url(?string $src): string
    {
        return \App\Services\WebpImageService::preferWebpUrl($src);
    }
}

if (!function_exists('front_image_url')) {
    /**
     * Normalize image path for frontend display, preferring local webp when available.
     * Compatible with upload paths that already start with "/".
     * Output: absolute http(s) URL as-is, otherwise exactly one leading slash (never "//...").
     */
    function front_image_url(?string $src): string
    {
        return front_webp_url($src);
    }
}

if (!function_exists('front_image_store_path')) {
    /**
     * Normalize image path before saving to DB (never rewrite to webp).
     * Upload components typically return paths starting with "/"; keep that convention: "/front/xxx" or "/uploads/xxx".
     */
    function front_image_store_path(?string $src): string
    {
        return front_image_normalize($src);
    }
}

if (!function_exists('youtube_video_id')) {
    /**
     * Extract YouTube video id from watch / short / embed / youtu.be URLs.
     */
    function youtube_video_id(?string $url): string
    {
        $url = trim((string)$url);
        if ($url === '') {
            return '';
        }

        if (preg_match('~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/)|youtu\.be/)([A-Za-z0-9_-]{6,})~i', $url, $m)) {
            return $m[1];
        }

        try {
            $parts = parse_url($url);
            $host = strtolower((string)($parts['host'] ?? ''));
            $path = (string)($parts['path'] ?? '');
            if (str_contains($host, 'youtu.be')) {
                return trim($path, '/');
            }
            if (str_contains($host, 'youtube.com')) {
                parse_str((string)($parts['query'] ?? ''), $query);
                if (!empty($query['v'])) {
                    return (string)$query['v'];
                }
            }
        } catch (\Throwable $e) {
            return '';
        }

        return '';
    }
}

if (!function_exists('youtube_thumbnail_url')) {
    /**
     * Prefer high-res YouTube poster (maxresdefault), quality fallback handled in img onerror.
     */
    function youtube_thumbnail_url(?string $url, string $quality = 'maxresdefault'): string
    {
        $id = youtube_video_id($url);
        if ($id === '') {
            return '';
        }
        $quality = $quality !== '' ? $quality : 'maxresdefault';
        return 'https://i.ytimg.com/vi/' . rawurlencode($id) . '/' . $quality . '.jpg';
    }
}

if (!function_exists('front_video_cover_url')) {
    /**
     * Resolve video cover: uploaded path first, then high-quality YouTube poster, then fallback.
     */
    function front_video_cover_url(?string $path, ?string $videoUrl = null, string $fallback = '/front/imgs/video-item.png'): string
    {
        $cover = front_image_url($path);
        if ($cover !== '') {
            return $cover;
        }

        $yt = youtube_thumbnail_url($videoUrl, 'maxresdefault');
        if ($yt !== '') {
            return $yt;
        }

        return $fallback !== '' ? front_image_url($fallback) : '';
    }
}

if (!function_exists('wrap_schema_org_html')) {
    /**
     * Wrap Schema.org content with script tag when needed.
     */
    function wrap_schema_org_html(?string $raw): string
    {
        $raw = trim((string)$raw);
        if ($raw === '') {
            return '';
        }
        if (stripos($raw, '<script') !== false) {
            return $raw;
        }
        return '<script type="application/ld+json">' . $raw . '</script>';
    }
}

if (!function_exists('normalize_front_url_path')) {
    /**
     * Normalize request path for matching pages.url_key.
     * Strips domain (uses path only), trims slashes; "/" => "home".
     * Example: http://example.com/about-us => about-us
     */
    function normalize_front_url_path(?string $path = null): string
    {
        if ($path === null || $path === '') {
            $path = function_exists('request') ? (string)request()->path() : '';
        } else {
            // Allow full URL input: keep only path after host
            if (preg_match('#^https?://[^/]+(/.*)?$#i', $path, $m)) {
                $path = $m[1] ?? '/';
            }
        }

        $path = trim((string)$path, '/');
        if ($path === '' || $path === '/') {
            return 'home';
        }

        return $path;
    }
}

if (!function_exists('page_by_url_path')) {
    /**
     * Find active CMS single page by matching path to pages.url_key.
     */
    function page_by_url_path(?string $path = null): ?\App\Modules\Page\Models\Page
    {
        static $cache = [];

        $path = normalize_front_url_path($path);
        if (array_key_exists($path, $cache)) {
            return $cache[$path];
        }

        try {
            if (!class_exists(\App\Modules\Page\Models\Page::class)) {
                return $cache[$path] = null;
            }
            $page = \App\Modules\Page\Models\Page::query()
                ->active()
                ->where(function ($q) use ($path) {
                    $q->where('url_key', $path)
                        ->orWhere('url_key', '/' . $path);
                })
                ->first();
        } catch (\Throwable $e) {
            $page = null;
        }

        return $cache[$path] = $page;
    }
}

if (!function_exists('page_tdk_by_path')) {
    /**
     * Resolve TDK from CMS single page matched by url_key / path.
     * Returns null when no page matched.
     *
     * @return array{title:string,keywords:string,description:string}|null
     */
    function page_tdk_by_path(?string $path = null): ?array
    {
        $page = page_by_url_path($path);
        if (!$page) {
            return null;
        }

        try {
            return (new \App\Services\SeoTemplateService())->getPage($page);
        } catch (\Throwable $e) {
            return null;
        }
    }
}

if (!function_exists('front_dedicated_route_paths')) {
    /**
     * Paths that have a dedicated front controller in routes/web.php (catalog).
     *
     * @return array<string, true>
     */
    function front_dedicated_route_paths(): array
    {
        static $map = null;
        if ($map !== null) {
            return $map;
        }

        $map = [];
        try {
            foreach (app(\App\Services\FrontPageCatalogService::class)->routePages() as $item) {
                $path = trim((string)($item['path'] ?? ''), '/');
                $map[$path] = true;
            }
        } catch (\Throwable $e) {
            $map = [];
        }

        return $map;
    }
}

if (!function_exists('front_has_dedicated_route')) {
    /**
     * Whether path is claimed by a dedicated front route (not CMS catch-all).
     */
    function front_has_dedicated_route(?string $path): bool
    {
        $path = trim((string)$path, '/');
        // CMS may use "home" for homepage; front route path is empty string.
        if ($path === 'home') {
            $path = '';
        }

        return isset(front_dedicated_route_paths()[$path]);
    }
}

if (!function_exists('front_find_dedicated_route')) {
    /**
     * Find the dedicated GET route for a path (excludes customUrl catch-alls).
     */
    function front_find_dedicated_route(?string $path): ?\Illuminate\Routing\Route
    {
        $path = trim((string)$path, '/');
        if ($path === 'home') {
            $path = '';
        }

        if (!front_has_dedicated_route($path)) {
            return null;
        }

        $adminPrefix = trim((string)config('app.admin_prefix'), '/');

        foreach (\Illuminate\Support\Facades\Route::getRoutes() as $route) {
            if (!in_array('GET', $route->methods(), true)) {
                continue;
            }

            $uri = trim((string)$route->uri(), '/');
            if ($uri === '{all}' || str_starts_with($uri, '{all}') || str_contains($uri, '{all}_p')) {
                continue;
            }
            if ($adminPrefix !== '' && ($uri === $adminPrefix || str_starts_with($uri, $adminPrefix . '/'))) {
                continue;
            }

            if ($uri === $path) {
                return $route;
            }
        }

        return null;
    }
}

if (!function_exists('front_dispatch_dedicated_route')) {
    /**
     * Prefer dedicated front controller/view when path overlaps with CMS single page.
     * Returns null when no dedicated route should handle this path.
     *
     * @return mixed|null
     */
    function front_dispatch_dedicated_route(?string $path)
    {
        $route = front_find_dedicated_route($path);
        if (!$route) {
            return null;
        }

        $request = request();
        $route->bind($request);
        $request->setRouteResolver(static function () use ($route) {
            return $route;
        });

        return $route->run();
    }
}

if (!function_exists('page_schema_org_html')) {
    /**
     * Resolve Schema.org HTML by matching current path to pages.url_key.
     * Example: /about-us => page.url_key "about-us"
     */
    function page_schema_org_html(?string $path = null): string
    {
        $page = page_by_url_path($path);
        if (!$page) {
            return '';
        }

        return wrap_schema_org_html($page->schema ?? '');
    }
}

if (!function_exists('remember_inquiry_success')) {
    /**
     * Store one-time inquiry success payload in session for /inquirysuccess.
     */
    function remember_inquiry_success(?string $email): void
    {
        session()->put('inquiry_success', [
            'email' => trim((string)$email),
        ]);
    }
}

if (!function_exists('front_html_prefer_webp')) {
    /**
     * 将 HTML 内图片 src / css url() 按命名规则替换为 webp（存在才换，不查库）。
     */
    function front_html_prefer_webp(?string $html): string
    {
        return \App\Services\WebpImageService::rewriteHtmlImagesToWebp((string)$html);
    }
}

if (!function_exists('static_block_html')) {
    function static_block_html(?string $sign): string
    {
        $sign = trim((string)$sign);
        if ($sign === '') {
            return '';
        }

        try {
            return app(\App\Services\StaticBlockService::class)->html($sign);
        } catch (\Throwable $e) {
            return '';
        }
    }
}

if (!function_exists('sns_icons')) {
    /**
     * Active SNS icons for frontend.
     *
     * @param string $scene link|share
     * @return array<int, array{id:int,sign:string,path:string,icon_url:string,link:string,alt:string,sort:int}>
     */
    function sns_icons(string $scene = 'link'): array
    {
        try {
            return app(\App\Services\SnsIconService::class)->getIcons($scene);
        } catch (\Throwable $e) {
            return [];
        }
    }
}

if (!function_exists('sns_icons_html')) {
    /**
     * Render SNS icons HTML (for static block placeholders, etc).
     *
     * @param string $variant link|product|blog|contact
     */
    function sns_icons_html(string $variant = 'contact'): string
    {
        try {
            $scene = in_array($variant, ['product', 'blog'], true) ? 'share' : 'link';
            return view('front.partials.sns-icons', [
                'variant' => $variant,
                'snsIcons' => sns_icons($scene),
            ])->render();
        } catch (\Throwable $e) {
            return '';
        }
    }
}

if (!function_exists('section_title')) {
    /**
     * @return array{title:string,subtitle:string,name:string,sign:string}
     */
    function section_title(?string $sign): array
    {
        $sign = trim((string)$sign);
        if ($sign === '') {
            return ['sign' => '', 'name' => '', 'title' => '', 'subtitle' => ''];
        }

        try {
            return app(\App\Services\SectionTitleService::class)->get($sign);
        } catch (\Throwable $e) {
            return ['sign' => $sign, 'name' => '', 'title' => '', 'subtitle' => ''];
        }
    }
}

if (!function_exists('custom_services_html')) {
    function custom_services_html(): string
    {
        try {
            $data = app(\App\Services\CustomServiceService::class)->getForFront();
            if (empty($data['columns'])) {
                return '';
            }
            return view('front.partials.custom-services', [
                'customServices' => $data,
            ])->render();
        } catch (\Throwable $e) {
            return '';
        }
    }
}

if (!function_exists('front_urlable')) {
    function front_urlable()
    {
        try {
            if (!function_exists('request') || !request() || !request()->route()) {
                return null;
            }
            return \App\Modules\Url\Models\Url::getUrlable(true);
        } catch (\Throwable $e) {
            return null;
        }
    }
}

if (!function_exists('front_matches_solution_key')) {
    function front_matches_solution_key(?string $value): bool
    {
        $value = trim((string)$value);
        if ($value === '') {
            return false;
        }
        if (mb_stripos($value, '解决方案') !== false) {
            return true;
        }
        $normalized = strtolower(trim(str_replace('_', '-', $value), '/'));
        $parts = preg_split('/[-\/\s]+/', $normalized) ?: [];
        return in_array('solution', $parts, true) || in_array('solutions', $parts, true);
    }
}

if (!function_exists('is_front_about_us_page')) {
    function is_front_about_us_page(): bool
    {
        try {
            $path = strtolower(trim((string)request()->path(), '/'));
            $keys = array_map('strtolower', (array)config('operational.checkUrls.about-us-url', [
                'about-us',
                'about',
                'company',
            ]));
            if ($path !== '' && in_array($path, $keys, true)) {
                return true;
            }

            $route = request()->route();
            if ($route && (string)$route->getActionMethod() === 'aboutUs') {
                return true;
            }

            $urlable = front_urlable();
            if ($urlable instanceof \App\Modules\Page\Models\Page) {
                if (front_matches_about_us_page($urlable)) {
                    return true;
                }
            }
        } catch (\Throwable $e) {
            return false;
        }

        return false;
    }
}

if (!function_exists('front_matches_about_us_page')) {
    function front_matches_about_us_page($page): bool
    {
        $keys = array_map('strtolower', (array)config('operational.checkUrls.about-us-url', [
            'about-us',
            'about',
            'company',
        ]));
        $urlKey = strtolower(trim((string)($page->url_key ?? ''), '/'));
        if ($urlKey !== '' && in_array($urlKey, $keys, true)) {
            return true;
        }
        $name = strtolower(trim((string)($page->name ?? '')));
        return in_array($name, ['about us', 'about-us', 'about'], true);
    }
}

if (!function_exists('is_front_cms_single_page')) {
    function is_front_cms_single_page(): bool
    {
        try {
            $urlable = front_urlable();
            if ($urlable instanceof \App\Modules\Page\Models\Page) {
                return true;
            }

            $route = request()->route();
            $action = $route ? (string)$route->getActionName() : '';
            if ($action !== '' && str_starts_with($action, \App\Http\Controllers\PageController::class)) {
                return true;
            }
        } catch (\Throwable $e) {
            return false;
        }

        return false;
    }
}

if (!function_exists('should_show_front_page_banner')) {
    /**
     * CMS 单页面统一隐藏 PageBanner；About Us 额外保留。
     */
    function should_show_front_page_banner(): bool
    {
        try {
            if (function_exists('is_front_about_us_page') && is_front_about_us_page()) {
                return true;
            }
            if (function_exists('is_front_cms_single_page') && is_front_cms_single_page()) {
                return false;
            }
        } catch (\Throwable $e) {
            return true;
        }

        return true;
    }
}

if (!function_exists('front_not_found_response')) {
    /**
     * Custom front-end 404 response. Production defaults to HTTP 200 so Baota/Nginx
     * does not replace the body with the default nginx 404 page.
     */
    function front_not_found_response(string $view, array $data = [])
    {
        $status = (int) config('app.front_404_http_status', 404);
        if (!in_array($status, [200, 404], true)) {
            $status = 404;
        }

        return response()
            ->view($view, $data, $status)
            ->header('X-Page-Status', '404');
    }
}

if (!function_exists('should_show_front_breadcrumb')) {
    /**
     * 解决方案列表 / 详情页暂时隐藏面包屑。
     */
    function should_show_front_breadcrumb(): bool
    {
        try {
            if (function_exists('is_front_solution_page') && is_front_solution_page()) {
                return false;
            }
        } catch (\Throwable $e) {
            return true;
        }

        return true;
    }
}

if (!function_exists('resolve_product_image_alt')) {
    /**
     * 产品封面/轮播图 alt：优先图片上传表单 alt，其次 SEO「产品图片标签」。
     */
    function resolve_product_image_alt(?string $imageAlt, ?string $seoImgAlt, string $fallback = ''): string
    {
        $imageAlt = trim((string)$imageAlt);
        if ($imageAlt !== '') {
            return $imageAlt;
        }

        $seoImgAlt = trim((string)$seoImgAlt);
        if ($seoImgAlt !== '') {
            return $seoImgAlt;
        }

        return trim($fallback);
    }
}

if (!function_exists('fill_empty_img_alts_in_html')) {
    /**
     * 富文本中未设置（或为空）的 img alt，填充默认值。
     */
    function fill_empty_img_alts_in_html(string $html, string $defaultAlt): string
    {
        $defaultAlt = trim($defaultAlt);
        if ($html === '' || $defaultAlt === '') {
            return $html;
        }

        $safeAlt = htmlspecialchars($defaultAlt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        return (string)preg_replace_callback(
            '/<img\b([^>]*)>/i',
            static function (array $matches) use ($safeAlt) {
                $attrs = $matches[1];

                if (preg_match('/\balt\s*=\s*(["\'])(.*?)\1/is', $attrs, $altMatch)) {
                    if (trim(html_entity_decode($altMatch[2], ENT_QUOTES | ENT_HTML5, 'UTF-8')) !== '') {
                        return $matches[0];
                    }

                    $attrs = preg_replace(
                        '/\balt\s*=\s*(["\'])(.*?)\1/is',
                        ' alt="' . $safeAlt . '"',
                        $attrs,
                        1
                    );

                    return '<img' . $attrs . '>';
                }

                if (preg_match('/\balt\s*=\s*[^\s>]+/i', $attrs)) {
                    // 无引号的空/异常 alt，统一替换为带引号默认值
                    $attrs = preg_replace('/\balt\s*=\s*[^\s>]+/i', ' alt="' . $safeAlt . '"', $attrs, 1);
                    return '<img' . $attrs . '>';
                }

                return '<img alt="' . $safeAlt . '"' . $attrs . '>';
            },
            $html
        );
    }
}
