<?php

namespace App\Console\Commands\Sync;

use App\Facades\Webp;
use App\Modules\FileInfo\Models\FileInfo;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;

class TurnWebpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'turn:webp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '图片生成一份webp';

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
        $file_infos = FileInfo::query()->where('mimeType','like','%image%')->get();
        foreach ($file_infos as $file_info){
            $path = $file_info->true_path;
            $temp = explode('.', $path);
            $temp[1] = 'webp';
            $webpPath = $temp[0] . '.' . $temp[1];

            if (!is_file(public_path($webpPath))) {
                $this->insertWebp($path);
            }
        }
        $this->info('success');
    }
    public function insertWebp($path){
        $temp = explode('/',$path);
        $file_name =  array_pop($temp);
        $file = new UploadedFile(public_path($path), $file_name);
        $webp = Webp::make($file);
        $folder_name = implode('/',$temp);
        $file_name_arr = explode('.',$file_name);
        $webp->save(public_path($folder_name . '/' . $file_name_arr[0].'.webp'));
    }
}
