<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiry_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id')->index()->comment('关联 inquiries');
            $table->string('original_name')->comment('原始文件名');
            $table->string('stored_name')->comment('存储文件名');
            $table->string('path')->comment('相对 public 路径');
            $table->string('mime', 191)->nullable()->comment('MIME 类型');
            $table->string('extension', 32)->nullable()->comment('扩展名');
            $table->unsignedBigInteger('size')->default(0)->comment('字节大小');
            $table->timestamps();

            $table->foreign('inquiry_id')
                ->references('id')
                ->on('inquiries')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiry_attachments');
    }
};
