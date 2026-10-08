<?php


namespace App\Modules\Admin\Controllers;


use App\Modules\Admin\Models\PermissionGroup;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Admin\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PermissionController extends  BaseController
{

    public function __construct(Permission $permission)
    {
        $this->modelName = 'Permission';
        $this->model = $permission->with(['permissionGroup']);
        $this->viewPath = 'Admin.Views.Permission';
        $this->validatorData = [
            'display_name' => 'required',
            'pg_id' => 'required|exists:permission_groups,id'
        ];
        $this->validatorMessages = [
            'name.unique' => '权限已存在'
        ];
    }

    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(Permission::query()->with(['permissionGroup']),function ($query) use ($request) {
                if ($name = $request->post('name')) {
                    $query->where('name','like', '%' . $name . '%');
                }
            })->paginate($request->input('limit', 15));
            return new CommonResourceCollection($data);
        }
        return view($this->viewPath . '.index', compact('name'));
    }


    public function store(Request $request)
    {
        $this->validatorData['name'] = [
            'required',
            Rule::unique('permissions')
        ];

        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData,$this->validatorMessages);

        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $translate = $request->get('translate');
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        try {
            if (empty($request->get('url_key')) && isset($add['en']['name'])) $add['url_key'] = Str::slug($add['en']['name']);
            $this->model->create($add);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function update($id, Request $request)
    {
        $this->validatorData['name'] = [
            'required',
            Rule::unique('permissions')->ignore($id)
        ];
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData,$this->validatorMessages);
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
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }


    /**
     * @param $guardName
     * @return \Illuminate\Http\JsonResponse
     */
    public function allPermissions()
    {
        $permissionGroups = PermissionGroup::query()
            ->with(['permission'])
            ->get()->filter(function($item)  {
                return count($item->permission) > 0;
            });

        return response()->json([
            'data' => array_values($permissionGroups->toArray())
        ]);
    }
}
