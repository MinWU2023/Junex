<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('banner_translations')) {
            return;
        }

        Schema::table('banner_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('banner_translations', 'button_text')) {
                $table->string('button_text')->nullable()->comment('按钮文案')->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('banner_translations')) {
            return;
        }

        Schema::table('banner_translations', function (Blueprint $table) {
            if (Schema::hasColumn('banner_translations', 'button_text')) {
                $table->dropColumn('button_text');
            }
        });
    }
};
