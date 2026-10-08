<?php

namespace App\View\Components\Admin;

use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Menu\Models\Menu;
use Illuminate\View\Component;

class LayuiSideScroll extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
//        admin.listing.index  listing数据为0时，不显示菜单
        $count = Inquiry::query()->where('title', 'like', '%【First Page TL Inquiry】%')->whereHas('users', function ($query) {
            $query->where(['is_del' => 0, 'user_id' => auth()->id()]);
        })->count();
        if ($count == 0){
            $menus = make_tree(Menu::query()->where('route','<>','admin.listing.index')->get()->toArray());
        }else{
            $menus = make_tree(Menu::all()->toArray());
        }
        $global_color = app('settings')['setting']->global_color;
        $default_background = 'background:#101427!important;';
        $default_color = 'color:rgba(255,255, 255,0.7)';
        $default_class = 'layui-side layui-side-menu layui-side-black';
        switch ($global_color){
            case 'blue':
                $default_background = 'background:#656EE6!important';
                $default_color = 'color:rgba(255,255, 255,0.8)';
                $default_class = 'layui-side layui-side-menu layui-side-blue';
                break;
            case 'white':
                $default_background = 'background:#fff!important';
                $default_color = 'color:rgba(0,0, 0,0.7)';
                $default_class = 'layui-side layui-side-menu layui-side-white wz-black';
                break;
            case 'grey':
                $default_background = 'background:#f6f8fc!important';
                $default_color = 'color:rgba(0,0, 0,0.7)';
                $default_class = 'layui-side layui-side-menu layui-side-grey wz-black';
                break;
        }
        return view('components.admin.layui-side-scroll', compact('menus',
            'default_background','default_color','default_class'));
    }
}
