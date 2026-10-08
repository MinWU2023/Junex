<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EnhanceNavigationsHeadFootAndCategories extends Migration
{
    public function up()
    {
        if (Schema::hasTable('navigations')) {
            Schema::table('navigations', function (Blueprint $table) {
                if (!Schema::hasColumn('navigations', 'area')) {
                    $table->string('area', 20)->default('头部')->after('sort')->comment('头部/底部');
                }
                if (!Schema::hasColumn('navigations', 'link_type')) {
                    $table->string('link_type', 20)->default('normal')->after('area')->comment('normal=普通导航 category=关联分类');
                }
            });

            // Normalize existing rows
            DB::table('navigations')->whereNull('area')->orWhere('area', '')->update(['area' => '底部']);
            DB::table('navigations')->whereNotIn('area', ['头部', '底部'])->update(['area' => '底部']);
            if (Schema::hasColumn('navigations', 'link_type')) {
                DB::table('navigations')->whereNull('link_type')->orWhere('link_type', '')->update(['link_type' => 'normal']);
            }
        }

        if (!Schema::hasTable('navigation_product_category')) {
            Schema::create('navigation_product_category', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('navigation_id');
                $table->unsignedBigInteger('product_category_id');
                $table->unsignedInteger('sort')->default(0);
                $table->timestamps();
                $table->unique(['navigation_id', 'product_category_id'], 'nav_cat_unique');
                $table->index('navigation_id');
                $table->index('product_category_id');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('navigation_product_category');
        if (Schema::hasTable('navigations')) {
            Schema::table('navigations', function (Blueprint $table) {
                if (Schema::hasColumn('navigations', 'link_type')) {
                    $table->dropColumn('link_type');
                }
            });
        }
    }
}
