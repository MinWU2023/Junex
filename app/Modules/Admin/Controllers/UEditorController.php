<?php

namespace App\Modules\Admin\Controllers;

use App\Facades\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class UEditorController extends \Overtrue\LaravelUEditor\UEditorController
{

    public function serve(Request $request)
    {
        $upload = config('ueditor.upload');
        $storage = app('ueditor.storage');

        switch ($request->get('action')) {
            case 'config':
                return config('ueditor.upload');
            // lists
            case $upload['imageManagerActionName']:
                return $storage->listFiles(
                    $upload['imageManagerListPath'],
                    $request->get('start'),
                    $request->get('size'),
                    $upload['imageManagerAllowFiles']);
            case $upload['fileManagerActionName']:
                return $storage->listFiles(
                    $upload['fileManagerListPath'],
                    $request->get('start'),
                    $request->get('size'),
                    $upload['fileManagerAllowFiles']);
            case $upload['catcherActionName']:
                return $storage->fetch($request);
            default:
                $res =$storage->upload($request);
                $success_url = $res->original['url'];
                $temp = explode('/',$success_url);
                $file_name =  array_pop($temp);

                $file = new UploadedFile(public_path($success_url), $file_name);
                $webp = Webp::make($file);
                $folder_name = implode('/',$temp);
                $file_name_arr = explode('.',$file_name);
                $webp->save(public_path($folder_name . '/' . $file_name_arr[0].'.webp'));
                return $res;
        }
    }


}
