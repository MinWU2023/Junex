<?php


namespace App\Modules\FileInfo\Services;


use App\Modules\FileInfo\Contracts\FilesServiceContract;
use App\Modules\FileInfo\Models\FileInfo;
use App\Presenters\ShowThumbImagePresenter;
use Illuminate\Support\Facades\Auth;

class FilesService implements FilesServiceContract
{
    private $fileUploadService;
    protected $fileInfo;
    public function __construct(FileUploadService $fileUploadService, FileInfo $fileInfo)
    {
        $this->fileUploadService = $fileUploadService;
        $this->fileInfo = $fileInfo;
    }

    public function upload($request, $type = 'images', $isUser = 0)
    {
        $response = [
            'status' => false
        ];
        if ($type == 'images' && $request->file->getSize()/1024>app('settings')['setting']->upload_image_max_size && \request()->post('limit',1)){
            $response['error_msg'] = '上传大小超过最大限制:'.app('settings')['setting']->upload_image_max_size.'kb';
            return  $response;
        }
        if (!request()->post('limit',1) && $request->file->getSize()/1024>5*1024){
            $response['error_msg'] = '上传大小超过最大限制:5M';
            return  $response;
        }
        if ($type == 'images'){
            $file =  $this->fileUploadService->saveImage($request->file);
        }else{
            $file =  $this->fileUploadService->save($request->file, $type);
        }
        if ($file['status']) {
            $response['fileinfo'] = $this->addFileInfo($request->file, $file);
            $response['status'] = true;
            if ($type === 'images') {
                $showThumbImagePresenter = new ShowThumbImagePresenter();
                $response['fileinfo']['thumb_path'] = $showThumbImagePresenter->showImage($response['fileinfo']['true_path']);
            }
        } else {
            $response['error_msg'] = $file['error_msg'];
        }
        return $response;
    }

    public function addFileInfo($files, $attributes)
    {
        $add = [];
        $add['file_name'] = $attributes['file_name'];
        $add['mimeType'] = $files->getClientMimeType();
        $add['true_path'] = $attributes['true_path'] . '/' . $add['file_name'];
        $add['extention'] = strtolower($files->getClientOriginalExtension());
        $add['size'] = filesize(public_path($add['true_path']));
        $add['is_download'] = 1;
        $add['is_upload'] = 0;
        $add['is_watermark'] = \request()->post('watermark',1);
        $add['manual'] = 1;
        $add['remark'] = '';
        $add['create_by'] = Auth::id();
        return FileInfo::create($add);
    }

}
