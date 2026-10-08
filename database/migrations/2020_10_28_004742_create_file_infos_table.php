<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name')->comment('文件名');
            $table->string('mimeType')->comment('mimeType');
            $table->string('true_path')->comment('文件路径');
            $table->string('extention')->comment('拓展名');
            $table->integer('size')->comment('文件大小（字节）');
            $table->tinyInteger('is_download')->default('0')->comment('是否已经保存到了本地');
            $table->tinyInteger('is_upload')->default('0')->comment('是否上传到了云端');
            $table->integer('manual')->default('0')->comment('是否手动上传');
            $table->string('remark')->default('')->comment('备注');
            $table->integer('create_by')->comment('创建人');
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
        Schema::dropIfExists('file_infos');
    }
}
