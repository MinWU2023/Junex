<?php
namespace App\Modules\Setting\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\LandPage;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class LandPageController extends BaseController
{
    public function __construct(LandPage $landPage)
    {
        $this->modelName = 'LandPage';
        $this->model = $landPage;
        $this->viewPath = 'Setting.Views.landPage';
        $this->validatorData = [

        ];
    }


    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData, $this->validatorMessages);
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $model = $this->model->find($id);
        $translate = $request->get('translate');
        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        for ($i=1;$i<=LandPage::MAX;$i++){
            if (isset($update['plate_content_'.$i]['images'])){
                $images = $update['plate_content_'.$i]['images'];
                $new_images = [];
                foreach ($images as $k=>$imageData){
//                    'is_main' =>1,
//                        'sort' =>22,
//                        'alt' =>'aaa',
//                        'path' =>'pages/01/images/app_img1.jpg',
                    foreach ($imageData['imgPath'] as $key=>$path){
                        $new_images[$k][$key]['path'] = $path;
                        $new_images[$k][$key]['is_main'] = isset($imageData['is_main'][$key])?$imageData['is_main'][$key]:0;
                        $new_images[$k][$key]['sort'] = isset($imageData['imgSorts'][$key])?$imageData['imgSorts'][$key]:0;
                        $new_images[$k][$key]['alt'] = isset($imageData['imgAlts'][$key])?$imageData['imgAlts'][$key]:0;
                    }



                }

                $update['plate_content_'.$i]['images'] = $new_images;
            }

        }

        try {
            $model->update($update);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

}
