<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class CreateSearchDetailsTable extends Migration
{
    public $permissions = [];


    public function __construct()
    {
        $created_at = date('Y-m-d H:i:s');
        $updated_at = $created_at;

        $this->permissions = [
            [
                'pg_id' => 13,
                'name' => 'admin.article.multipleMoveTrash',
                'display_name' => '文章批量放入回收站',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 13,
                'name' => 'admin.article.multipleRestore',
                'display_name' => '文章批量恢复',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 13,
                'name' => 'admin.article.multipleDestroy',
                'display_name' => '文章批量删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'pg_id' => 22,
                'name' => 'admin.blog.multipleMoveTrash',
                'display_name' => '博客批量放入回收站',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 22,
                'name' => 'admin.blog.multipleRestore',
                'display_name' => '博客批量恢复',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 22,
                'name' => 'admin.blog.multipleDestroy',
                'display_name' => '博客批量删除',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'pg_id' => 26,
                'name' => 'admin.search',
                'display_name' => '搜索列表页面',
                'guard_name' => 'web',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]
        ];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('search_id')->unsigned();
            $table->foreign('search_id')
                ->references('id')
                ->on('searches')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('type')->comment('类型');
            $table->string('name')->comment('名称');
            $table->boolean('active')->default(1)->comment('0，被删除。1，正常显示。');
            $table->timestamps();
        });
        if (DB::table('settings')->first()) {
            $add = [
                'id' => 26,
                'name' => '搜索管理',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            DB::table('permission_groups')->updateOrInsert(['id' => $add['id']], $add);
            $roles = Role::whereIn('id', [1, 2])->get();
            foreach ($this->permissions as $permission) {
                DB::table('permissions')
                    ->updateOrInsert(['name' => $permission['name'], 'pg_id' => $permission['pg_id']], $permission);
                $permission = Permission::where('name', $permission['name'])->first();
                foreach ($roles as $role) {
                    $role->givePermissionTo($permission);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_details');
        $roles = Role::whereIn('id', [1, 2])->get();
        foreach ($this->permissions as $permission) {
            foreach ($roles as $role) {
                $role->revokePermissionTo($permission);
            }
            DB::table('permissions')->where('name', $permission['name'])
                ->where('pg_id', $permission['pg_id'])
                ->delete();
        }
        DB::table('permission_groups')->where('id', 26)->delete();
    }
}
