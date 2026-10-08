<?php


namespace App\Modules\Setting\Collections;


use App\Presenters\ShowThumbImagePresenter;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BannerCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $showThumbImagePresenter = new ShowThumbImagePresenter();
        foreach ($this->collection as $key => $value) {
            $this->collection[$key]['true_path'] = '/' . $value->path;
            $this->collection[$key]['path'] = '/' . $value->path;
//            $this->collection[$key]['path'] = '/' . $showThumbImagePresenter->showImage($value->path);
        }
        return [
            'code' => 0,
            'data' => $this->collection,
            'count' => $this->resource->total()
        ];
    }
}
