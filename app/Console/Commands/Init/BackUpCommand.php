<?php

namespace App\Console\Commands\Init;

use App\Utils\Zip;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use STS\ZipStream\ZipStreamFacade ;
use Spatie\DbDumper\Databases\MySql;

class BackUpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup {action}';

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
    public function handle()
    {
        switch ($this->argument('action')) {
            case 'zip':
                $folders = [
                    './addons',
                    './app/Http/Controllers',
                    './app/View/Components/Front',
                    './routes/front.php',
                    './public',
                    './resources/views/front',
                    './resources/views/components/front',
                    './resources/views/layouts/front',
                    './resources/views/pagination',
                    './storage/app/public/uploads',
                    './webpack.mix.js'
                ];
                $arr = [];
                foreach ($folders as $key => $value) {
                    if (is_dir($value)) {
                        $files = File::allFiles($value);
                        foreach ($files as $file) {
                            $arr[$file->getPathname()] = $file->getPathname();
                        }
                    } else {
                        $arr[$value] = $value;
                    }
                }
                $bol = ZipStreamFacade::create('backup.zip', $arr)->saveTo("backup");
                if ($bol) {
                    MySql::create()
                        ->setDbName(config('database.connections.mysql.database'))
                        ->setUserName(config('database.connections.mysql.username'))
                        ->setPassword(config('database.connections.mysql.password'))
                        ->includeTables(
                            [
//                                'variables',
//                                'variable_translations',
//                                'faqs',
//                                'faq_translations',
                                'pages',
                                'page_translations',
                                'page_files',
//                                'url'
                            ]
                        )
                        ->dumpToFile('backup/backup.sql');
                    $this->info('备份成功');
                }
                break;
            case 'unzip':
                $zip = Zip::open(base_path('backup/backup.zip'));
                $zip->extract(base_path());
                DB::unprepared(file_get_contents('backup/backup.sql'));

                $this->info('还原成功');
                break;
        }
    }
}
