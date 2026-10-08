<?php

namespace App\Console\Commands;

use App\Services\DatabaseBackupService;
use Illuminate\Console\Command;

class DatabaseBackupCommand extends Command
{
    protected $signature = 'db:backup {--type=auto : auto|manual}';

    protected $description = '全量备份当前 MySQL 数据库到 backup 目录，并记录到 database_backups 表';

    public function handle(DatabaseBackupService $service): int
    {
        $type = $this->option('type') === 'manual' ? 'manual' : 'auto';
        $this->info('开始数据库全量备份...');

        $record = $service->backup($type);

        if ($record->status === 'success') {
            $this->info("备份成功: {$record->filepath} ({$record->file_size_human})");
            return self::SUCCESS;
        }

        $this->error('备份失败: ' . ($record->message ?: '未知错误'));
        return self::FAILURE;
    }
}
