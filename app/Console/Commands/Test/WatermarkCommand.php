<?php

namespace App\Console\Commands\Test;

use App\Modules\Product\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class WatermarkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reload:watermark';

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

    public function resetProduct()
    {
        $products = Product::with(['productImages'])->get();
        foreach ($products as $product){
            preg_match_all("/src=(\'|\")(.*)(\'|\")/U", $product->content, $matchs);
            if (isset($matchs[2]) && $matchs[2]){
                foreach ($matchs[2] as $path){
                    $this->handle1($path,'product');
                }
            }
            foreach ($product->productImages as $productImage){
                $this->handle1($productImage->path,'product');
            }
        }
        $this->info('产品水印重置成功');
    }


    protected function handle1($true_path,$upload_type)
    {
        if(strlen($true_path)>200){
            return;
         }
         $path = explode('.', $true_path);
         if(count($path)==1){
             $this->warn('图片路径不对--'.$true_path);
             return;
         }
         $source_name = $path[0] . '_' . md5('source') . '.' . $path[1];
         $webp_path = $path[0] . '.webp';
         $current_path =  $path[0]. '.' . $path[1];
         try {
             if (Storage::disk('disk')->exists('public/' .$true_path)) {
                 if (!Storage::disk('disk')->exists('public/' . $source_name)) {
                     Storage::disk('disk')->put('public/' . $source_name, file_get_contents(url($true_path)));
                 }
                 File::delete(public_path($current_path));
                 File::delete(public_path($webp_path));
                 $upload_type_field = $upload_type.'_watermark';
                 if (app('settings')['setting']->watermark && app('settings')['setting']->$upload_type_field) {
                     Image::make(public_path($source_name))->insert(public_path(app('settings')['setting']->watermark), app('settings')['setting']->watermark_location, app('settings')['setting']->watermark_x, app('settings')['setting']->watermark_y)->save(public_path($true_path));
                 }else{
                     Image::make(public_path($source_name))->save(public_path($true_path));
                 }
             }else{
                 $this->warn('图片'.$true_path.'未找到');
             }
         } catch (\Exception $exception) {
             $this->warn('图片'.$true_path.'生成水印失败,错误原因:'.$exception->getMessage());
         }
    }


    public function handle()
    {
        if ($this->confirm('确定给已上传图片重新打水印?')) {
            $this->resetProduct();
            $this->info('水印已全部重新生成成功');
        } else {
            $this->warn('已取消生成新水印!');
        }
    }
}
