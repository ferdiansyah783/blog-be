<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function sendResponse($result, $message = 'success')
    {
        $response = $result ? [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ] : [
            'success' => true,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        return response()->json($response, $code);
    }
}
