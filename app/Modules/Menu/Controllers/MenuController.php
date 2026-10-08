<?php


namespace App\Modules\Menu\Controllers;

use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Menu\Models\Menu;
use Illuminate\Support\Facades\Log;

class MenuController extends BaseController
{
    public function __construct(Menu $menu)
    {
        $this->modelName = 'Menu';
        $this->model = $menu;
        $this->viewPath = 'Menu.Views';
        $this->validatorData = [
            'sort' => 'required|numeric',
        ];
    }

    public function index()
    {
        $request = \request();
        if ($request->ajax() || $request->wantsJson()) {
            $data = $this->model->orderByDesc($this->orderBy)->paginate(999);
            $this->sanitizeSelfParentRows($data);
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);

            }
        }
        return view($this->viewPath . '.index');
    }

    public function destroy($id)
    {
        $model = $this->model->with(['children'])->find($id);
        if ($model->children()->count()) {
            return $this->badRequest('无法删除此分类！原因：此分类下存在有子分类。');
        }
        try {
            $model->delete();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest('无法删除此分类！原因：分类下存在子分类。');
        }
        return $this->success();
    }
}
