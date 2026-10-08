<?php


namespace App\Modules\Product\Collections;


use Illuminate\Http\Resources\Json\ResourceCollection;

class KeywordsCollection extends ResourceCollection{

    public function toArray($request)
    {
        foreach ($this->collection as $key => $data) {
            $discrepancy = [
                'catch_url'  => '',
                'type'  => '', //up上升，down下降
                'num' => 0 ,
                'check_date'  => '',
            ];
            if (isset($data->productRanks[0])){
                $discrepancy['catch_url'] = $data->productRanks[0]['catch_url'];
                $discrepancy['check_date'] = $data->productRanks[0]['check_date'];
                $this->collection[$key]['snapshot'] = $data->productRanks[0]['snapshot']??'javascript:void(0)';
                if (isset($data->productRanks[1]) && $data->productRanks[0]['rank']>0  && $data->productRanks[1]['rank']>0){ //之前有排名且排名有效
                    if ($data->productRanks[0]['rank'] > $data->productRanks[1]['rank']){
                        $discrepancy['type'] = 'down';
                        $discrepancy['num'] = $data->productRanks[0]['rank'] - $data->productRanks[1]['rank'] ;
                    }else{
                        if ($data->productRanks[1]['rank'] > $data->productRanks[0]['rank']){
                            $discrepancy['type'] = 'up';
                            $discrepancy['num'] = $data->productRanks[1]['rank'] - $data->productRanks[0]['rank'] ;
                        }
                    }
                }
            }
            $this->collection[$key]['discrepancy'] = $discrepancy;
        }
        return [
            'count'=>$this->resource->total(),
            'code'=>0,
            'data' => $this->collection,
        ];


    }

}
