<?php


namespace App\Modules\Common\Collections;


use Illuminate\Http\Resources\Json\ResourceCollection;

class CommonCloudCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'status' => true,
            'data' => $this->collection,
        ];
    }
}
