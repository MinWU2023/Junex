<?php

namespace App\View\Components\Admin;

use App\Modules\Admin\Models\PermissionGroup;
use Illuminate\View\Component;

class FormSelectPermissionGroup extends Component
{

    public $verify;
    public $permissionGroupId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($permission)
    {
        //
        if (!empty($permission)) {
            $this->permissionGroupId = $permission->pg_id;
        } else {
            $this->permissionGroupId = 0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $permissionGroups = PermissionGroup::query()->get();
        return view('components.admin.form-select-permission-group', [
            'permissionGroupId' => $this->permissionGroupId,
            'permissionGroups' => $permissionGroups->toArray()
        ]);
    }
}
