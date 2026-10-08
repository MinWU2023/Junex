<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inquiries')) {
            return;
        }

        Schema::table('inquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('inquiries', 'quantity')) {
                $table->string('quantity', 255)->nullable()->after('content')->comment('询盘数量（字符串区间，如 0~100）');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('inquiries') || !Schema::hasColumn('inquiries', 'quantity')) {
            return;
        }

        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
};
