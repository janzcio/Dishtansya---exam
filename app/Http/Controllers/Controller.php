<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Generate Created Response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function generateCreatedResponse($data = [])
    {
        $arr = [
            'status' => 'Success',
            'description' => 'Created'
        ];
        
        return response()->json($data ?? $arr, 201);
    } 
}
