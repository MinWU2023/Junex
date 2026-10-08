<?php

namespace App\View\Components\Admin;

use App\Modules\Navigation\Models\Navigation;
use Illuminate\View\Component;

class FormSelectNavigation extends Component
{
    public $model;
    public $parent_id;
    public $categories;
    public $area;

    public function __construct($model = '', $area = null)
    {
        $this->model = $model;
        $this->parent_id = is_object($model) ? (int)($model->parent_id ?? 0) : 0;
        $this->area = $area
            ?: (is_object($model) ? ($model->area ?? Navigation::AREA_HEAD) : Navigation::AREA_HEAD);

        $excludeId = is_object($model) ? (int)($model->id ?? 0) : 0;

        $this->categories = Navigation::query()
            ->with(['translations', 'children.translations'])
            ->area($this->area)
            ->where('parent_id', 0)
            ->when($excludeId > 0, function ($q) use ($excludeId) {
                $q->where('id', '<>', $excludeId);
            })
            ->orderByDesc('sort')
            ->orderBy('id')
            ->get()
            ->map(function ($item) use ($excludeId) {
                if ($excludeId > 0) {
                    $item->setRelation(
                        'children',
                        $item->children->where('id', '<>', $excludeId)->values()
                    );
                }
                return $item;
            });
    }

    public function render()
    {
        return view('components.admin.form-select-navigation');
    }
}
