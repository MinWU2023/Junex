<?php

namespace App\Modules\Setting\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\Banner;
use App\Modules\Setting\Models\Setting;

class BannerController extends BaseController
{

    private function getBannerAreas(): array
    {
        return [
            'Home',
            'Product',
            'Blog',
            'About Us',
            'Contact Us',
            'Faqs',
            'Common',
            'Inquiry',
            'Reviews',
            'Video',
            'Article',
            'Customer Services',
            'Project',
            'News',
        ];
    }

    public function __construct(Banner $banner)
    {
        $this->modelName = 'Banner';
        $this->model = $banner->with(['translations']);
        $this->modelSource =  $banner;
        $this->viewPath = 'Setting.Views.banner';
        $this->collection = '\App\Modules\Setting\Collections\BannerCollection';
        $this->validatorData = [
            'path' => 'required',
            'path_mobile' => 'nullable|string',
            'area' => 'required',
        ];
    }


    public function create()
    {
        $areas = $this->getBannerAreas();
        return view($this->viewPath . '.create', compact('areas'));
    }



    public function edit($id)
    {
        $model = $this->model->find($id);
        $areas = $this->getBannerAreas();

        $data =  $this->checkTranslate($id);
        $data['model'] = $model;
        $data['areas'] = $areas;
        return view($this->viewPath . '.edit', $data);
    }
}
