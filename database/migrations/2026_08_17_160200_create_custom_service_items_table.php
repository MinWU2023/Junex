<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomServiceItemsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('custom_service_items')) {
            Schema::create('custom_service_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('custom_service_id')->comment('所属一级服务列');
                $table->string('path')->nullable()->comment('卡片图片');
                $table->string('url')->nullable()->comment('跳转链接');
                $table->unsignedInteger('sort')->default(0)->comment('排序，越大越靠前');
                $table->boolean('active')->default(1)->comment('是否启用');
                $table->timestamps();

                $table->foreign('custom_service_id')
                    ->references('id')
                    ->on('custom_services')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->index(['custom_service_id', 'active', 'sort']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('custom_service_items');
    }
}
