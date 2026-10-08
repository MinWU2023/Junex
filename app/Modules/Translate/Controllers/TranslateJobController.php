<?php

namespace App\Modules\Translate\Controllers;

use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Translate\Models\TranslateJob;

/**
 * Class CategoryController
 * @package App\Modules\Category\Controllers
 */
class TranslateJobController extends BaseController
{
    protected $orderBy = 'updated_at';

    public function __construct(TranslateJob $translateJob)
    {
        $this->modelName = 'TranslateJob';
        $this->model = $translateJob;
        $this->viewPath = 'Translate.Views';
    }

    public function index()
    {
        $request = \request();
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap($this->model->orderByDesc($this->orderBy), function ($query) use ($request) {
                if ($source_id = $request->get('source_id')) {
                    $query->where('source_id',$source_id);
                }
            })->paginate($request->input('limit', 15));
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);

            }
        }
        return view($this->viewPath . '.index');
    }
}
