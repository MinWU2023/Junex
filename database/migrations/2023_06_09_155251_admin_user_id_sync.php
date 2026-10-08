<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminUserIdSync extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Modules\Blog\Models\Blog::query()->where('admin_user_id',0)->update([
            'admin_user_id' => 2
        ]);
        \App\Modules\Article\Models\Article::query()->where('admin_user_id',0)->update([
            'admin_user_id' => 2
        ]);
        \App\Modules\Product\Models\Product::query()->where('admin_user_id',0)->update([
            'admin_user_id' => 2
        ]);
        \App\Modules\Product\Models\ProductCategory::query()->where('admin_user_id',0)->update([
            'admin_user_id' => 2
        ]);
        \App\Modules\Product\Models\ProductBrand::query()->where('admin_user_id',0)->update([
            'admin_user_id' => 2
        ]);
        \App\Modules\Product\Models\ProductAttribute::query()->where('admin_user_id',0)->update([
            'admin_user_id' => 2
        ]);
        \App\Modules\Product\Models\ProductTag::query()->where('admin_user_id',0)->update([
            'admin_user_id' => 2
        ]);


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
