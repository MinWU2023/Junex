<?php
namespace App\Modules\Url\Controllers;

use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Url\Models\Url;

class UrlController extends BaseController
{


    public function __construct(Url $url)
    {
        $this->modelName = 'Url';
        $this->model = $url;
        $this->viewPath = 'Url.Views';
    }


    public function index()
    {
        $request = \request();
        $url = $request->get('url');
        $urlable_type = $request->get('urlable_type');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(Url::withTrashed()->orderByDesc('deleted_at'), function ($query) use ($request) {
                if ($urlable_type = $request->get('urlable_type')) {
                    $query->where('urlable_type',$urlable_type);
                }
                if ($urlable_id = $request->get('urlable_id')) {
                    $query->where('urlable_id',$urlable_id);
                }
                if ($url = $request->get('url')){
                    $query->where('url','like','%'.$url.'%');
                }
            })->paginate($request->input('limit', 15));
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);
            }
        }
        return view($this->viewPath . '.index', compact('url','urlable_type'));
    }


    public function destroy($id)
    {
        $url = Url::onlyTrashed()->find($id);
        $url->forceDelete();
        return $this->success();
    }


}
