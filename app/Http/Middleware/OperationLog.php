<?php

namespace App\Http\Middleware;

use App\Modules\Admin\Models\AdminLog;
use App\Modules\Admin\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Facades\Agent;


class OperationLog
{
    public function handle(Request $request, Closure $next)
    {
//        if (!Auth::guest()){
//            $model = new AdminLog();
//            $model->user_id = Auth::id();
//            $model->ip = $request->ip();
//            if ($request->method() == 'GET'){
//                return $next($request);
//            }
//            if (isset($request->route()->action['as'])){
//                $permission_name= Permission::where('name',$request->route()->action['as'])->first();
//                if ($permission_name){
//                    $model->name =$permission_name->display_name;
//                }
//            }
//            $model->path = $request->path();
//            $model->browser = Agent::getUserAgent();
//            $model->content = json_encode($request->all());
//            $model->created_at = date('Y-m-d H:i:s');
//            $model->save();
//        }
        return $next($request);
    }
}

