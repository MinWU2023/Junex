<?php

namespace App\View\Components\Admin;

use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class LayuiUpload extends Component
{
    public $label;
    public $pathName;
    public $path;

    protected $watermark;//是否打水印

    protected $limit;//是否限制上传大小

    protected $uploadType;//是否限制上传大小


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $pathName, $path,$watermark=true,$limit=true,$uploadType='system')
    {
        $this->label = $label;
        $this->pathName = $pathName;
        $this->path = $path;
        $this->watermark = $watermark;
        $this->limit = $limit;
        $this->uploadType = $uploadType;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
//        Log::info('字段:'.$this->pathName.'水印:'.$this->watermark);
        $data = [];
        $data['label'] = $this->label;
        $data['pathName'] = $this->pathName;
        $data['watermark'] = $this->watermark;
        $data['limit'] = $this->limit;
        !empty($this->path) ? $data['path'] = $this->path : $data['path'] = '';
        return view('components.admin.layui-upload', ['data' => $data,'uploadType' => $this->uploadType]);
    }
}
