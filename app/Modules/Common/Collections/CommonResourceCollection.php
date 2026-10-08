<?php


namespace App\Modules\Common\Collections;


use Illuminate\Http\Resources\Json\ResourceCollection;

class CommonResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        foreach ($this->collection as $k=>$item){
            if (isset($this->collection[$k]->url_key)){
                $this->collection[$k]->url_key = $item->url_key;
                $this->collection[$k]->url_key_view = url($item->url_key);
            }
        }
        return [
            'code' => 0,
            'data' => $this->collection,
            'count' => $this->resource->total()
        ];
    }
}
