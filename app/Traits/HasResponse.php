<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

trait HasResponse
{
    public function success($data, $statusCode = 200, $status = "success", $message = "Success"): JsonResponse
    {
        return response()->json(["status" => $status, 'message' => $message, 'data' => $data], $statusCode);
    }

    public function error($message, $statusCode = 500): JsonResponse
    {
        return response()->json(["status" => "error", 'message' => $message], $statusCode);
    }
    public function successResponse($data,$accessToken, $statusCode = 200, $status = "success", $message = "Success"): JsonResponse
    {
        return response()->json(["status" => $status, 'message' => $message, 'data' => array('user' => $data, 'token'=>$accessToken)], $statusCode);
    }
}