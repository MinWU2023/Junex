<?php


namespace App\Modules\Common\Collections;


use Illuminate\Http\Resources\Json\ResourceCollection;

class CommonCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'code' => 0,
            'data' => $this->collection,
        ];
    }
}
