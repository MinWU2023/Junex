<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomServicesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('custom_services')) {
            Schema::create('custom_services', function (Blueprint $table) {
                $table->id();
                $table->string('code', 50)->unique()->comment('标识 odm/oem');
                $table->string('bg_image')->nullable()->comment('列背景图');
                $table->string('layout', 20)->default('grid')->comment('布局 grid|list');
                $table->unsignedInteger('sort')->default(0)->comment('排序，越大越靠前');
                $table->boolean('active')->default(1)->comment('是否启用');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('custom_services');
    }
}
