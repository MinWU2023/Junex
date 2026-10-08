<?php

namespace App\View\Components\Admin;

use App\Modules\Product\Models\ProductAttributeCategory;
use App\Modules\Product\Models\ProductAttributeValue;
use Illuminate\View\Component;
use App\Modules\Product\Models\ProductAttribute as ProductAttributeModel;

class ProductAttribute extends Component
{
    public $translateField;
    public $value;
    private $locales;
    public $attribute_category_id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($attributeCategoryId,$value = null)
    {
        //
        $this->locales = config('translatable.locales');
        $this->value = $value;
        $this->attribute_category_id = $attributeCategoryId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $model = $this->value;
        if ($this->attribute_category_id){
            $attribute_category =  ProductAttributeCategory::with(['attributes'=>function($query){
                $query->orderByDesc('sort')->with(['translations']);
            }])->find($this->attribute_category_id);
            if (isset($attribute_category->attributes)){
                $productAttribute = $attribute_category->attributes;
            }else{
                $productAttribute = [];
            }
        }else{
            //不选择属性分类。不显示
            $productAttribute = [];
        }
        $productAttributeValues = collect();
        if ($model){
            $productAttributeValues = ProductAttributeValue::where([
                'product_id' => $model->id
            ])->orderByDesc('sort')->orderBy('id')->get();
        }
        if(!auth()->user()->hasRole('超级管理员') && !app('settings')['setting']->all_locale_active){
            $this->locales = [config('app.locale')];
        }
        return view('components.admin.product-attribute',
            [
                'productAttribute' => $productAttribute,
                'theLocales' => $this->locales,
                'productAttributeValues' =>$productAttributeValues,
                'attribute_category_id' =>$this->attribute_category_id
            ]
        );

    }
}
