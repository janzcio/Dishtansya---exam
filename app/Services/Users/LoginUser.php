<?php

namespace App\Services\Users;
use App\Models\User;

class LoginUser
{
   /**
    * Get User By Email
    */
    public function execute(User $user)
    {

         $latest = $user->tokens()->latest()->take(5)->pluck('id');
         $user->tokens()->whereNotIn('id', $latest)->delete();
         $token = $user->createToken('my-app-token')->plainTextToken;
        
         $response = [
            'user' => $user,
            'token' => $token,
            "message" => "User successfully registered"
         ];
    
         return $response;
    }
}
