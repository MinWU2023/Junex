<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotStyleTabsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('hot_style_tabs')) {
            Schema::create('hot_style_tabs', function (Blueprint $table) {
                $table->id();
                $table->string('tab_key')->unique()->comment('Tab标识，如 new/best/bundles');
                $table->string('product_source')->default('hot')->comment('产品来源: new/hot/recommend');
                $table->unsignedInteger('sort')->default(0)->comment('排序');
                $table->boolean('active')->default(1)->comment('是否启用');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('hot_style_tabs');
    }
}
