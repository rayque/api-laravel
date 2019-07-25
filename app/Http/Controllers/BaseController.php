<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * @param $message
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($message, $data, $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];

        return response()->json($response, $code);
    }

    /**
     * @param $message
     * @param $errorMessages
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($message, $errorMessages = [], $code = 500)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
