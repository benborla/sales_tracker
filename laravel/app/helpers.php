<?php

use Illuminate\Http\Response;

/**
 * Returns the difference in minutes
 */
if (!function_exists('json_abort_if')) {
    function json_abort($message, $code = Response::HTTP_UNAUTHORIZED)
    {
        // abort_if($condition, $code, 'No Access');
        return response()->json(['error' => $message], $code, ['Content-Type' => 'application/json']);
    }
}
