<?php

return [
    /*
    |--------------------------------------------------------------------------
    | 静态资源浏览器缓存开关
    |--------------------------------------------------------------------------
    |
    | true 时：
    | 1) 在 public/ 写入标记文件，供 Nginx 伪静态识别并下发长缓存头
    | 2) 经 PHP 输出的静态资源响应也会带上 Cache-Control
    |
    | 修改 .env 后执行：php artisan static-cache:sync
    |（应用启动时也会自动同步标记文件）
    |
    */
    'enabled' => (bool)env('STATIC_ASSET_CACHE_ENABLED', false),

    /** 浏览器缓存秒数，默认 1 年 */
    'max_age' => max(60, (int)env('STATIC_ASSET_CACHE_MAX_AGE', 31536000)),

    /**
     * Nginx 检测用的标记文件（相对 public/）。
     * 存在 = 开启长缓存；不存在 = 不生效。
     */
    'marker' => '.static-asset-cache-on',

    /** 需要长缓存的扩展名（小写，不含点） */
    'extensions' => [
        'css', 'js', 'mjs', 'map',
        'jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp', 'avif', 'bmp',
        'woff', 'woff2', 'ttf', 'otf', 'eot',
        'mp4', 'webm', 'mp3', 'pdf',
    ],
];
