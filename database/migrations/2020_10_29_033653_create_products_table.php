<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_user_id')->comment('用户id');
//            $table->bigInteger('product_category_id')->unsigned();
//            $table->foreign('product_category_id')
//                ->references('id')
//                ->on('product_categories')
//                ->onUpdate('cascade');
            $table->bigInteger('product_brand_id')->nullable()->unsigned();
            $table->unsignedInteger('sort')->default(0)->comment('排序，数字越大越靠前');
            $table->string('url_key')->comment('自定义url链接');
            $table->boolean('active')->default(1)->comment('0，被删除。1，正常显示。');
            $table->boolean('is_new')->default(0)->comment('是否为最新产品');
            $table->boolean('is_hot')->default(0)->comment('是否为最热产品');
            $table->boolean('is_recommend')->default(0)->comment('是否为推荐产品');
            $table->mediumInteger('add_date')->comment('上传时间');
            $table->integer('attribute_category_id')->nullable()->comment('属性分类id');
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
        Schema::dropIfExists('products');
    }
}
