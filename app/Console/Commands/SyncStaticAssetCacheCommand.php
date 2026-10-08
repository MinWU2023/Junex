<?php

namespace App\Console\Commands;

use App\Services\StaticAssetCacheService;
use Illuminate\Console\Command;

/**
 * 按 .env 同步 Nginx 静态缓存开关标记文件。
 * php artisan static-cache:sync
 */
class SyncStaticAssetCacheCommand extends Command
{
    protected $signature = 'static-cache:sync';

    protected $description = '按 STATIC_ASSET_CACHE_ENABLED 同步 public 下 Nginx 静态缓存标记文件';

    public function handle(StaticAssetCacheService $service): int
    {
        try {
            $result = $service->syncMarker();
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        $marker = $service->markerRelative();
        $enabled = $service->enabled() ? '开启' : '关闭';
        $this->info("静态资源缓存开关：{$enabled}");
        $this->line("标记文件：public/{$marker}");
        $this->line("max-age：" . $service->maxAge() . ' 秒');

        $messages = [
            'created' => '已创建标记文件（Nginx 长缓存将生效，无需重载也可检测）',
            'removed' => '已删除标记文件（Nginx 长缓存关闭）',
            'unchanged_on' => '标记已存在，无需变更',
            'unchanged_off' => '标记不存在，保持关闭',
        ];
        $this->info($messages[$result] ?? $result);

        $this->newLine();
        $this->comment('请确认宝塔「伪静态」已加入 deploy/baota-nginx-laravel.conf 中的静态缓存 location 段。');

        return self::SUCCESS;
    }
}
