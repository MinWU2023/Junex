<?php

namespace App\Console\Commands\Init;

use App\Modules\Setting\Models\Setting;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\LocaleSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\SloganSeeder;
use Illuminate\Console\Command;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $file;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->file = Storage::disk('disk');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $envPath = base_path() . '/.env';
        if (!is_file($envPath)) {
            $this->error('请先执行install.sh');
        }
        if ($this->file->exists('lock')) {
            $this->error('操作失败，已经执行过安装命令！');
        } else {
            $this->info('开始进行安装');
            Artisan::call('config:clear');
            Artisan::call('key:generate');
            Artisan::call('storage:link');
            Artisan::call('migrate');
            $seeder = new class() extends Seeder {
            };
            $seeder->call(AdminUserSeeder::class);
            $seeder->call(PermissionSeeder::class);
            $seeder->call(SettingSeeder::class);
            $seeder->call(LocaleSeeder::class);
            $seeder->call(MenuSeeder::class);
            $seeder->call(SloganSeeder::class);
            $version = Http::withoutVerifying()->get(config('app.cloud_api', 'https://api.dyycloud.com/').'api/version/getVersion')->body();
            $setting = Setting::first();
            $setting->version = $version;
            $setting->save();
            $this->file->put('app/Http/Controllers/HomeController.php', $this->file->get('stub/controllers/HomeController.stub'));
            $this->file->put('app/Http/Controllers/ProductController.php', $this->file->get('stub/controllers/ProductController.stub'));
            $this->file->put('app/Http/Controllers/NewsController.php', $this->file->get('stub/controllers/NewsController.stub'));
            $this->file->put('app/Http/Controllers/PageController.php', $this->file->get('stub/controllers/PageController.stub'));
            $this->file->put('lock', 1);
        }
    }
}
