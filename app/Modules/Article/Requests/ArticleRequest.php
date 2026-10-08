<?php

namespace App\Modules\Article\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.3
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {

            case 'PUT':
                return [
                    'name' => 'required',
                    'url' => 'required',
                    'banner_area_id' => 'required|exists:banner_areas,id',
                ];
                break;
            case 'POST':
                return [
                    'translate.'. config('app.locale') .'.name' => 'required',
                    'translate.'. config('app.locale') .'.content' => 'required',
                    'sort' => 'required',
                    'category_id' => 'required|exists:article_categories,id',
                ];
                break;
        }

    }

    public function messages()
    {
        return [

            'name.required' => '标题不能为空',
            'url.required' => '跳转链接不能为空',
            'banner_area_id.required' => '所属banner位不能为空',
            'banner_area_id.exists' => '所属banner位不存在',
            'path.required' => '需要上传一张图片'
        ];
    }
}
