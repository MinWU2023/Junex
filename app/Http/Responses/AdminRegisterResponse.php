<?php


namespace App\Http\Responses;


use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class AdminRegisterResponse implements RegisterResponseContract
{

    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new JsonResponse(['code' => 0], 201)
            : redirect(config('fortify.home'));
    }
}
