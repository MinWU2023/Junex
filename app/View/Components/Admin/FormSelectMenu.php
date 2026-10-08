<?php

namespace App\View\Components\Admin;

use App\Modules\Menu\Models\Menu;
use Illuminate\View\Component;

class FormSelectMenu extends Component
{

    public $verify;
    public $menu;
    public $showLevel0;
    private $parent_id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($verify, $menu, $showLevel0)
    {
        $this->verify = $verify;
        $this->menu = $menu;
        $this->showLevel0 = $showLevel0;
        if (!empty($menu)) {
            $this->showLevel0 ? $this->parent_id = $menu->parent_id : $this->parent_id = $menu->id;
        } else {
            $this->parent_id = 0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $currentId = !empty($this->menu) ? (int) $this->menu->id : 0;
        $menu = Menu::query()->orderByDesc('sort')->get()
            ->reject(fn ($row) => $currentId > 0 && (int) $row->id === $currentId)
            ->values();
        return view('components.admin.form-select-menu', [
            'verify' => $this->verify,
            'showLevel0' => $this->showLevel0,
            'parent_id' => $this->parent_id,
            'menus' => make_tree($menu->toArray()),
            'currentId' => $currentId,
        ]);
    }
}
