<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Restore PRIMARY KEY + AUTO_INCREMENT on menus / permissions / roles tables
 * after Duplicate entry '0' for key 'PRIMARY' insert failures.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach (['menus', 'permissions', 'permission_groups', 'roles'] as $table) {
            $this->restorePrimaryAutoIncrement($table);
        }
    }

    private function restorePrimaryAutoIncrement(string $table): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        while ($row = DB::table($table)->where('id', 0)->first()) {
            $newId = ((int) DB::table($table)->max('id')) + 1;
            DB::table($table)->where('id', 0)->limit(1)->update(['id' => max($newId, 1)]);
        }

        $create = DB::select("SHOW CREATE TABLE `{$table}`");
        $ddl = $create[0]->{'Create Table'} ?? '';

        if (stripos($ddl, 'PRIMARY KEY') === false) {
            DB::statement("ALTER TABLE `{$table}` ADD PRIMARY KEY (`id`)");
            $create = DB::select("SHOW CREATE TABLE `{$table}`");
            $ddl = $create[0]->{'Create Table'} ?? '';
        }

        if (stripos($ddl, 'AUTO_INCREMENT') === false) {
            DB::statement("ALTER TABLE `{$table}` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");
        }

        $next = ((int) DB::table($table)->max('id')) + 1;
        if ($next < 1) {
            $next = 1;
        }
        DB::statement("ALTER TABLE `{$table}` AUTO_INCREMENT = {$next}");
    }

    public function down(): void
    {
        //
    }
};
