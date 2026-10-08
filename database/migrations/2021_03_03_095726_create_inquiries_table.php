<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->default(0)->comment('关联products');
            $table->string('title')->comment('标题');
            $table->text('content')->comment('内容');
            $table->string('email')->comment('邮箱');
            $table->string('tel')->nullable()->comment('tel');
            $table->string('ip')->comment('ip');
            $table->string('location')->nullable()->comment('ip地址');
            $table->string('source_url')->nullable()->comment('源url');
            $table->string('client')->default('pc')->comment('客户端');
            $table->mediumInteger('add_date')->comment('上传时间');
//            $table->boolean('is_read')->default(0)->comment('已读');
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
        Schema::dropIfExists('inquiries');
    }
}
