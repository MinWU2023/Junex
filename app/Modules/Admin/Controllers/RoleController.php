<?php


namespace App\Modules\Admin\Controllers;


use App\Modules\Admin\Collections\PermissionCollection;
use App\Modules\Common\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    public function __construct(Role $role)
    {
        $this->modelName = 'Role';
        $this->model = $role;
        $this->viewPath = 'Admin.Views.Role';
        $this->validatorData = [
            'name' => 'required',
        ];
    }

    public function roleHasPermission($id)
    {
        $role = Role::query()->find($id)?:new Role();

        return new PermissionCollection($role->permissions);
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData);

        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $translate = $request->get('translate');
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        try {
            $model = $this->model->create($add);
            $model->syncPermissions(explode(',', $request->input('permissions', [])));
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData);
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $model = $this->model->find($id);
        $translate = $request->get('translate');
        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        try {
            $model->update($update);
            $model->syncPermissions(explode(',', $request->input('permissions', [])));
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
        if ($model->id === 1) {
            return $this->badRequest('超级管理员无法删除');
        }
        try {
            $model->delete();
        } catch (\PDOException $exception) {
            Log::error($this->model . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }
}
