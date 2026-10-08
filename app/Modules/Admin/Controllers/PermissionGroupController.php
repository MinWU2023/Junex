<?php


namespace App\Modules\Admin\Controllers;


use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Common\Controllers\BaseController;

class PermissionGroupController extends BaseController
{
    public function __construct(PermissionGroup $permissionGroup)
    {
        $this->modelName = 'PermissionGroup';
        $this->model = $permissionGroup;
        $this->viewPath = 'Admin.Views.PermissionGroup';
        $this->validatorData = [
            'name' => 'required'
        ];
    }
}
