<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EnhanceHotStyleTabsSourceModes extends Migration
{
    public function up()
    {
        if (Schema::hasTable('hot_style_tabs')) {
            Schema::table('hot_style_tabs', function (Blueprint $table) {
                if (!Schema::hasColumn('hot_style_tabs', 'source_type')) {
                    $table->string('source_type', 20)->default('flag')->after('tab_key')->comment('flag|category');
                }
                if (!Schema::hasColumn('hot_style_tabs', 'product_category_id')) {
                    $table->unsignedBigInteger('product_category_id')->nullable()->after('product_source');
                    $table->index('product_category_id');
                }
            });

            // allow product_source nullable for category mode (avoid doctrine/dbal ->change())
            if (Schema::hasColumn('hot_style_tabs', 'product_source')) {
                DB::statement('ALTER TABLE `hot_style_tabs` MODIFY `product_source` VARCHAR(255) NULL');
            }
        }

        if (!Schema::hasTable('hot_style_tab_product')) {
            Schema::create('hot_style_tab_product', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('hot_style_tab_id');
                $table->unsignedBigInteger('product_id');
                $table->unsignedInteger('sort')->default(0);
                $table->timestamps();

                $table->unique(['hot_style_tab_id', 'product_id'], 'hot_style_tab_product_unique');
                $table->index('hot_style_tab_id');
                $table->index('product_id');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('hot_style_tab_product');

        if (Schema::hasTable('hot_style_tabs')) {
            Schema::table('hot_style_tabs', function (Blueprint $table) {
                if (Schema::hasColumn('hot_style_tabs', 'product_category_id')) {
                    $table->dropIndex(['product_category_id']);
                    $table->dropColumn('product_category_id');
                }
                if (Schema::hasColumn('hot_style_tabs', 'source_type')) {
                    $table->dropColumn('source_type');
                }
            });

            if (Schema::hasColumn('hot_style_tabs', 'product_source')) {
                DB::statement('ALTER TABLE `hot_style_tabs` MODIFY `product_source` VARCHAR(255) NOT NULL');
            }
        }
    }
}
