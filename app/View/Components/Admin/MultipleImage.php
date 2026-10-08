<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class MultipleImage extends Component
{

    protected $name;

    protected $images;

    protected $display_name;

    public function __construct($name,$displayName,$images=[])
    {
        $this->name = $name;
        $this->display_name = $displayName;
        $this->images = $images;
    }


    public function render()
    {
        return view('components.admin.multiple-image',
            [
                'name' => $this->name,
                'images' => $this->images??[],
                'display_name' => $this->display_name,
            ]
        );
    }
}
