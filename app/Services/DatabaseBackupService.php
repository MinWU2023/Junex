<?php

namespace App\Services;

use App\Modules\Admin\Models\DatabaseBackup;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Spatie\DbDumper\Databases\MySql;
use Throwable;

class DatabaseBackupService
{
    public const DIRECTORY = 'backup';

    /**
     * 执行全量数据库备份，并写入 database_backups 表。
     *
     * @param string $type auto|manual
     */
    public function backup(string $type = 'auto'): DatabaseBackup
    {
        $this->ensureBackupDirectory();

        $filename = 'db_' . date('Ymd_His') . '_' . substr(uniqid('', true), -6) . '.sql';
        $relativePath = self::DIRECTORY . '/' . $filename;
        $absolutePath = base_path($relativePath);

        $record = DatabaseBackup::query()->create([
            'filename' => $filename,
            'filepath' => $relativePath,
            'file_size' => 0,
            'type' => $type === 'manual' ? 'manual' : 'auto',
            'status' => 'failed',
            'message' => '备份进行中',
        ]);

        try {
            $connection = config('database.connections.mysql');
            $dumper = MySql::create()
                ->setDbName($connection['database'] ?? '')
                ->setUserName($connection['username'] ?? '')
                ->setPassword($connection['password'] ?? '')
                ->setHost($connection['host'] ?? '127.0.0.1')
                ->setPort((int) ($connection['port'] ?? 3306));

            // 可选：.env 配置 DB_DUMP_BINARY_PATH=C:\phpEnv\server\mysql\mysql-8.0\bin\
            $dumpBinaryPath = env('DB_DUMP_BINARY_PATH');
            if (!empty($dumpBinaryPath)) {
                $dumper->setDumpBinaryPath($dumpBinaryPath);
            }

            $dumper->dumpToFile($absolutePath);

            if (!is_file($absolutePath)) {
                throw new \RuntimeException('备份文件未生成');
            }

            $record->update([
                'file_size' => filesize($absolutePath) ?: 0,
                'status' => 'success',
                'message' => $type === 'manual' ? '手动备份成功' : '计划任务备份成功',
            ]);
        } catch (Throwable $e) {
            Log::error('Database backup failed: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            if (is_file($absolutePath)) {
                @unlink($absolutePath);
            }

            $record->update([
                'status' => 'failed',
                'message' => mb_substr($e->getMessage(), 0, 1000),
            ]);
        }

        return $record->fresh();
    }

    public function deleteBackup(DatabaseBackup $backup): bool
    {
        $path = $backup->absolutePath();
        if (is_file($path)) {
            @unlink($path);
        }

        return (bool) $backup->delete();
    }

    public function ensureBackupDirectory(): void
    {
        $dir = base_path(self::DIRECTORY);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $gitkeep = $dir . DIRECTORY_SEPARATOR . '.gitkeep';
        if (!is_file($gitkeep)) {
            File::put($gitkeep, '');
        }
    }
}
