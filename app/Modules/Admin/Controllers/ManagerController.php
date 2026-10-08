<?php


namespace App\Modules\Admin\Controllers;


use App\Modules\Admin\Models\LoginAccessToken;
use App\Modules\Admin\Models\User;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\Setting;
use App\Modules\Admin\Models\UserSession;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class ManagerController extends BaseController
{
    public function __construct(User $user)
    {
        $this->modelName = 'User';
        $this->model = $user->with(['roles']);
        $this->viewPath = 'Admin.Views.Manager';
        \request()->getMethod() === 'POST' ?
            $this->validatorData = [
                'name' => 'required',
                'email' => 'required|email|Unique:users,email',
                'password' => 'required|confirmed',
            ] :
            $this->validatorData = [
                'name' => 'required',
            ];
        $this->validatorMessages  = [
            'email.unique' => '该邮箱已存在',
        ];
    }

    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap($this->model->whereNotIn('id',[1,2])->orderByDesc($this->orderBy), function ($query) use ($request) {
                if ($name = $request->get('name')) {
                    try {
                        $this->model->has('translation');
                        $query->whereTranslationLike('name', '%' . $name . '%');
                    } catch (\Exception $exception) {
                        $query->where('name', 'like', '%' . $name . '%');
                    }
                }
            })->paginate($request->input('limit', 15));
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);

            }
        }
        return view($this->viewPath . '.index', compact('name'));


    }

    public function store(Request $request)
    {
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
            $add['password'] = Hash::make($add['password']);
            $model = $this->model->create($add);
            $this->assignRole($request->get('role'), $model);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function update($id, Request $request)
    {
        $this->validatorData['email'] = ['required', Rule::unique('users')->ignore($id)];
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
            if ($update['password'] && !is_null($update['password'])) {
                $update['password'] = Hash::make($update['password']);
            } else {
                unset($update['password']);
            }
            $model->update($update);
            $this->assignRole($request->get('role'), $model);
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
            return $this->badRequest('此用户无法被删除');
        }
        try {
            $model->delete();
        } catch (\PDOException $exception) {
            Log::error($this->model . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    private function assignRole($id, User $user)
    {
        $role = Role::find($id);
        if ($role) {
            $user->syncRoles($role);
        }
    }


    public function apiLogin(Request $request)
    {
        LoginAccessToken::where('deadline_time','<',date('Y-m-d H:i:s'))->delete();
        $access_token = $request->get('access_token');
        $login = LoginAccessToken::where(['access_token'=>$access_token,'status'=>0])->where('deadline_time','>=',date('Y-m-d H:i:s'))->first();
        if ($login){
            $login->status = 1;
            $login->save();
            Auth::loginUsingId($login->user_id);
            return redirect()->route('admin.dashboard');
        }else{
            abort('401','授权失败');
        }
    }
}
