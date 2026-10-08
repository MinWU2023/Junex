<?php

namespace App\Console\Commands\Test;

use App\Modules\AddonsMarket\Models\Addon;
use App\Modules\Setting\Models\Setting;
use App\Services\AddonsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UninstallCloudCommand extends Command
{
    /**
     * The name and signature of the console command.123
     *
     * @var string
     */
    protected $signature = 'uninstall:cloud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(AddonsService $addonService)
    {
        if ($this->confirm('确定解除网站与云平台和crm关联吗(该操作仅适用于复制站,操作前请备份数据库和网站)？')){
            try {
                $addonService->disabled('Cloud');
                $addonService->uninstall('Cloud');
            }catch (\Exception $exception){
                $this->warn($exception->getMessage());
            }
            $setting = Setting::query()->first();
            $setting->website_id = 0;
            $setting->save();
            Addon::query()->where('sign','Cloud')->delete();
            if (Schema::hasTable('website_reports')){
                DB::table('website_reports')->truncate();
            }
//            if (Schema::hasTable('site_counts')){
//                DB::table('site_counts')->truncate();
//            }
            if (Schema::hasTable('session_totals')){
                DB::table('session_totals')->truncate();
            }
            $this->info('解除成功');
        }else{
            $this->info('已取消');
        }
    }






}
