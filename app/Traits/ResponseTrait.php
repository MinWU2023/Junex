<?php


namespace App\Traits;


use Illuminate\Http\Response;

trait ResponseTrait
{
    protected function success()
    {
        return new Response(['code' => 0], Response::HTTP_CREATED);
    }

    protected function data($data = [], $code = 0, $message = '')
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function badRequest($errorMsg = '操作失败，请联系专属客服', array $headers = [], $options = 0)
    {
        return response()->json([
            'code' => 500,
            'message' => $errorMsg
        ], Response::HTTP_BAD_REQUEST, $headers, $options);
    }
}
