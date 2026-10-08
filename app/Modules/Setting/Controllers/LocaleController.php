<?php

namespace App\Modules\Setting\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\Locale;
use App\Rules\UrlRule;

class LocaleController extends BaseController
{

    public function __construct(Locale $locale)
    {
        $this->modelName = 'Banner';
        $this->model = $locale;
        $this->viewPath = 'Setting.Views.locale';
        $this->orderBy = 'sort';
        $this->validatorData = [
            'url' => [
                'required',
                new UrlRule()
            ],
            'language_code' => [
                'required'
            ]
        ];
        $this->validatorMessages  = [
            'language_code.required' => '请选择语言代码'
        ];
    }

    public function create()
    {
        $locales = [];
        if (file_exists(storage_path('locales.txt'))){
            $locales = json_decode(file_get_contents(storage_path('locales.txt')),true);
        }
        if (!is_array($locales)){
            $locales = [];
        }
        return view($this->viewPath . '.create',compact('locales'));
    }


    public function edit($id)
    {
        $data =  $this->checkTranslate($id);
        $locales = [];
        if (file_exists(storage_path('locales.txt'))){
            $locales = json_decode(file_get_contents(storage_path('locales.txt')),true);
        }
        if (!is_array($locales)){
            $locales = [];
        }
        $data['locales'] = $locales;
        return view($this->viewPath . '.edit', $data);
    }


}
