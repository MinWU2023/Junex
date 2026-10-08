<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqGroupsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('faq_groups')) {
            Schema::create('faq_groups', function (Blueprint $table) {
                $table->id();
                $table->string('name')->comment('分组名称');
                $table->text('content')->nullable()->comment('分组描述');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('faq_groups');
    }
}
