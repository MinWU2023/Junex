<?php

namespace App\View\Components\Admin;

use App\Modules\Product\Models\Product;
use Illuminate\View\Component;

class LayuiUploadFileTable extends Component
{

    public $files;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($files = [])
    {
        //
        $this->files = $files;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.layui-upload-file-table', ['files' => $this->files]);
    }
}
