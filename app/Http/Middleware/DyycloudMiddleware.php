<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DyycloudMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = [];
        $response['status'] = false;
        if ($token = $request->headers->get('token')) {
            if ($token === app('settings')['setting']['website_token']) {
                return $next($request);
            } else {
                $response['error_msg'] = '传入的token不匹配';
            }
        } else {
            $response['error_msg'] = '请传入token';
        }
        throw (new HttpResponseException(response()->json($response, Response::HTTP_BAD_REQUEST)));
    }
}
