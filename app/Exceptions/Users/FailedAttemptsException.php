<?php

namespace App\Exceptions\Users;

use Exception;

class FailedAttemptsException extends Exception
{
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {        
        return response()->json([
            'message' => 'You are being locked out due to several fail attempts.',
        ], 429);
    }
}
