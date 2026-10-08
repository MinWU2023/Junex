<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class DefaultAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->string('default')->nullable()->comment('属性默认值');
        });
        Schema::table('settings',function (Blueprint $table){
            $table->text('adwords_token')->nullable()->comment('adwords token');
        });
        $permissions_count = DB::table('permissions')->count();
        if ($permissions_count>30){


            \Database\Seeders\PermissionSeeder::addRole();
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('product_attributes',['default']);
        Schema::dropColumns('settings',['adwords_token']);
    }
}
