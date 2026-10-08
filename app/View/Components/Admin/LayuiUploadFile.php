<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class LayuiUploadFile extends Component
{

    public $label;
    public $pathName;
    public $path;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $pathName, $path)
    {
        $this->label = $label;
        $this->pathName = $pathName;
        $this->path = $path;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $data = [];
        $data['label'] = $this->label;
        $data['pathName'] = $this->pathName;
        !empty($this->path) ? $data['path'] = $this->path : $data['path'] = '';
        return view('components.admin.layui-upload-file', ['data' => $data]);

    }
}
