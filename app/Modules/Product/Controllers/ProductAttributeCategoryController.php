<?php
namespace App\Modules\Product\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Models\ProductAttribute;
use App\Modules\Product\Models\ProductAttributeCategory;
use App\Modules\Product\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductAttributeCategoryController extends BaseController
{

    /**
     * ProductBrandController constructor.
     * @param ProductBrand $productAttribute
     * @param Request $request
     */

    public function __construct(ProductAttributeCategory $productAttributeCategory)
    {
        $this->modelName = 'ProductAttributeCategory';
        $this->model = $productAttributeCategory;
        $this->viewPath = 'Product.Views.attributeCategory';
        $this->validatorData = [
            'name' => 'required'
        ];
    }


    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData,$this->validatorMessages);
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $model = $this->model->find($id);
        $translate = $request->get('translate');
        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        try {
            $model->update($update);
            $attributeIds = array_keys($request->post('categories',[]));
            $model->attributes()->sync($attributeIds);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }



    public function edit($id)
    {
        $model =   ProductAttributeCategory::with(['attributes'])->find($id);
        $checkIds = array_column($model->attributes->toArray(),'id');
        $attributes = tap(ProductAttribute::with(['translations']), function($query){

        })->get();
//        $attributes = ProductAttribute::with(['translations'])->get();
        return view($this->viewPath . '.edit',
            [
                'model' => $model,
                'attributes' =>$attributes,
                'checkIds' => $checkIds
            ]
        );
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);

        $joins  =  ProductAttributeCategory::query()->with(['attributes'])->find($id)->toArray();
        if ($joins['attributes']){
            $joins  =  array_column($joins['attributes'],'name');
            return $this->badRequest('该属性已关联以下属性:'.implode(',',$joins));
        }
        try {
            $model->delete();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }



    public function getAllCategories($id)
    {
        if ($id == 0){
            $checkedData =[];
            $selectCategory =[];
        }else{
            $checkedCategories = ProductAttribute::where('id',$id)->with('categories')->first();
            if ($checkedCategories->categories){
                $checkedData = array_column($checkedCategories->categories->toArray(),'name');
                $selectCategory =array_column($checkedCategories->categories->toArray(),'name','id');
            }
        }
        $categories = ProductAttributeCategory::get();
        $data = [];
        foreach ($categories as $k=>$category){
            $data[$k]['label'] = $category->name;
            $data[$k]['id'] = $category->id;
        }

        $selectCategoryData = [];
        foreach ($selectCategory as $k=>$value){
            $selectCategoryData[]= [
                'id' => $k,
                'name' => $value
            ];
        }
        return  json_encode([
            'categories' => $data,
            'currentSelect' =>$checkedData,
            'selectCategory' =>$selectCategoryData
        ]);
    }


}
