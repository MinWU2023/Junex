<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('downloads', function (Blueprint $table) {
            $table->string('download_key')->nullable()->comment('下载key');
        });

        Schema::create('download_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('download_id')->index()->comment('下载id');
            $table->string('ip')->comment('ip');
            $table->string('ip_address')->nullable()->comment('ip地址');
            $table->bigInteger('download_count')->default(0)->comment('下载次数');
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
        
    }
}
