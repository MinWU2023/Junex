<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UrlsModifyIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::table('urls', function (Blueprint $table) {
                $table->dropUnique('urls_urlable_type_urlable_id_unique');
            });
        } catch (\Exception $exception) {

        }
//        if ($this->hasUniqueIndex('urls', 'urls_urlable_type_urlable_id_unique')) {
//
//        }
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


    /**
     * 判断表是否包含指定唯一索引
     *
     * @param string $tableName 表名
     * @param string $indexName 索引名
     * @return bool 是否包含指定唯一索引
     */
    private function hasUniqueIndex($tableName, $indexName)
    {
        // 获取数据库名称
        $databaseName = DB::connection()->getDatabaseName();

        // 查询索引信息
        $indexes = DB::select("
            SELECT INDEX_NAME, NON_UNIQUE
            FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
        ", [$databaseName, $tableName]);

        // 检查是否存在指定唯一索引
        foreach ($indexes as $index) {
            if ($index->INDEX_NAME === $indexName && $index->NON_UNIQUE == 0) { // NON_UNIQUE == 0 表示唯一索引
                return true;
            }
        }

        return false;
    }


}
