<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddedServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('added_services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('服务名称');
            $table->string('description')->comment('服务描述');
            $table->decimal('price', 10, 2)->nullable()->comment('服务价格');
            $table->boolean('active')->default(0)->comment('0: 未开通, 1: 已开通');
            $table->boolean('is_show')->default(0)->comment('0: 不显示, 1: 显示');
            $table->unsignedInteger('source_id')->comment('来源id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('added_services');
    }
}
