<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SupportMultiProductAttributeValues extends Migration
{
    /**
     * 产品属性值改为一对多：同一产品同一属性名可关联多个属性值行。
     * 新增 sort 用于多选值排序。
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_attribute_values', function (Blueprint $table) {
            if (!Schema::hasColumn('product_attribute_values', 'sort')) {
                $table->integer('sort')->default(0)->after('product_attribute_id')->comment('同一属性下多选值排序，越大越靠前');
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
        Schema::table('product_attribute_values', function (Blueprint $table) {
            if (Schema::hasColumn('product_attribute_values', 'sort')) {
                $table->dropColumn('sort');
            }
        });
    }
}
