<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductDetailsToProductTranslations extends Migration
{
    public function up()
    {
        if (Schema::hasTable('product_translations') && !Schema::hasColumn('product_translations', 'product_details')) {
            Schema::table('product_translations', function (Blueprint $table) {
                $table->longText('product_details')->nullable()->after('m_content')->comment('产品细节图');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('product_translations') && Schema::hasColumn('product_translations', 'product_details')) {
            Schema::table('product_translations', function (Blueprint $table) {
                $table->dropColumn('product_details');
            });
        }
    }
}
