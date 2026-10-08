<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateTranslateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_categories', function (Blueprint $table) {
            $table->tinyInteger('is_translate')->default(0)->comment('是否翻译');
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });
        Schema::table('banners', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });
        Schema::table('blogs', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });
        Schema::table('blog_tags', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });

        Schema::table('download_categories', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });
        Schema::table('downloads', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });
        Schema::table('navigations', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });
        Schema::table('product_categories', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('0未翻译,1翻译成功,2翻译失败，3翻译进行中');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });
//        Schema::table('product_attribute_values', function (Blueprint $table) {
//            $table->boolean('is_translate')->default(0)->comment('是否翻译');
//        });
        Schema::table('product_tags', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });
        Schema::table('slogans', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('is_translate')->default(0)->comment('是否翻译');
        });

        if (!Schema::hasTable('translate_jobs')){
            Schema::create('translate_jobs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('source_id')->comment('源(模型)id');
                $table->string('model')->comment('对应模型');
                $table->text('default_locale')->comment('默认语种');
                $table->text('translate_locales')->comment('翻译语种');
                $table->string('field')->comment('翻译字段');
                $table->longText('content')->comment('翻译内容');
                $table->string('model_type')->comment('模型类型');
                $table->longText('result_content')->comment('返回内容');
                $table->unsignedTinyInteger('status')->default(0)->comment('0等待翻译,1翻译成功,2翻译失败');
                $table->string('error_msg')->nullable()->comment('失败原因');
                $table->dateTime('error_at')->nullable()->comment('异常时间');
                $table->timestamps();
            });
        }
        if (DB::table('settings')->first()) {
            $created_at= $updated_at=date('Y-m-d H:i:s');
            $system_menu = \App\Modules\Menu\Models\Menu::query()->where('route','admin.menu.system.visibility')->first();
            DB::table('menus')->insert([
                'parent_id' => $system_menu->id,
                'sort' => 0,
                'name' => '翻译任务',
                'route' => 'admin.translateJob.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
            DB::table('permissions')->updateOrInsert([
                'name' => 'admin.translateJob.index',
            ],[
                'pg_id' => 16,
                'display_name' => '翻译任务',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
            $role = Role::findById(1);
            $permission = \App\Modules\Admin\Models\Permission::where('name', 'admin.translateJob.index')->first();
            $role->givePermissionTo($permission);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translate_jobs');
        Schema::dropColumns('settings',['is_translate']);
        Schema::dropColumns('product_categories',['is_translate']);
        Schema::dropColumns('products',['is_translate']);
        Schema::dropColumns('product_tags',['is_translate']);
        Schema::dropColumns('product_attributes',['is_translate']);
        Schema::dropColumns('article_categories',['is_translate']);
        Schema::dropColumns('articles',['is_translate']);
        Schema::dropColumns('blog_categories',['is_translate']);
        Schema::dropColumns('blogs',['is_translate']);
        Schema::dropColumns('blog_tags',['is_translate']);
        Schema::dropColumns('download_categories',['is_translate']);
        Schema::dropColumns('downloads',['is_translate']);
        Schema::dropColumns('pages',['is_translate']);
        Schema::dropColumns('banners',['is_translate']);
        Schema::dropColumns('navigations',['is_translate']);
        Schema::dropColumns('slogans',['is_translate']);
    }
}
