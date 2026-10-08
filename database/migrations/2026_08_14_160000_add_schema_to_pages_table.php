<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchemaToPagesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('pages')) {
            return;
        }
        if (!Schema::hasColumn('pages', 'schema')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->mediumText('schema')->nullable()->after('url_key')->comment('Schema.org JSON-LD');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('pages') && Schema::hasColumn('pages', 'schema')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropColumn('schema');
            });
        }
    }
}
