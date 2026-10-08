<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('pending:cancel')->hourly();
//        $schedule->command('dispatch:completed')->daily();

        // WebP：采集通常手动跑一次；转换可挂计划任务分批执行
        // $schedule->command('webp:collect')->weeklyOn(1, '02:00')->withoutOverlapping();
        $schedule->command('webp:convert --limit=50 --quality=80')
            ->everyFiveMinutes()
            ->withoutOverlapping(30)
            ->appendOutputTo(storage_path('logs/webp-convert.log'));

        // 数据库全量备份：每小时一次
        $schedule->command('db:backup')
            ->hourly()
            ->withoutOverlapping(50)
            ->appendOutputTo(storage_path('logs/db-backup.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
