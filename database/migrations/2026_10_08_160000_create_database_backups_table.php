<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('database_backups')) {
            return;
        }

        Schema::create('database_backups', function (Blueprint $table) {
            $table->id();
            $table->string('filename', 255)->comment('备份文件名');
            $table->string('filepath', 500)->comment('相对路径，如 backup/xxx.sql');
            $table->unsignedBigInteger('file_size')->default(0)->comment('文件大小（字节）');
            $table->string('type', 20)->default('auto')->comment('auto=计划任务 manual=手动');
            $table->string('status', 20)->default('success')->comment('success/failed');
            $table->text('message')->nullable()->comment('备注或失败原因');
            $table->timestamps();

            $table->index('created_at');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('database_backups');
    }
};
