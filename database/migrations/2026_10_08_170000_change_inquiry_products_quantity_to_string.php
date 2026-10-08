<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inquiry_products')) {
            return;
        }

        // 支持字符串数量区间，如 0~100、5000+（不依赖 doctrine/dbal）
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `inquiry_products` MODIFY `quantity` VARCHAR(255) NOT NULL DEFAULT '1'");
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('inquiry_products')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `inquiry_products` MODIFY `quantity` INT UNSIGNED NOT NULL DEFAULT 1");
        }
    }
};
