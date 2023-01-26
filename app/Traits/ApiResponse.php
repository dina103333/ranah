<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Return success response with data.
     *
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public function success(string $message,array $data, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function successSingle(string $message,$data, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Return error response with message.
     *
     * @param string $message
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public function error(string $message, int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => []
        ], $code);
    }
}
