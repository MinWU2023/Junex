<?php
namespace App\Modules\FriendLink\Controllers;

use App\Modules\FriendLink\Models\FriendLink;
use App\Modules\Common\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FriendLinkController extends BaseController
{
    public function __construct(FriendLink $friendLink)
    {
        $this->model = $friendLink;
        $this->modelName = 'FriendLink';
        $this->viewPath = 'FriendLink.Views';
        $this->validatorData = [
            'name' => 'required'
        ];
        $this->validatorMessages=[
            'url.url' =>'请填写url链接',
            'url.unique' => '该链接已存在'
        ];
    }
    public function store(Request $request)
    {
        $this->validatorData['url'] = [
            'required',
            'url',
            Rule::unique('friend_links')
        ];
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData,$this->validatorMessages);

        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $translate = $request->get('translate');
        if ($request->get('locales')){
            $locales = array_keys($request->get('locales'));
        }else{
            $locales = [];
        }
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        try {
            if (empty($request->get('url_key')) && isset($add[config('translatable.fallback_locale')]['name'])) $add['url_key'] = Str::slug($add[config('translatable.fallback_locale')]['name'],'-',config('translatable.fallback_locale'));
            $add['locales'] = $locales;
            $this->model->create($add);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function update($id, Request $request)
    {
        $this->validatorData['url'] = [
            'required',
            'url',
            Rule::unique('friend_links')->ignore($id)
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
        if ($request->get('locales')){
            $locales = array_keys($request->get('locales'));
        }else{
            $locales = [];
        }
        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        try {
            $update['locales'] =$locales;
            $model->update($update);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }
}
