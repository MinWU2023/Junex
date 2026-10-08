<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

/**
 * 分类列表
 */
class FormCategory extends Component
{

    public $model;

    public $name;
    public $modelName;
    public $verify;

    public function __construct($model, $modelName, $name, $verify = true)
    {
        $this->model = $model;
        $this->name =  $name;
        $this->modelName = $modelName;
        $this->verify = $verify;
    }

    /**
     * 递归获取所有后代分类ID
     */
    private function getDescendantIds($categoryId, $modelClass)
    {
        $ids = [];
        $children = $modelClass::where('parent_id', $categoryId)->pluck('id')->toArray();
        foreach ($children as $childId) {
            $ids[] = $childId;
            $ids = array_merge($ids, $this->getDescendantIds($childId, $modelClass));
        }
        return $ids;
    }

    public function render()
    {
        $categories = new $this->modelName();
        $disabledIds = [];

        if ($this->model) {
            // 获取当前分类的所有后代ID，编辑时需要禁用这些选项；同时禁止选自己
            $disabledIds = $this->getDescendantIds($this->model->id, $this->modelName);
            $disabledIds[] = (int) $this->model->id;

            if (method_exists($categories, 'scopeActive')) {
                $categories = $categories->with(['children' => function ($query) {
                    $query->active()->with(['children' => function ($query) {
                        $query->active();
                    }]);
                }])->active()->where(['parent_id' => 0])->get();
            } else {
                $categories = $categories->with(['children.children'])->where(['parent_id' => 0])->get();
            }
        } else {
            if (method_exists($categories, 'scopeActive')) {
                $categories = $categories->active()->with(['children' => function ($query) {
                    $query->active()->with(['children' => function ($query) {
                        $query->active();
                    }]);
                }])->where(['parent_id' => 0])->get();
            } else {
                $categories = $categories->with(['children.children'])->where(['parent_id' => 0])->get();
            }
        }
        return view(
            'components.admin.form-category',
            [
                'categories' => $categories,
                'model' => $this->model,
                'name' => $this->name,
                'verify' => $this->verify,
                'disabledIds' => $disabledIds
            ]
        );
    }
}
