<?php

namespace App\Console\Commands\Webp;

use App\Models\WebpImage;
use App\Services\WebpImageService;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * 扫描前台可能用到的图片目录，排重写入 webp_images。
 * 通常只手动执行一次：php artisan webp:collect
 *
 * 覆盖范围：
 * - public/front、images、pages、pre、uploads、3dbottle、report
 * - 上传目录：storage/app/public（站点路径 /storage/…）
 * - 若 public/storage 不是指向 storage/app/public 的软链/Junction（独立真实目录），再扫一遍以免漏图
 */
class CollectImagesCommand extends Command
{
    protected $signature = 'webp:collect
                            {--dry-run : 只统计不写库}';

    protected $description = '扫描前台相关图片目录并排重入库（webp_images），通常手动执行一次';

    public function handle(): int
    {
        $dryRun = (bool)$this->option('dry-run');
        $this->info('开始扫描图片…' . ($dryRun ? ' [dry-run]' : ''));

        $paths = [];
        $rootsUsed = [];

        foreach ($this->resolveScanRoots() as $root) {
            $abs = $root['abs'];
            $prefix = $root['prefix'];
            $label = $root['label'];
            if (!is_dir($abs)) {
                $this->line("跳过（不存在）：{$label}");
                continue;
            }
            $found = $this->scanDirectory($abs, $prefix);
            $rootsUsed[] = "{$label} → {$prefix}/* (" . count($found) . ')';
            $paths = array_merge($paths, $found);
        }

        $paths = array_values(array_unique($paths));
        sort($paths);

        $this->newLine();
        $this->info('扫描根目录：');
        foreach ($rootsUsed as $line) {
            $this->line('  - ' . $line);
        }
        $this->info('发现图片文件：' . count($paths));

        $inserted = 0;
        $skipped = 0;
        $bar = $this->output->createProgressBar(max(1, count($paths)));
        $bar->start();

        foreach ($paths as $sitePath) {
            $bar->advance();
            if ($dryRun) {
                continue;
            }

            $exists = WebpImage::query()->where('path', $sitePath)->exists();
            if ($exists) {
                $skipped++;
                continue;
            }

            $webpPath = WebpImageService::webpSitePathFromOriginal($sitePath);
            WebpImage::query()->create([
                'path' => $sitePath,
                'status' => WebpImage::STATUS_PENDING,
                'path_webp' => $webpPath !== '' ? $webpPath : null,
            ]);
            $inserted++;
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("完成：新增 {$inserted}，已存在跳过 {$skipped}，合计扫描 " . count($paths));

        return self::SUCCESS;
    }

    /**
     * @return array<int, array{abs:string,prefix:string,label:string}>
     */
    protected function resolveScanRoots(): array
    {
        $roots = [];

        // 1) public 下前台静态/业务图目录（白名单）
        foreach (WebpImageService::FRONT_IMAGE_PUBLIC_ROOTS as $rel) {
            $rel = trim(str_replace('\\', '/', (string)$rel), '/');
            if ($rel === '') {
                continue;
            }
            $roots[] = [
                'abs' => public_path($rel),
                'prefix' => '/' . $rel,
                'label' => 'public/' . $rel,
            ];
        }

        // 2) Laravel 标准上传盘 storage/app/public → 站点 /storage/...
        $appPublic = storage_path('app/public');
        $roots[] = [
            'abs' => $appPublic,
            'prefix' => '/storage',
            'label' => 'storage/app/public',
        ];

        // 3) public/storage：本项目上传与 UEditor disk=storage 的根
        //    - 若是指向 storage/app/public 的软链/Junction：与上一项相同，跳过避免重复
        //    - 若是独立真实目录（宝塔常见）：必须再扫，否则会漏掉几乎全部后台上传图
        $publicStorage = public_path('storage');
        if (is_dir($publicStorage) && !$this->isSameDirectory($publicStorage, $appPublic)) {
            $roots[] = [
                'abs' => $publicStorage,
                'prefix' => '/storage',
                'label' => 'public/storage（独立目录）',
            ];
        }

        return $roots;
    }

    protected function isSameDirectory(string $a, string $b): bool
    {
        $ra = realpath($a);
        $rb = realpath($b);
        if ($ra === false || $rb === false) {
            return false;
        }
        $ra = strtolower(str_replace('\\', '/', $ra));
        $rb = strtolower(str_replace('\\', '/', $rb));
        return $ra === $rb;
    }

    /**
     * @return string[] site paths like /front/imgs/a.png
     */
    protected function scanDirectory(string $rootAbs, string $sitePrefix): array
    {
        $rootAbs = rtrim(str_replace('\\', '/', $rootAbs), '/');
        $sitePrefix = '/' . trim(str_replace('\\', '/', $sitePrefix), '/');
        if ($sitePrefix === '/') {
            $sitePrefix = '';
        }

        $out = [];
        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    $rootAbs,
                    RecursiveDirectoryIterator::SKIP_DOTS
                )
            );
        } catch (\Throwable $e) {
            $this->warn("无法打开目录：{$rootAbs} ({$e->getMessage()})");
            return [];
        }

        $rootLen = strlen($rootAbs);

        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }

            $full = str_replace('\\', '/', $file->getPathname());
            $rel = ltrim(substr($full, $rootLen), '/');
            if ($rel === '' || $this->shouldSkipRelative($rel)) {
                continue;
            }
            if (!WebpImageService::isConvertibleImagePath($rel)) {
                continue;
            }

            $out[] = $sitePrefix === ''
                ? '/' . $rel
                : $sitePrefix . '/' . $rel;
        }

        return $out;
    }

    protected function shouldSkipRelative(string $rel): bool
    {
        $parts = explode('/', $rel);
        foreach ($parts as $part) {
            if ($part !== '' && in_array(strtolower($part), WebpImageService::SKIP_DIR_NAMES, true)) {
                return true;
            }
        }
        if (str_starts_with($rel, 'webps/')) {
            return true;
        }
        return false;
    }
}
