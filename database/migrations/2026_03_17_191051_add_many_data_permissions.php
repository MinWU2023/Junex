<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Historical migration — manydata admin was removed.
 * Kept as no-op so migrate history stays valid; do not re-seed menus/permissions.
 */
class AddManyDataPermissions extends Migration
{
    public function up()
    {
        // no-op: 数据字典已下线，改由静态块 / 独立后台模块管理
    }

    public function down()
    {
        //
    }
}
