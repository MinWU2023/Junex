<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('land_pages', function (Blueprint $table) {
            $table->id();
            $table->string('area_name')->unique()->comment('模板位置名称');
            $table->string('name')->comment('着陆页名称');
            $table->string('url_key')->comment('url key');
            for ($i=1;$i<11;$i++){
                $table->text('plate_content_'.$i)->nullable()->comment('板块内容'.$i);
            }
            $table->string('title')->nullable()->comment('title');
            $table->string('keywords')->nullable()->comment('keywords');
            $table->string('description')->nullable()->comment('description');
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
        Schema::dropIfExists('land_pages');
    }
}
