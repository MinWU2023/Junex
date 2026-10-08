<?php

namespace App\Console\Commands\Init;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpgradeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'upgrade';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('执行数据库迁移...');
        Artisan::call('migrate', ['--force' => true]);

        $this->info('清除路由缓存...');
        Artisan::call('route:clear');

        $this->info('清除配置缓存...');
        Artisan::call('config:clear');

        $this->info('清除视图缓存...');
        Artisan::call('view:clear');
    }
}
