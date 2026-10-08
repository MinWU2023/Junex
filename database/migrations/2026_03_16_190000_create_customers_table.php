<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('username')->comment('用户名');
                $table->string('email')->unique()->comment('邮箱');
                $table->string('password')->comment('密码');
                $table->string('telephone')->nullable()->comment('电话');
                $table->string('ip')->nullable()->comment('IP');
                $table->string('country')->nullable()->comment('国家');
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
        Schema::dropIfExists('customers');
    }
}
