<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class SelectPhoto extends Component
{
    protected $key;

    public function __construct($key){
        $this->key = $key;
    }


    public function render()
    {
        return view('components.admin.select-photo',
            [
                'key' => $this->key,
            ]
        );
    }
}
