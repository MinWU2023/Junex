<?php


namespace App\Modules\Product\Collections;


use App\Presenters\ShowThumbImagePresenter;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class ProductListCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $showThumbImagePresenter = new ShowThumbImagePresenter();
        foreach ($this->collection as $key => $value) {
            foreach ($value->productImages as $k => $v) {
                if ($v->is_main) {
                    $this->collection[$key]['path'] = '/' . $showThumbImagePresenter->showImage100($v->path);
                    $this->collection[$key]['true_path'] = '/' . $v->path;
                }
            }
            if ($request->user()->id === 3 && config('app.pre_product')) {
                $this->collection[$key]['url_key'] = '/preProduct/' . $value->id;
                $this->collection[$key]['url_key_view'] = url('preProduct/' . $value->id);

            }else{
//                $this->collection[$key]['url_key'] = $this->collection[$key]['url_key'];
                $this->collection[$key]['url_key_view'] = url($this->collection[$key]['url_key']);
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
