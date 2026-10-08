<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginAccessTokensTable extends Migration
{
    /**
     * Run the migrations.11
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('access_token')->comment("token");
            $table->timestamp('deadline_time')->comment('过期时间');
            $table->boolean('status')->default(0)->comment('是否被使用');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_access_tokens');
    }
}
