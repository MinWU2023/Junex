<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropManydataTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('manydata_page');
        Schema::dropIfExists('manydata_translations');
        Schema::dropIfExists('manydata_pages');
        Schema::dropIfExists('manydatas');
    }

    public function down()
    {
        // Irreversible drop.
    }
}
