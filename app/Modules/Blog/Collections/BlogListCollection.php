<?php


namespace App\Modules\Blog\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogListCollection extends ResourceCollection
{

    public function toArray($request)
    {
        foreach ($this->collection as $key=>$value){
            if (isset($this->collection[$key]->url_key)){
                $this->collection[$key]->url_key = $value->url_key;
                $this->collection[$key]->url_key_view = url($value->url_key);
            }
               // 添加定时发布时间
            if (isset($value->scheduledPublish) && $value->scheduledPublish) {
                $this->collection[$key]['scheduled_publish_at'] = $value->scheduledPublish->publish_at->format('Y-m-d H:i:s');
            } else {
                $this->collection[$key]['scheduled_publish_at'] = null;
            }
        }
        return [
            'code' => 0,
            'data' => $this->collection,
            'count' => $this->resource->total()
        ];
    }
}
