<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhyChooseSettingsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('why_choose_settings')) {
            Schema::create('why_choose_settings', function (Blueprint $table) {
                $table->id();
                $table->string('logo')->nullable()->comment('中间板块 Logo');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('why_choose_setting_translations')) {
            Schema::create('why_choose_setting_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('why_choose_setting_id');
                $table->string('locale')->index();
                $table->string('title')->nullable()->comment('中间标题(移动端)');
                $table->string('subtitle')->nullable()->comment('中间副标题(移动端)');
                $table->text('description_desktop')->nullable()->comment('中间描述(桌面端)');

                $table->unique(['why_choose_setting_id', 'locale'], 'why_choose_setting_locale_unique');
                $table->foreign('why_choose_setting_id', 'why_choose_setting_trans_fk')
                    ->references('id')->on('why_choose_settings')
                    ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('why_choose_setting_translations');
        Schema::dropIfExists('why_choose_settings');
    }
}
