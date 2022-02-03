<?php

namespace App\Exceptions\Users;

use Exception;

class UnauthorizedException extends Exception
{
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {        
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }
}
