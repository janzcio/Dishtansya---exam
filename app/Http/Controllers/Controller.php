<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Generate Created Response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function generateCreatedResponse($cusomMessage = [])
    {
        $arr = [
            'status' => 'Success',
            'description' => 'Created'
        ];
        
        return response()->json($cusomMessage ?? $arr, 201);
    } 

    /**
     * Generate bad request Response
     * @param  array $data [description]
     * @return \Illuminate\Http\JsonResponse
     */
    protected function generateBadRequest($cusomMessage = null)
    {
        $arr = [
            'status' => 'Error',
            'description' => 'Bad Request'
        ];

        return response()->json($cusomMessage ?? $arr, Response::HTTP_BAD_REQUEST);
    }
}
