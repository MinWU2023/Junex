<?php
namespace App\Presenters;

use App\Facades\Webp;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ShowThumbImagePresenter
{


    public function showImage100($path, $width = 100)
    {
        $temp = explode('.', $path);
        if (count($temp) >= 2) {
            $temp[count($temp) - 2] = $temp[count($temp) - 2] . '--_' . $width;
            $thumbPath = implode('.', $temp);
            if (is_file(public_path($thumbPath))) {
                $path = $thumbPath;
            }
        }
        return $path;
    }


    public function showImage($path, $width = 100)
    {
//        $temp = explode('.', $path);
//        if (count($temp) >= 2) {
//            $temp[count($temp) - 2] = $temp[count($temp) - 2] . '--_' . $width;
//            $thumbPath = implode('.', $temp);
//            if (is_file(public_path($thumbPath))) {
//                $path = $thumbPath;
//            }
//        }
        return $path;
    }


    public function replaceContentImage($content)
    {
        preg_match_all("/<img(.*)src=(\'|\")(.*)(\'|\")(.*)>/U", $content, $matchs);
        if (isset($matchs[0])) {
            foreach ($matchs[0] as $key => $value) {
                $str = '<picture><source type="image/webp" srcset="' . $this->showWebp($matchs[3][$key]) . '"><source type="image/jpeg" srcset="' . $matchs[3][$key] . '">';
                $str .= $value . '</picture>';
                $content = str_replace($value, $str, $content);
            }
        }
        return $content;
    }


    public function setImage($path, $sizes)
    {
        $width = $sizes[0];
        $height = $sizes[1] ?? $sizes[0];
        $temp = explode('.', $path);
        if (count($temp) >= 2) {
            $temp[count($temp) - 2] = $temp[count($temp) - 2] . '_' . $width . '_' . $height;
            $new_path = implode('.', $temp);
            //该图片不存在则生成
            if (!is_file(public_path($new_path))) {

                Image::make(public_path($path))->fit($width, $height, function ($constraint) {
                    $constraint->upsize();
                })->save(public_path($new_path));
            }
            return $new_path;
        }
        return $path;
    }


    public function showWebp($path)
    {
        $temp = explode('.', $path);
        if(isset($temp[1]) && $temp[1]=='gif'){
            return  $path;
        }
        $temp[1] = 'webp';
        $webpPath = $temp[0] . '.' . $temp[1];
        if (!is_file(public_path($webpPath))) {
            $this->insertWebp($path);
        }
        $path = $webpPath;
        return $path;
    }

    public function insertWebp($path){
        if ($path) {
            $temp = explode('/',$path);
            $file_name =  array_pop($temp);
            $file = new UploadedFile(public_path($path), $file_name);
            $webp = Webp::make($file);
            $folder_name = implode('/',$temp);
            $file_name_arr = explode('.',$file_name);
            $webp->save(public_path($folder_name . '/' . $file_name_arr[0].'.webp'));
        }

    }

    public function downloadImage($path){
        try {
            $path_url = parse_url($path)['path'];
            $directory = explode('/',$path_url);
            array_pop($directory);
            $directory = implode('/',$directory);
            $storage = Storage::disk('disk');
            if (!file_exists(public_path($path_url))){
                $client = new Client(['verify' => false]);  //忽略SSL错误
                if (!$storage->exists('public/'.trim($directory,'/'))) {
                    $storage->makeDirectory('public/'.trim($directory,'/'));
                }
                $storage->put('public/'.trim($path_url,'/'),$client->get($path)->getBody());
            }
            return asset($path_url);
        }catch (\Exception $exception){
            Log::info('图片'.$path.'下载失败:'.$exception->getMessage());
        }
        return  '';
    }


    public function downRemoteImage($content)
    {
        preg_match_all("/src=(\'|\")(.*)(\'|\")/U", $content, $matchs);
        $replace = [];
        if (isset($matchs[2]) && $matchs[2]) {
            foreach ($matchs[2] as $key => $value) {
                $replace[$value] =  $this->downloadImage($value);
            }
        }
        $content = str_replace(array_keys($replace),array_values($replace),$content);
        return $content;
    }

}
