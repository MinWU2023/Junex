<?php

namespace App\View\Components\Admin;

use App\Modules\Product\Models\ProductBrand;
use Illuminate\View\Component;

class FormSelectBrand extends Component
{

    public $verify;
    public $brand_id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($verify, $brand)
    {
        //
        $this->verify = $verify;
        if (!empty($brand)) {
            $this->brand_id = $brand->id;
        } else {
            $this->brand_id = 0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $brands = ProductBrand::query()->orderByDesc('sort')->get();
        return view('components.admin.form-select-brand', [
            'verify' => $this->verify,
            'brand_id' => $this->brand_id,
            'brands' => $brands->toArray()
        ]);
    }
}
