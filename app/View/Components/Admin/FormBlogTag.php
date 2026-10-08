<?php

namespace App\View\Components\Admin;

use App\Modules\AddonsMarket\Models\Addon;
use Illuminate\View\Component;

/**
 * 分类列表
 */
class FormBlogTag extends Component
{

    protected $tags;

    public function __construct($tags=null)
    {
        $this->tags = $tags;
    }

    public function render()
    {
        $active = Addon::query()->where(['sign'=>'Adwords','status'=>1])->first();
//        $active = true;
        return view('components.admin.form-blogTag',
            [
                'tags' => $this->tags,
                'active'=>$active
            ]
        );
    }
}
