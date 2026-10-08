<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customer_reviews')) {
            Schema::create('customer_reviews', function (Blueprint $table) {
                $table->id();
                $table->string('product')->comment('产品名称');
                $table->string('subject')->comment('主题');
                $table->string('email')->comment('邮箱');
                $table->string('username')->comment('用户名');
                $table->text('content')->comment('评论内容');
                $table->text('imgs')->nullable()->comment('图片(序列化多图)');
                $table->unsignedTinyInteger('score')->default(0)->comment('评分');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_reviews');
    }
}
