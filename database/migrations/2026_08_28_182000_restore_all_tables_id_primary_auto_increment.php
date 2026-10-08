<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * Restore PRIMARY KEY (`id`) + AUTO_INCREMENT for all tables that lost them.
 *
 * Symptoms: inserts get id=0 / Duplicate entry '0', treeTable "id equals parent_id",
 * menus named Videos with id=0, etc.
 */
return new class extends Migration
{
    /** Tables whose `id` is not an integer surrogate key — skip entirely. */
    private array $skipTables = [
        'sessions', // string session id
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
                $this->restoreTable($table);
            } catch (\Throwable $e) {
                Log::error("restore_id_pk_ai failed on {$table}: " . $e->getMessage());
                echo "WARN {$table}: " . $e->getMessage() . PHP_EOL;
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function restoreTable(string $table): void
    {
        if (in_array($table, $this->skipTables, true)) {
            return;
        }
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'id')) {
            return;
        }

        $col = $this->idColumnMeta($table);
        if (!$col) {
            return;
        }

        // Only integer-like id columns
        $type = strtolower((string)($col->Type ?? ''));
        if (!preg_match('/^(tiny|small|medium|big)?int/', $type)) {
            return;
        }

        // 1) Remap id = 0 rows to unique positive ids
        $this->remapZeroIds($table);

        // 2) Remap duplicate ids (keep first row, reassign others)
        $this->remapDuplicateIds($table);

        $create = DB::select("SHOW CREATE TABLE `{$table}`");
        $ddl = $create[0]->{'Create Table'} ?? '';

        $hasPrimary = (bool) preg_match('/PRIMARY KEY\s*\(\s*`id`\s*\)/i', $ddl);
        $hasAnyPrimary = stripos($ddl, 'PRIMARY KEY') !== false;
        $hasAi = stripos($ddl, 'AUTO_INCREMENT') !== false
            && (bool) preg_match('/`id`[^,]*AUTO_INCREMENT/i', $ddl);

        // If primary exists but not on `id`, don't force-change (safety)
        if ($hasAnyPrimary && !$hasPrimary) {
            return;
        }

        // 3) Add PRIMARY KEY (id)
        if (!$hasPrimary) {
            // Drop lingering non-id primary if somehow only KEY without PRIMARY — already handled
            DB::statement("ALTER TABLE `{$table}` ADD PRIMARY KEY (`id`)");
        }

        // 4) Ensure AUTO_INCREMENT on id (preserve signed/unsigned + length)
        if (!$hasAi) {
            $nullSql = (strtoupper((string)$col->Null) === 'YES') ? 'NULL' : 'NOT NULL';
            // Force NOT NULL for AI primary keys
            $nullSql = 'NOT NULL';
            $typeSql = $col->Type; // e.g. bigint unsigned / int(10) unsigned
            DB::statement("ALTER TABLE `{$table}` MODIFY `id` {$typeSql} {$nullSql} AUTO_INCREMENT");
        }

        // 5) Reset next AUTO_INCREMENT
        $next = ((int) DB::table($table)->max('id')) + 1;
        if ($next < 1) {
            $next = 1;
        }
        DB::statement("ALTER TABLE `{$table}` AUTO_INCREMENT = {$next}");
    }

    private function idColumnMeta(string $table): ?object
    {
        $cols = DB::select("SHOW COLUMNS FROM `{$table}` WHERE Field = 'id'");
        return $cols[0] ?? null;
    }

    private function remapZeroIds(string $table): void
    {
        while ($row = DB::table($table)->where('id', 0)->first()) {
            $newId = max(((int) DB::table($table)->max('id')) + 1, 1);
            // Avoid collision
            while (DB::table($table)->where('id', $newId)->exists()) {
                $newId++;
            }

            // Prefer updating by unique secondary columns when available
            $updated = DB::update(
                "UPDATE `{$table}` SET `id` = ? WHERE `id` = 0 LIMIT 1",
                [$newId]
            );
            if ($updated < 1) {
                break;
            }

            // Best-effort: if table has parent_id pointing at old 0 for "self" children,
            // leave parent_id=0 as top-level sentinel (do not rewrite all parent_id=0).
        }
    }

    private function remapDuplicateIds(string $table): void
    {
        $dups = DB::select(
            "SELECT `id`, COUNT(*) AS c FROM `{$table}` GROUP BY `id` HAVING c > 1"
        );
        foreach ($dups as $dup) {
            $this->forceUniqueId($table, (int) $dup->id);
        }
    }

    private function forceUniqueId(string $table, int $id): void
    {
        $count = (int) DB::table($table)->where('id', $id)->count();
        while ($count > 1) {
            $newId = max(((int) DB::table($table)->max('id')) + 1, 1);
            while (DB::table($table)->where('id', $newId)->exists()) {
                $newId++;
            }
            // Change exactly one of the duplicates (MySQL allows LIMIT on multi-match without PK
            // when no PK — which is our situation)
            DB::update("UPDATE `{$table}` SET `id` = ? WHERE `id` = ? LIMIT 1", [$newId, $id]);
            $count = (int) DB::table($table)->where('id', $id)->count();
        }
    }

    public function down(): void
    {
        // Irreversible data / schema repair
    }
};
