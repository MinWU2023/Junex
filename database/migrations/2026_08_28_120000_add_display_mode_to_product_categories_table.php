<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('display_mode', 32)
                ->default('product_list')
                ->after('is_menu')
                ->comment('展现形式：product_list=侧栏+产品列表，category_product=分类区块+产品');
        });
    }

    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn('display_mode');
        });
    }
};
