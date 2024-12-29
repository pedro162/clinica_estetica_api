<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ApiResponseClass
{
    public static function throw($e, $message = "Something went wrong! Proccess not completed", $code = 500)
    {
        Log::info($e);
        
        throw new HttpResponseException(response()->json([
            'message' => $message,
            'error' => $message,
            'errors' => $message
        ], $code));
    }

    public static function sendRequest($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'data' => $result,
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }
}
