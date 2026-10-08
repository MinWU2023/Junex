<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class LayuiUploadTable extends Component
{

    public $product;

    public $uploadType;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($product = '',$uploadType='system')
    {
        //
        $this->product = $product;
        $this->uploadType = $uploadType;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.layui-upload-table', ['product' => $this->product,'uploadType' =>  $this->uploadType]);
    }
}
