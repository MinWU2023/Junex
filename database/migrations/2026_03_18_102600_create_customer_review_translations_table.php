<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerReviewTranslationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('customer_review_translations')) {
            Schema::create('customer_review_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('customer_review_id');
                $table->string('locale')->index();
                $table->unique(['customer_review_id', 'locale']);

                $table->string('subject')->nullable()->comment('主题');
                $table->text('content')->nullable()->comment('评论内容');

                $table->foreign('customer_review_id')
                    ->references('id')
                    ->on('customer_reviews')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('customer_review_translations');
    }
}
