<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * Finish restoring id PRIMARY KEY + AUTO_INCREMENT for tables blocked by FKs
 * in the previous pass (e.g. inquiries).
 */
return new class extends Migration
{
    private array $skipTables = [
        'sessions',
        'cache',
        'cache_locks',
        'password_resets',
        'password_reset_tokens',
    ];

    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $db = DB::getDatabaseName();
        $tables = DB::select('SHOW TABLES');
        $key = 'Tables_in_' . $db;

        foreach ($tables as $row) {
            $table = $row->$key;
            try {
                $this->restoreIfNeeded($table);
            } catch (\Throwable $e) {
                Log::error("restore_id_pk_ai_pass2 failed on {$table}: " . $e->getMessage());
                echo "WARN {$table}: " . $e->getMessage() . PHP_EOL;
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function restoreIfNeeded(string $table): void
    {
        if (in_array($table, $this->skipTables, true)) {
            return;
        }
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'id')) {
            return;
        }

        $cols = DB::select("SHOW COLUMNS FROM `{$table}` WHERE Field = 'id'");
        $col = $cols[0] ?? null;
        if (!$col) {
            return;
        }
        $type = strtolower((string)$col->Type);
        if (!preg_match('/^(tiny|small|medium|big)?int/', $type)) {
            return;
        }

        // Fix id=0
        while (DB::table($table)->where('id', 0)->exists()) {
            $newId = max(((int) DB::table($table)->max('id')) + 1, 1);
            while (DB::table($table)->where('id', $newId)->exists()) {
                $newId++;
            }
            DB::update("UPDATE `{$table}` SET `id` = ? WHERE `id` = 0 LIMIT 1", [$newId]);
        }

        // Fix duplicate ids
        $dups = DB::select("SELECT `id` FROM `{$table}` GROUP BY `id` HAVING COUNT(*) > 1");
        foreach ($dups as $dup) {
            $id = (int)$dup->id;
            while (DB::table($table)->where('id', $id)->count() > 1) {
                $newId = max(((int) DB::table($table)->max('id')) + 1, 1);
                while (DB::table($table)->where('id', $newId)->exists()) {
                    $newId++;
                }
                DB::update("UPDATE `{$table}` SET `id` = ? WHERE `id` = ? LIMIT 1", [$newId, $id]);
            }
        }

        $create = DB::select("SHOW CREATE TABLE `{$table}`");
        $ddl = $create[0]->{'Create Table'} ?? '';
        $hasPrimary = (bool) preg_match('/PRIMARY KEY\s*\(\s*`id`\s*\)/i', $ddl);
        $hasAnyPrimary = stripos($ddl, 'PRIMARY KEY') !== false;
        $hasAi = (bool) preg_match('/`id`[^,]*AUTO_INCREMENT/i', $ddl);

        if ($hasAnyPrimary && !$hasPrimary) {
            return;
        }

        if (!$hasPrimary) {
            DB::statement("ALTER TABLE `{$table}` ADD PRIMARY KEY (`id`)");
        }

        if (!$hasAi) {
            DB::statement("ALTER TABLE `{$table}` MODIFY `id` {$col->Type} NOT NULL AUTO_INCREMENT");
        }

        $next = max(((int) DB::table($table)->max('id')) + 1, 1);
        DB::statement("ALTER TABLE `{$table}` AUTO_INCREMENT = {$next}");
    }

    public function down(): void
    {
        //
    }
};
