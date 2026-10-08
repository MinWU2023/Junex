<?php


namespace App\Modules\Product\Controllers;

use Addons\Keywords\Collections\KeywordsCollection;
use App\Modules\Common\Collections\CommonCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Models\ProductTag;
use App\Modules\Report\Controllers\DataManagerController;
use Illuminate\Http\Request;

class KeywordRankController extends BaseController
{

    protected $orderBy = 'sort';

    /**
     * ProductBrandController constructor.
     * @param ProductTag $productTag
     * @param Request $request
     */

    public function __construct(ProductTag $productTag)
    {
        $this->modelName = 'ProductTag';
        $this->modelSource =  $productTag;
        $this->model = $productTag;
        $this->viewPath = 'Product.Views.rank';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'translate.' . config('app.locale') . '.name' => 'required'
        ];
    }


    public function index()
    {
        $keyword_active = in_array('Keywords',app('myAddons'));
        if (!$keyword_active){
            return view($this->viewPath . '.index',compact('keyword_active'));
        }
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(\Addons\Keywords\Models\ProductTag::with(['translations','productRanks'=>function($query){
                $query->orderBy('id','desc');
            }]),function ($query)use($request,$name){
                if ($name){
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            })->orderByDesc('is_rank')->orderBy('current_rank')->paginate($request->input('limit', 15));
            return new KeywordsCollection($data);
        }
        return view($this->viewPath . '.index',compact('keyword_active','name'));
    }


    public function export(){
        $data = [
            [
                '关键词',
                '排名url',
                '谷歌排名',
                '更新时间'
            ],
        ];
        $ranks = tap(\Addons\Keywords\Models\ProductTag::with(['translations','productRanks'=>function($query){
            $query->orderBy('id','desc');
        }]))->orderByDesc('is_rank')->orderBy('current_rank')->get();
        $ranks  = DataManagerController::changeKeywordsData($ranks);
        foreach ($ranks as $rank) {
            $temp = [
                $rank['name'],
                $rank['discrepancy']['catch_url'],
            ];
            $a = $rank['current_rank'];
            if ($rank['discrepancy']['type']){
                if ($rank['discrepancy']['type'] === 'up'){
                    $a.='(上升'.$rank['discrepancy']['num'].')';
                }else{
                    $a.='(下降'.$rank['discrepancy']['num'].')';
                }
            }
            $temp[] = $a;
            $temp[] = $rank['discrepancy']['check_date'];

            $data[] = $temp;
        }
        return new CommonCollection($data);
    }
}
