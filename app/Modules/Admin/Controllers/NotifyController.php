<?php


namespace App\Modules\Admin\Controllers;


use App\Http\Controllers\Controller;

class NotifyController extends Controller
{
    public function success()
    {
        return view('Admin.Views.Notify.success');
    }
}
