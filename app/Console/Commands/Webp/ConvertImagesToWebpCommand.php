<?php

namespace App\Console\Commands\Webp;

use App\Models\WebpImage;
use App\Services\WebpImageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Throwable;

/**
 * 将 webp_images 中待转换记录逐条转为 webp。
 * 可 schedule：php artisan webp:convert --limit=30
 */
class ConvertImagesToWebpCommand extends Command
{
    protected $signature = 'webp:convert
                            {--limit=50 : 单次最多处理条数}
                            {--quality=80 : webp 质量 1-100}
                            {--id= : 只处理指定 id}
                            {--force : 已完成的也重新转换}';

    protected $description = '将待转换图片逐条转为 webp 并写入 /public/webps/…，完成后更新状态';

    public function handle(): int
    {
        $limit = max(1, (int)$this->option('limit'));
        $quality = max(1, min(100, (int)$this->option('quality')));
        $force = (bool)$this->option('force');
        $id = $this->option('id');

        $query = WebpImage::query()->orderBy('id');
        if ($id !== null && $id !== '') {
            $query->where('id', (int)$id);
        } elseif ($force) {
            // 全量重转：不限制 status
        } else {
            // 待转换 + 失败可重试（路径修复后可直接再跑）
            $query->whereIn('status', [WebpImage::STATUS_PENDING, WebpImage::STATUS_FAILED]);
        }

        $rows = $query->limit($limit)->get();
        if ($rows->isEmpty()) {
            $this->info('没有待处理记录。');
            return self::SUCCESS;
        }

        $this->info("本次处理 {$rows->count()} 条（quality={$quality}）…");

        $ok = 0;
        $fail = 0;

        foreach ($rows as $row) {
            /** @var WebpImage $row */
            try {
                $this->convertOne($row, $quality);
                $ok++;
                $this->line("OK #{$row->id} {$row->path} → {$row->path_webp}");
            } catch (Throwable $e) {
                $fail++;
                $row->status = WebpImage::STATUS_FAILED;
                $row->save();
                $this->error("FAIL #{$row->id} {$row->path} : " . $e->getMessage());
            }
        }

        $this->info("完成：成功 {$ok}，失败 {$fail}");
        return self::SUCCESS;
    }

    protected function convertOne(WebpImage $row, int $quality): void
    {
        $sitePath = WebpImageService::normalizeSitePath($row->path);
        $absSrc = WebpImageService::absolutePathFromSitePath($sitePath);
        if (!is_file($absSrc)) {
            throw new \RuntimeException('原文件不存在: ' . $absSrc);
        }

        $webpSite = $row->path_webp
            ? WebpImageService::normalizeSitePath($row->path_webp)
            : WebpImageService::webpSitePathFromOriginal($sitePath);

        if ($webpSite === '') {
            throw new \RuntimeException('无法推导 webp 路径');
        }

        $absWebp = WebpImageService::absoluteWebpPathFromSitePath($webpSite);
        $dir = dirname($absWebp);
        if (!is_dir($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $ext = strtolower(pathinfo($absSrc, PATHINFO_EXTENSION));
        if ($ext === 'webp') {
            // 已是 webp：复制到规范路径（若已在目标则跳过写）
            if (realpath($absSrc) !== realpath($absWebp)) {
                if (!@copy($absSrc, $absWebp)) {
                    throw new \RuntimeException('复制 webp 失败');
                }
            }
        } else {
            Image::make($absSrc)->encode('webp', $quality)->save($absWebp);
        }

        if (!is_file($absWebp)) {
            throw new \RuntimeException('webp 未生成: ' . $absWebp);
        }

        $row->path_webp = $webpSite;
        $row->status = WebpImage::STATUS_DONE;
        $row->save();
    }
}
