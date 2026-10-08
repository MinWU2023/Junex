<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticBlocksTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('static_blocks')) {
            Schema::create('static_blocks', function (Blueprint $table) {
                $table->id();
                $table->string('sign', 100)->unique()->comment('标识');
                $table->unsignedInteger('sort')->default(0)->comment('排序');
                $table->boolean('active')->default(1)->comment('是否启用');
                $table->string('remark', 255)->nullable()->comment('备注');
                $table->timestamps();
                $table->index('active');
                $table->index('sort');
            });
        }

        if (!Schema::hasTable('static_block_translations')) {
            Schema::create('static_block_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('static_block_id');
                $table->string('locale')->index();
                $table->string('title')->nullable()->comment('标题');
                $table->longText('content')->nullable()->comment('内容');
                $table->unique(['static_block_id', 'locale'], 'static_block_locale_unique');
                $table->foreign('static_block_id', 'static_block_trans_fk')
                    ->references('id')
                    ->on('static_blocks')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }

        if (!Schema::hasTable('static_block_page')) {
            Schema::create('static_block_page', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('static_block_id');
                $table->unsignedBigInteger('page_id');
                $table->timestamps();
                $table->unique(['static_block_id', 'page_id'], 'static_block_page_unique');
                $table->foreign('static_block_id', 'static_block_page_block_fk')
                    ->references('id')
                    ->on('static_blocks')
                    ->onDelete('cascade');
                $table->foreign('page_id', 'static_block_page_page_fk')
                    ->references('id')
                    ->on('pages')
                    ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('static_block_page');
        Schema::dropIfExists('static_block_translations');
        Schema::dropIfExists('static_blocks');
    }
}
