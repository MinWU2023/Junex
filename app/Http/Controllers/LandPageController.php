<?php

namespace App\Http\Controllers;

use App\Modules\Url\Models\Url;
use Illuminate\Http\Request;

class LandPageController
{

    public function show(){
        $data = Url::getUrlable();
        return view('pages.'.$data->area_name.'.index',compact('data'));
    }

    public function lock(){
        if (session('lock_active')){
            return redirect('/');
        }
        return view('layouts.front.lock');
    }

    public function lockSubmit(Request $request){
        $lock_password = $request->post('lock_password');
        if (app('settings')['setting']->home_lock_password===$lock_password){
            session()->put('lock_active',1);
            return redirect('/');
        }
        return  redirect()->back()->withErrors('Password mistake');
    }

}
