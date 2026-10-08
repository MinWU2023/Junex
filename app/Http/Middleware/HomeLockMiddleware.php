<?php

namespace App\Http\Middleware;

use App\Services\GeoLiteService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class HomeLockMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if (app('settings')['setting']->whatsapp_float_active && !strstr($request->url(),'robots.txt') && !strstr($request->url(),'sitemap')){
            $response =   $this->modify($response);
        }
        $geoliteservice = new GeoLiteService();
        $ip = GetUserIP();

// 检查响应是否为200 OK，并且会话中没有保存首次访问URL
        if ($response instanceof Response && $response->status() == 200 && !Session::has('first_visit_url')) {
            // 获取当前请求的完整URL
            $currentUrl = $request->fullUrl();

            // 将其存入session
            Session::put('first_visit_url', $currentUrl);
        }

        $ban_access_ips = app('settings')['setting']->ban_access_ips;
        if ($ban_access_ips && is_array(json_decode($ban_access_ips, true))){
            $banIpList = json_decode($ban_access_ips, true);
            // 获取所有可能的客户端IP（包括代理IP）
            $possibleIps = $this->getAllPossibleIps($request);
            // 与禁止IP列表取交集，有交集则屏蔽
            $blockedIps = array_intersect($possibleIps, $banIpList);
            if (!empty($blockedIps)){
                return abort(403);
            }
        }
        if (!app('settings')['setting']->home_lock){
            return $response;
        }
        $allow_ips = app('settings')['setting']->allow_ips;
        if ($allow_ips && in_array($ip,json_decode($allow_ips))){
            return $response;
        }
        $a = $geoliteservice->getCountry($ip);
        if (session('lock_active')){
            return $response;
        }
        if ($a === '中国'){
            return  redirect('lock');
        }
        return $response;
    }


    protected function modify(Response $response) : Response
    {
        $content = $response->getContent();

        $impersonate = $this->minify(view('layouts.front.whatsApp'));

        $position = strripos($content, '</body>');
        if ($position !== false) {
            $content = substr($content, 0, $position) . $impersonate . PHP_EOL . substr($content, $position);
        } else {
            $content .= $impersonate;
        }

        return $response->setContent($content);
    }

    /**
     * @param  string $content
     * @return string
     */
    protected function minify(string $content) : string
    {
        return preg_replace('/>\s+</m', '><', preg_replace('/\n/', '', $content));
    }

    /**
     * 获取所有可能的客户端IP地址（包括代理IP）
     *
     * @param Request $request
     * @return array
     */
    protected function getAllPossibleIps(Request $request): array
    {
        $ips = [];

        // 常见的代理头及可能的IP来源
        $headers = [
            'HTTP_X_FORWARDED_FOR',      // 标准代理头，可能包含多个IP
            'HTTP_X_REAL_IP',            // Nginx代理常用
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_TRUE_CLIENT_IP',       // Akamai 和其他CDN
            'HTTP_X_CLIENT_IP',          // 一些代理使用
            'HTTP_X_CLUSTER_CLIENT_IP',  // 集群环境
            'HTTP_FORWARDED_FOR',        // 变体
            'HTTP_FORWARDED',            // RFC 7239标准头
            'HTTP_X_ORIGINATING_IP',     // 某些服务使用
            'REMOTE_ADDR',               // 直接连接IP
        ];

        foreach ($headers as $header) {
            $value = $request->server($header);
            if (!empty($value)) {
                // X-Forwarded-For 可能包含多个IP，用逗号分隔
                $headerIps = array_map('trim', explode(',', $value));
                foreach ($headerIps as $ip) {
                    // 验证IP格式
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        $ips[] = $ip;
                    }
                }
            }
        }

        // 使用 Laravel 的 getClientIps 方法获取信任的代理IP
        try {
            $clientIps = $request->getClientIps();
            if (is_array($clientIps)) {
                foreach ($clientIps as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        $ips[] = $ip;
                    }
                }
            }
        } catch (\Exception $e) {
            // 忽略异常
        }

        // 添加 GetUserIP 函数获取的IP
        $userIp = GetUserIP();
        if (!empty($userIp) && filter_var($userIp, FILTER_VALIDATE_IP)) {
            $ips[] = $userIp;
        }

        // 去重并返回
        return array_unique(array_filter($ips));
    }

}
