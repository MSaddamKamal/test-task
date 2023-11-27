<?php

namespace App\Modules\DemoTest\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiResponse
{
    /**
     * @param mixed $records
     * @param bool $success
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function response(mixed $records = null, bool $success = true, string $message = '', int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return static::rawResponse([
            'success' => $success,
            'data' => $records,
            'message' => $message
        ], $statusCode);
    }

    /**
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function rawResponse(mixed $data, int $statusCode): JsonResponse
    {
        return response()->json($data, $statusCode);
    }
}
