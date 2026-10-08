<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('navigations')){
            Schema::create('navigations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('parent_id')->default(0)->comment('上级id');
                $table->string('url')->comment('链接');
                $table->boolean('is_show')->default(1)->comment('是否显示');
                $table->boolean('is_new')->default(1)->comment('是否新窗口');
                $table->boolean('is_nofollow')->default(1)->comment('是否nofollow');
                $table->tinyInteger('sort')->comment('排序');
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('navigation_translations')) {
            Schema::create('navigation_translations', function (Blueprint $table) {
                $table->id();
                $table->string('locale')->index();
                $table->bigInteger('navigation_id')->unsigned();
                $table->foreign('navigation_id')->on('navigations')
                    ->references('id')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->unique(['navigation_id', 'locale']);
                $table->string('name')->nullable()->comment('名称');
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
        Schema::dropIfExists('navigation_translations');
        Schema::dropIfExists('navigations');
    }
}
