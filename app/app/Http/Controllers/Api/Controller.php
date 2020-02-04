<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param array|string $data response content
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($data)
    {
        return response()->json([
            'status' => true,
            'response' => $data,
        ], 200);
    }

    /**
     * @param array|string $data response content
     * @param int $code response HTTP code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($data, $code)
    {
        return response()->json([
            'status' => false,
            'errors' => $data,
        ], $code);
    }
}
