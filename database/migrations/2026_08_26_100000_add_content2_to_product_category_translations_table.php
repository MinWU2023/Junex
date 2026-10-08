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
            $table->longText('content2')->nullable()->after('content')->comment('分类描述2');
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
            $table->dropColumn('content2');
        });
    }
};
