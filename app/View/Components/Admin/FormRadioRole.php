<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class FormRadioRole extends Component
{

    public $verify;
    public $roldId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($role)
    {
        //
        if (!empty($role) && count($role)) {
            $this->roldId = $role[0]->id;
        } else {
            $this->roldId = 0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $roles = Role::query()->get();
        return view('components.admin.form-radio-role', [
            'roldId' => $this->roldId,
            'roles' => $roles->toArray()
        ]);
    }
}
