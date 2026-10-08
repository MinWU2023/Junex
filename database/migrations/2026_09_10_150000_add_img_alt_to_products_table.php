<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImgAltToProductsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('products', 'img_alt')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('img_alt')->nullable()->default('')->comment('SEO产品图片标签')->after('url_key');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('products', 'img_alt')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('img_alt');
            });
        }
    }
}
