<?php
namespace App\Traits\Library;


trait  UtilityHelper
{
    public static function responseSuccess($data, $message = 'Request successful', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function responseError($message = 'Request failed', $error = null, $code = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error
        ], $code);
    }
}
