<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api\v1', 'prefix' => '/'], function() {
    /*
    |--------------------------------------------------------------------------
    | Registration API
    |--------------------------------------------------------------------------
    */
    Route::post('register', 'UserController@register');

    /*
    |--------------------------------------------------------------------------
    | Authentication / Login API
    |--------------------------------------------------------------------------
    */
    Route::post('login', 'AuthController@login')->middleware("throttle:5,5");

    /*
    |--------------------------------------------------------------------------
    | Authenticated Users
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['auth:sanctum']], function () {

        /*
        |--------------------------------------------------------------------------
        | Order API
        |--------------------------------------------------------------------------
        */
        Route::post('order', 'ProductController@order')->middleware("throttle:5,2");
    });
});
