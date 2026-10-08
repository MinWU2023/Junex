<?php

namespace App\Modules\FileInfo\Services;

use App\Facades\Webp;
use App\Modules\FileInfo\FileInfoConst;
use App\Modules\FileInfo\Models\FileInfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;

class FileUploadService
{

    public function saveImage($file)
    {
        //        $is_watermark = request()->post('watermark', true);
        $is_watermark = false;
        $upload_type = request()->post('uploadType', 'system');
        //        $upload_type = 'system';
        $upload_type_field = $upload_type . '_watermark';
        if (isset(app('settings')['setting']->$upload_type_field) && app('settings')['setting']->$upload_type_field) {
            $is_watermark = true;
        }
        $folder_name = "storage/uploads/images/" . date("Ym/d", time());
        $upload_path = public_path() . '/' . $folder_name;
        $extension = strtolower($file->getClientOriginalExtension());
        $name = $this->getFileName($folder_name, $file->getClientOriginalName());
        //        $name = time() . '_' . Str::random(10);
        $filename = $name . '.' . $extension;
        $watermark_img = app('settings')['setting']->watermark;
        $source_name = $name . '_' . md5('source') . '.' . $extension; //原图
        //        Log::info('原图地址:'.public_path($folder_name . '/' . $source_name));
        //        Log::info('显示地址:'.public_path($folder_name . '/' . $filename));
        if (in_array($extension, FileInfoConst::ALLOW_EXT) && $file->move($upload_path, $source_name)) {
            if ($extension === 'svg') {
                file_put_contents(public_path($folder_name . '/' . $filename), file_get_contents($folder_name . '/' . $source_name));
                return [
                    'status' => true,
                    'file_name' => $filename,
                    'true_path' => $folder_name,
                ];
            }
            $this->convertCMYKToRGB($folder_name . '/' . $source_name);
            $thumbFileName = $name . '--_100' . '.' . $extension;
            try {
                Image::make(public_path($folder_name . '/' . $source_name))->resize(100, 100)->save($folder_name . '/' . $thumbFileName);
                if ($watermark_img && $is_watermark) {
                    Image::make(public_path($folder_name . '/' . $source_name))->insert(public_path(app('settings')['setting']->watermark), app('settings')['setting']->watermark_location, app('settings')['setting']->watermark_x, app('settings')['setting']->watermark_y)->save($folder_name . '/' . $filename);
                } else {
                    file_put_contents(public_path($folder_name . '/' . $filename), file_get_contents($folder_name . '/' . $source_name));
                }
                $file = new UploadedFile(public_path($folder_name . '/' . $filename), $filename);
                if (!in_array($extension, ['gif', 'webp', 'svg'])) {
                    try {
                        $webp = Webp::make($file);
                        $webp->save(public_path($folder_name . '/' . $name . '.webp'));
                    } catch (\Exception $e) {
                        Log::warning('WebP conversion failed for file: ' . $filename . '. Error: ' . $e->getMessage(), [
                            'userId' => auth()->id(),
                            'file' => $folder_name . '/' . $filename
                        ]);
                    }
                }
            } catch (NotReadableException $exception) {
                return [
                    'status' => false,
                    'error_msg' => '文件类型不被支持'
                ];
            }
            return [
                'status' => true,
                'file_name' => $filename,
                'true_path' => $folder_name,
            ];
        } else {
            return [
                'status' => false,
                'error_msg' => '文件类型不被支持'
            ];
        }
    }


    public function save($file, $type)
    {
        $folder_name = "storage/uploads/" . $type . "/" . date("Ym/d", time());
        $upload_path = public_path() . '/' . $folder_name;
        $extension = strtolower($file->getClientOriginalExtension());
        //        $name = time() . '_' . Str::random(10);
        $name = $this->getFileName($folder_name, $file->getClientOriginalName());
        $filename = $name . '.' . $extension;
        if (in_array($extension, FileInfoConst::ALLOW_EXT) && $file->move($upload_path, $filename)) {
            return [
                'status' => true,
                'file_name' => $filename,
                'true_path' => $folder_name,
            ];
        } else {
            return [
                'status' => false,
                'error_msg' => '文件类型不被支持'
            ];
        }
    }

    /**
     * 获取文件名称
     * @return string
     */
    public function getFileName($folder_name, $origin_name)
    {
        $arr = explode('.', $origin_name);
        array_pop($arr);
        $name = str_replace(' ', '-', implode('.', $arr)); //去除后缀，获取名称
        if (app('settings')['setting']->upload_name_type == 0) {
            $file_name = time() . '_' . Str::random(10);;
        } elseif (app('settings')['setting']->upload_name_type == 1) {
            $file_name = $name . '-' . time() . Str::random(10);
        } else {
            $is_repeat = FileInfo::query()->where('true_path', $folder_name . '/' . $origin_name)->first();
            if ($is_repeat) {
                $file_name =   $name . '-' . time() . Str::random(10);
            } else {
                $file_name = $name;
            }
        }
        return $file_name;
    }

    public function convertCMYKToRGB($inputPath)
    {
        if (extension_loaded('gmagick')) {
            try {
                $image = new \Gmagick($inputPath);
                if ($image->getimagecolorspace() == \Gmagick::COLORSPACE_CMYK) {
                    $image->setimagecolorspace(\Gmagick::COLORSPACE_SRGB);
                    $image->writeimage($inputPath);
                }
            } catch (\Exception $e) {
                Log::info('图片转换失败，原因为：' . $e->getMessage());
            }
        }
    }
}
