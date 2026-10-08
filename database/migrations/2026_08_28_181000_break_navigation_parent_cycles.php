<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Break navigation / category parent cycles that hang front menu rendering.
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->breakCycles('navigations');
        $this->breakCycles('product_categories');
    }

    private function breakCycles(string $table): void
    {
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'parent_id')) {
            return;
        }

        // Self parent → top level
        DB::table($table)->whereColumn('id', 'parent_id')->update(['parent_id' => 0]);

        $rows = DB::table($table)->get(['id', 'parent_id']);
        $byId = [];
        foreach ($rows as $row) {
            $byId[(int)$row->id] = (int)$row->parent_id;
        }

        foreach ($byId as $id => $parentId) {
            if ($parentId <= 0) {
                continue;
            }
            $seen = [];
            $cur = $id;
            $guard = 0;
            while ($cur > 0 && isset($byId[$cur])) {
                if (isset($seen[$cur])) {
                    // Break cycle at this node
                    DB::table($table)->where('id', $id)->update(['parent_id' => 0]);
                    $byId[$id] = 0;
                    break;
                }
                $seen[$cur] = true;
                $next = $byId[$cur];
                if ($next <= 0) {
                    break;
                }
                if ($next === $cur) {
                    DB::table($table)->where('id', $cur)->update(['parent_id' => 0]);
                    $byId[$cur] = 0;
                    break;
                }
                $cur = $next;
                if (++$guard > 50) {
                    DB::table($table)->where('id', $id)->update(['parent_id' => 0]);
                    $byId[$id] = 0;
                    break;
                }
            }
        }
    }

    public function down(): void
    {
        //
    }
};
