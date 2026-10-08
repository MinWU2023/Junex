<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncFabricStepToFullCusIntro extends Command
{
    protected $signature = 'static-block:sync-fabric-to-full-cus-intro';

    protected $description = 'Force copy Fabric Customization Selection from processes into full_cus_intro';

    public function handle(): int
    {
        $file = database_path('migrations/2026_08_20_180000_force_resync_fabric_step_to_full_cus_intro.php');
        if (!is_file($file)) {
            $this->error('Migration file not found: ' . $file);
            return 1;
        }

        require_once $file;
        if (!class_exists(\ForceResyncFabricStepToFullCusIntro::class)) {
            $this->error('ForceResyncFabricStepToFullCusIntro class missing.');
            return 1;
        }

        (new \ForceResyncFabricStepToFullCusIntro())->up();
        $this->info('Synced Fabric Customization Selection into full_cus_intro.');
        $this->call('optimize:clear');

        return 0;
    }
}
