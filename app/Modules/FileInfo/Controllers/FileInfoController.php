<?php


namespace App\Modules\FileInfo\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\FileInfo\Contracts\FilesServiceContract;
use App\Modules\FileInfo\FileInfoConst;
use App\Modules\FileInfo\Requests\CreateFileInfoRequest;
use App\Modules\FileInfo\Services\FilesService;
use App\Traits\ResponseTrait;

class FileInfoController extends Controller
{

    use ResponseTrait;

    /**
     * @var FilesService
     */
    protected $filesService;

    public function __construct(FilesServiceContract $filesService)
    {
        $this->filesService = $filesService;
    }

    public function store(CreateFileInfoRequest $request)
    {
        $response = [
            'status' => false
        ];
        $extension = strtolower($request->file->getClientOriginalExtension());
        if (in_array($extension, FileInfoConst::ALLOW_EXT)) {
            $type = '';
            switch ($extension) {
                case 'png':
                case 'jpg':
                case 'gif':
                case 'svg':
                case 'webp':
                case 'bmp':
                case 'jpeg':
                    $type = 'images';
                    break;
                case 'zip':
                case 'rar':
                    $type = 'zip';
                    break;
                case 'pdf':
                    $type = 'pdf';
                    break;
                case 'mp4':
                    $type = 'mp4';
                    break;
                case 'xls':
                    $type = 'xls';
                    break;
                case 'xlsx':
                    $type = 'xlsx';
                    break;
            }
            if ($type) {
                $response = $this->filesService->upload($request, $type);
            }
        } else {
            $response['error_msg'] = '不被支持的格式';
        }
        if ($response['status']) {
            $code = 0;
        } else {
            $code = 1;
        }
        return $this->data($response, $code);

    }
}
