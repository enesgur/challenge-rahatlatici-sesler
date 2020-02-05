<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var int
     *
     * Error response codes.
     */
    const ERROR_CODE_VALIDATION = 101;
    const ERROR_CODE_FORBIDDEN_USER = 102;
    const ERROR_CODE_FORBIDDEN_GUEST = 103;
    const ERROR_CODE_BEARER_TOKEN_REQUIRED = 104;
    const ERROR_CODE_AUTHENTICATION = 105;
    const ERROR_CODE_DB_ERROR = 106;
    const ERROR_CODE_GENERAL_ERROR = 107;

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
     * @param string $message
     * @param array $data
     * @param int $code
     * @param int $responseCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($message, $data, $code, $responseCode)
    {
        $return = ['status' => false, 'errorCode' => $code, 'errorMessage' => $message];
        if ($data !== null) {
            $return['data'] = $data;
        }
        return response()->json($return, $responseCode);
    }
}
