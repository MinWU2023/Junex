<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\AdminLog;
use App\Modules\Admin\Models\User;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Common\Collections\CommonResourceCollection;
use Illuminate\Http\Request;

class AdminLogController extends BaseController
{
    public function __construct(AdminLog $adminLog)
    {
        $this->modelName = 'AdminLog';
        $this->model = $adminLog->with(['user']);
        $this->viewPath = 'Admin.Views.AdminLog';
        $this->orderBy = 'created_at';
    }

    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        $path = $request->get('path');
        $userId = $request->get('user_id');
        $ip = $request->get('ip');

        if ($request->ajax() || $request->wantsJson()) {
            $data = tap($this->model->orderByDesc($this->orderBy), function ($query) use ($request) {
                if ($name = $request->get('name')) {
                    $query->where('name', 'like', '%' . $name . '%');
                }
                if ($path = $request->get('path')) {
                    $query->where('path', 'like', '%' . $path . '%');
                }
                if ($userId = $request->get('user_id')) {
                    $query->where('user_id', $userId);
                }
                if ($ip = $request->get('ip')) {
                    $query->where('ip', 'like', '%' . $ip . '%');
                }
            })->paginate($request->input('limit', 15));

            if ($collection = $this->collection) {
                return new $collection($data);
            }

            return new CommonResourceCollection($data);
        }

        $users = User::query()->select(['id', 'name'])->orderBy('name')->get();

        return view($this->viewPath . '.index', compact('name', 'path', 'userId', 'ip', 'users'));
    }

}
