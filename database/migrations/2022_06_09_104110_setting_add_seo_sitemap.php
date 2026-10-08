<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingAddSeoSitemap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_translations',function (Blueprint $table){
            $table->string('seo_sitemap_title')->nullable()->comment('sitemaptitle模板');
            $table->string('seo_sitemap_description',500)->nullable()->comment('sitemapdescription模板');
            $table->string('seo_sitemap_keywords')->nullable()->comment('sitemapkeyword模板');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
