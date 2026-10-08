<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoFieldsToProductVideosTables extends Migration
{
    public function up()
    {
        Schema::table('product_videos', function (Blueprint $table) {
            if (!Schema::hasColumn('product_videos', 'product_video_category_id')) {
                $table->unsignedBigInteger('product_video_category_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('product_videos', 'url_key')) {
                $table->string('url_key')->nullable()->index()->after('video_url');
            }
        });

        Schema::table('product_video_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('product_video_translations', 'content2')) {
                $table->longText('content2')->nullable()->after('content');
            }
            if (!Schema::hasColumn('product_video_translations', 'title')) {
                $table->string('title')->nullable()->after('content2');
            }
            if (!Schema::hasColumn('product_video_translations', 'keywords')) {
                $table->string('keywords')->nullable()->after('title');
            }
            if (!Schema::hasColumn('product_video_translations', 'description')) {
                $table->text('description')->nullable()->after('keywords');
            }
        });

        if (!Schema::hasTable('product_video_product')) {
            Schema::create('product_video_product', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_video_id');
                $table->unsignedBigInteger('product_id');
                $table->timestamps();
                $table->unique(['product_video_id', 'product_id'], 'pvp_video_product_unique');
                $table->foreign('product_video_id', 'pvp_video_fk')->references('id')->on('product_videos')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('product_id', 'pvp_product_fk')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('product_video_product');
        Schema::table('product_video_translations', function (Blueprint $table) {
            foreach (['content2', 'title', 'keywords', 'description'] as $column) {
                if (Schema::hasColumn('product_video_translations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
        Schema::table('product_videos', function (Blueprint $table) {
            foreach (['product_video_category_id', 'url_key'] as $column) {
                if (Schema::hasColumn('product_videos', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
