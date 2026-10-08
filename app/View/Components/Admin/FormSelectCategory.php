<?php
namespace App\View\Components\Admin;

use App\Modules\Product\Models\ProductCategory;
use Illuminate\View\Component;

class FormSelectCategory extends Component
{
//    public $verify;
    public $category;
    public $showLevel0;
    private $parent_id;
    protected $id;
    public $cate;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($category, $showLevel0,$cate)
    {
        $this->cate = $cate;
        $this->showLevel0 = $showLevel0;
        if (!empty($category)) {
            $this->showLevel0 ? $this->parent_id = $category->parent_id : $this->parent_id = $category->id;
        } else {
            $this->parent_id = 0;
        }
        $this->id = $category?$category->id:0;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if ($this->cate === 'category'){
            $id= $this->id;
            $categories = ProductCategory::where(['parent_id'=>0])->where('id','<>',$id)->with(['children'=>function($query)use($id){
                $query->with(['children'=>function($query)use($id){
                    $query->with(['children'=>function($query)use($id){
                        $query->with(['children'])->where('id','<>',$id);
                    }])->where('id','<>',$id);
                }])->where('id','<>',$id);
            }])->orderByDesc('sort')->get();
        }else{
            $categories = ProductCategory::where(['parent_id'=>0])->with(['children'=>function($query){
                $query->with(['children'=>function($query){
                    $query->with(['children'=>function($query){
                        $query->with(['children']);
                    }]);
                }]);
            }])->orderByDesc('sort')->get();
        }
        return view('components.admin.form-select-category', [
            'showLevel0' => $this->showLevel0,
            'parent_id' => $this->parent_id,
            'categories' => $categories,
            'name' => $this->cate == 'category'?'parent_id':'category_id',
        ]);
    }
}
