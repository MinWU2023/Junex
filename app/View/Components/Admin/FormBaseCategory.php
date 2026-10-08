<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

/**
 * 分类选择列表
 */
class FormBaseCategory extends Component
{

    public $model;

    public $name;
    public $modelName;
    public $verify;
    protected $is_single;

    public function __construct($model,$modelName,$name,$verify=true,$isSingle=false)
    {
        $this->model = $model;
        $this->name=  $name;
        $this->modelName = $modelName;
        $this->verify = $verify;
        $this->is_single = $isSingle;
    }

    public function render()
    {
        $categories = new $this->modelName();
        $categories = $categories->where(['parent_id'=>0])->with(['translations', 'children'=>function($query){
            $query->with(['translations', 'children']);
        }])->get();
        return view('components.admin.form-base-category',
            [
                'categories' => $categories,
                'model' => $this->model,
                'name' => $this->name,
                'verify' => $this->verify,
                'is_single' => $this->is_single
            ]
        );
    }
}
