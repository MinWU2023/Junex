<?php

namespace App\Modules\Setting\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\Setting\Models\Slogan;


class SloganController extends BaseController
{

    public function __construct(Slogan $slogan)
    {
        $this->modelName = 'Slogan';
        $this->model = $slogan->with(['translations']);
        $this->modelSource =  $slogan;
        $this->viewPath = 'Setting.Views.slogan';
        $this->validatorData = [
            'type' => 'required',
            'translate.'.config('app.locale').'.name' => 'required'
        ];
    }

}
