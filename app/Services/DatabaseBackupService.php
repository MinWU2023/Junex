<?php

namespace App\Services;

use App\Modules\Admin\Models\DatabaseBackup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * 纯 PHP 全量备份/恢复（不依赖 proc_open / mysqldump / mysql 命令）
 */
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
        @set_time_limit(0);
        @ini_set('memory_limit', '1024M');

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
            $this->dumpDatabaseToFile($absolutePath);

            if (!is_file($absolutePath) || filesize($absolutePath) === 0) {
                throw new \RuntimeException('备份文件未生成或为空');
            }

            $record->update([
                'file_size' => filesize($absolutePath) ?: 0,
                'status' => 'success',
                'message' => $type === 'manual' ? '手动全量备份成功' : '计划任务备份成功',
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

    /**
     * 用指定 SQL 备份覆盖恢复当前数据库。
     * 恢复前会先自动再做一份安全备份（文件保留在 backup/）。
     *
     * @return array{ok: bool, message: string, safety_backup?: DatabaseBackup|null}
     */
    public function restore(DatabaseBackup $backup): array
    {
        if ($backup->status !== 'success') {
            return ['ok' => false, 'message' => '只能恢复成功状态的备份'];
        }

        if (!$backup->fileExists()) {
            return ['ok' => false, 'message' => '备份文件不存在'];
        }

        $sqlPath = $backup->absolutePath();
        if (!preg_match('/\.sql$/i', $sqlPath)) {
            return ['ok' => false, 'message' => '仅支持 .sql 文件恢复'];
        }

        @set_time_limit(0);
        @ini_set('memory_limit', '1024M');

        $safety = null;
        try {
            $safety = $this->backup('auto');
            if ($safety->status === 'success') {
                $safety->update([
                    'message' => '恢复前自动安全备份（来源 #' . $backup->id . '）',
                ]);
            }
        } catch (Throwable $e) {
            Log::warning('Pre-restore safety backup failed: ' . $e->getMessage());
        }

        try {
            $this->importSqlFile($sqlPath);

            return [
                'ok' => true,
                'message' => '数据库已用该 SQL 覆盖恢复' . ($safety && $safety->status === 'success'
                    ? '；恢复前安全备份：' . $safety->filename
                    : ''),
                'safety_backup' => $safety,
            ];
        } catch (Throwable $e) {
            Log::error('Database restore failed: ' . $e->getMessage(), [
                'exception' => $e,
                'backup_id' => $backup->id,
            ]);

            return [
                'ok' => false,
                'message' => '恢复失败：' . mb_substr($e->getMessage(), 0, 800),
                'safety_backup' => $safety,
            ];
        }
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

    protected function dumpDatabaseToFile(string $absolutePath): void
    {
        $dbName = config('database.connections.mysql.database');
        $handle = fopen($absolutePath, 'wb');
        if ($handle === false) {
            throw new \RuntimeException('无法创建备份文件：' . $absolutePath);
        }

        try {
            $this->writeLine($handle, '-- Database Backup');
            $this->writeLine($handle, '-- Generated at: ' . date('Y-m-d H:i:s'));
            $this->writeLine($handle, '-- Database: `' . $dbName . '`');
            $this->writeLine($handle, '');
            $this->writeLine($handle, 'SET NAMES utf8mb4;');
            $this->writeLine($handle, 'SET FOREIGN_KEY_CHECKS=0;');
            $this->writeLine($handle, 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');
            $this->writeLine($handle, '');

            $tables = DB::select('SHOW FULL TABLES WHERE Table_type = "BASE TABLE"');
            $tableKey = 'Tables_in_' . $dbName;

            foreach ($tables as $tableRow) {
                $tableRow = (array) $tableRow;
                $table = $tableRow[$tableKey] ?? reset($tableRow);
                if (!$table) {
                    continue;
                }
                $this->dumpTable($handle, $table);
            }

            // 视图
            $views = DB::select('SHOW FULL TABLES WHERE Table_type = "VIEW"');
            foreach ($views as $viewRow) {
                $viewRow = (array) $viewRow;
                $view = $viewRow[$tableKey] ?? reset($viewRow);
                if (!$view) {
                    continue;
                }
                $this->dumpView($handle, $view);
            }

            $this->writeLine($handle, 'SET FOREIGN_KEY_CHECKS=1;');
            $this->writeLine($handle, '-- Dump completed');
        } finally {
            fclose($handle);
        }
    }

    protected function dumpTable($handle, string $table): void
    {
        $this->writeLine($handle, '-- ----------------------------');
        $this->writeLine($handle, '-- Table structure for `' . $table . '`');
        $this->writeLine($handle, '-- ----------------------------');
        $this->writeLine($handle, 'DROP TABLE IF EXISTS `' . $table . '`;');

        $create = DB::select('SHOW CREATE TABLE `' . str_replace('`', '``', $table) . '`');
        if (empty($create)) {
            return;
        }
        $createRow = (array) $create[0];
        $createSql = $createRow['Create Table'] ?? null;
        if (!$createSql) {
            foreach ($createRow as $k => $v) {
                if (stripos((string) $k, 'create') !== false) {
                    $createSql = $v;
                    break;
                }
            }
        }
        if (!$createSql) {
            return;
        }

        $this->writeLine($handle, $createSql . ';');
        $this->writeLine($handle, '');

        $this->writeLine($handle, '-- ----------------------------');
        $this->writeLine($handle, '-- Records of `' . $table . '`');
        $this->writeLine($handle, '-- ----------------------------');

        $pdo = DB::connection()->getPdo();
        $safeTable = str_replace('`', '``', $table);
        $stmt = $pdo->query('SELECT * FROM `' . $safeTable . '`', \PDO::FETCH_ASSOC);
        if (!$stmt) {
            $this->writeLine($handle, '');
            return;
        }

        $batchSize = 100;
        $batch = [];
        $columns = null;

        while ($row = $stmt->fetch()) {
            if ($columns === null) {
                $columns = array_keys($row);
            }
            $batch[] = $row;
            if (count($batch) >= $batchSize) {
                $this->writeInsertBatch($handle, $table, $columns, $batch);
                $batch = [];
            }
        }

        if (!empty($batch) && $columns) {
            $this->writeInsertBatch($handle, $table, $columns, $batch);
        }

        $this->writeLine($handle, '');
    }

    protected function dumpView($handle, string $view): void
    {
        $this->writeLine($handle, '-- ----------------------------');
        $this->writeLine($handle, '-- View structure for `' . $view . '`');
        $this->writeLine($handle, '-- ----------------------------');
        $this->writeLine($handle, 'DROP VIEW IF EXISTS `' . $view . '`;');

        $create = DB::select('SHOW CREATE VIEW `' . str_replace('`', '``', $view) . '`');
        if (empty($create)) {
            return;
        }
        $createRow = (array) $create[0];
        $createSql = null;
        foreach ($createRow as $k => $v) {
            if (stripos($k, 'create') !== false) {
                $createSql = $v;
                break;
            }
        }
        if ($createSql) {
            $this->writeLine($handle, $createSql . ';');
            $this->writeLine($handle, '');
        }
    }

    protected function writeInsertBatch($handle, string $table, array $columns, array $rows): void
    {
        $colSql = '`' . implode('`,`', array_map(function ($c) {
            return str_replace('`', '``', $c);
        }, $columns)) . '`';

        $values = [];
        foreach ($rows as $row) {
            $parts = [];
            foreach ($columns as $col) {
                $parts[] = $this->escapeValue($row[$col] ?? null);
            }
            $values[] = '(' . implode(',', $parts) . ')';
        }

        $sql = 'INSERT INTO `' . str_replace('`', '``', $table) . '` (' . $colSql . ') VALUES ' . implode(',', $values) . ';';
        $this->writeLine($handle, $sql);
    }

    protected function escapeValue($value): string
    {
        if ($value === null) {
            return 'NULL';
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }

        // 二进制安全转义
        $quoted = DB::connection()->getPdo()->quote((string) $value);
        return $quoted === false ? "''" : $quoted;
    }

    protected function writeLine($handle, string $line): void
    {
        fwrite($handle, $line . "\n");
    }

    /**
     * 纯 PHP 按语句切分并执行 SQL 文件（兼容 mysqldump / 本服务导出格式）
     */
    protected function importSqlFile(string $absoluteSqlPath): void
    {
        $fh = fopen($absoluteSqlPath, 'rb');
        if ($fh === false) {
            throw new \RuntimeException('无法读取 SQL 文件');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('SET NAMES utf8mb4');

        $buffer = '';
        $inString = false;
        $stringChar = '';
        $escaped = false;

        try {
            while (!feof($fh)) {
                $chunk = fread($fh, 1024 * 256);
                if ($chunk === false) {
                    break;
                }

                $len = strlen($chunk);
                for ($i = 0; $i < $len; $i++) {
                    $char = $chunk[$i];
                    $buffer .= $char;

                    if ($inString) {
                        if ($escaped) {
                            $escaped = false;
                            continue;
                        }
                        if ($char === '\\') {
                            $escaped = true;
                            continue;
                        }
                        if ($char === $stringChar) {
                            $inString = false;
                            $stringChar = '';
                        }
                        continue;
                    }

                    if ($char === '\'' || $char === '"' || $char === '`') {
                        $inString = true;
                        $stringChar = $char;
                        continue;
                    }

                    if ($char === ';') {
                        $sql = trim($buffer);
                        $buffer = '';
                        if ($sql === '' || $sql === ';') {
                            continue;
                        }
                        // 去掉纯注释语句
                        $noComment = preg_replace('/^\\s*--.*$/m', '', $sql);
                        $noComment = trim($noComment ?? '');
                        if ($noComment === '' || $noComment === ';') {
                            continue;
                        }
                        DB::unprepared($sql);
                    }
                }
            }

            $tail = trim($buffer);
            if ($tail !== '') {
                $noComment = preg_replace('/^\\s*--.*$/m', '', $tail);
                $noComment = trim($noComment ?? '');
                if ($noComment !== '') {
                    DB::unprepared($tail);
                }
            }
        } finally {
            fclose($fh);
            try {
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            } catch (Throwable $e) {
                // ignore
            }
        }
    }
}
