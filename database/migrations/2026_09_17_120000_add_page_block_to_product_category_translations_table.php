<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_category_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('product_category_translations', 'page_block')) {
                $table->longText('page_block')->nullable()->after('content2')->comment('分类页板块');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_category_translations', function (Blueprint $table) {
            if (Schema::hasColumn('product_category_translations', 'page_block')) {
                $table->dropColumn('page_block');
            }
        });
    }
};
