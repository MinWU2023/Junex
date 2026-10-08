<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            //更新已有站的ico
            if (isset(app('settings')['setting']->ico)){
                file_put_contents(public_path('favicon.ico'),file_get_contents(url(app('settings')['setting']->ico)));
            }
        }catch (Exception $exception){

        }

        Schema::table('settings',function (Blueprint $table){
                $table->unsignedTinyInteger('all_locale_active')->default(0)->comment('是否显示所有语言');
                $table->unsignedInteger('upload_image_max_size')->default(200)->comment('图片上传最大限制');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('settings',['all_locale_active','upload_image_max_size']);
    }
}
