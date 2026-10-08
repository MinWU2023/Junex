<?php


namespace App\Modules\Product\Collections;


use App\Presenters\ShowThumbImagePresenter;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagProductsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'code' => 0,
            'data' => $this->collection,
            'count' => $this->resource->total()
        ];
    }
}
