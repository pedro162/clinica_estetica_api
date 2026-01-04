<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use \Illuminate\Http\JsonResponse;
use Throwable;

class ApiResponseClass
{
    /**
     * Throws an http response exception
     *
     * @param Throwable $e
     * @param string $message
     * @param integer $code
     * @throws HttpResponseException
     */
    public static function throw(\Exception $e, $message = "Something went wrong! Proccess not completed", $code = 500): never
    {
        Log::info($e);

        throw new HttpResponseException(response()->json([
            'message' => $message,
            'error' => $message,
            'errors' => [$message]
        ], $code));
    }

    /**
     * Maps the json response
     *
     * @param mixed $result
     * @param mixed $message
     * @param integer $code
     * @return JsonResponse
     */
    public static function sendRequest($result, $message, $code = 200): JsonResponse
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
