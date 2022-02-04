<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\Users\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Services\Users\GetUserByEmail;
use App\Services\Users\LoginUser;
use App\Services\Users\VerifyPassword;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(
        UserLoginRequest $userLoginRequest,
        GetUserByEmail $getUserByEmail,
        VerifyPassword $verifyPassword,
        LoginUser $loginUser
    ){
        $user = $getUserByEmail->execute($userLoginRequest->input('email'));
        if( !isset($user) ) {
            throw new UnauthorizedException();
        }

        $password = $verifyPassword->execute($user, $userLoginRequest->input('password'));
        if(!$password) {                           
            throw new UnauthorizedException();
        }

        $response = $loginUser->execute($user);

        return $this->generateCreatedResponse(["access_token" => $response["token"]]);  
    }
}
