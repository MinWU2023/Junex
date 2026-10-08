<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogBlogTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('blog_blog_tag')){
            Schema::create('blog_blog_tag', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('blog_tag_id');
                $table->integer('blog_id');
                $table->unique(['blog_tag_id','blog_id']);
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
    }
}
