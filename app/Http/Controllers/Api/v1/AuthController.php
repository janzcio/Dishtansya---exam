<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Users\LoginUser;
use App\Http\Controllers\Controller;
use App\Services\Users\GetUserByEmail;
use App\Services\Users\VerifyPassword;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Exceptions\Users\UnauthorizedException;
use App\Exceptions\Users\FailedAttemptsException;

class AuthController extends Controller
{
    public function login(
        UserLoginRequest $userLoginRequest,
        GetUserByEmail $getUserByEmail,
        VerifyPassword $verifyPassword,
        LoginUser $loginUser
    ){
        $this->ensureIsNotRateLimited();

        $user = $getUserByEmail->execute($userLoginRequest->input('email'));
        if( !isset($user) ) {
            RateLimiter::hit($this->throttleKey(), (60*5));
            throw new UnauthorizedException();
        }

        $password = $verifyPassword->execute($user, $userLoginRequest->input('password'));
        if(!$password) {                
            RateLimiter::hit($this->throttleKey(), (60*5));           
            throw new UnauthorizedException();
        }

        $response = $loginUser->execute($user);

        RateLimiter::clear($this->throttleKey());

        return $this->generateCreatedResponse(["access_token" => $response["token"]]);  
    }

    private function throttleKey(){
        return Str::lower(request()->input('email')) . '|' . request()->ip();
    }

    private function ensureIsNotRateLimited(){
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return 1;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());
        
        throw new FailedAttemptsException();
    }
}
