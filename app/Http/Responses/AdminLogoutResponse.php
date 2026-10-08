<?php


namespace App\Http\Responses;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class AdminLogoutResponse implements LogoutResponseContract
{

    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new JsonResponse(['code' => 0], 201)
            : redirect()->route('admin.login');
    }
}
