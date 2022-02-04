<?php

namespace App\Services\Users;
use App\Models\User;

class GetUserByEmail
{
   /**
    * Get User By Email
    */
    public function execute($email)
    {
        return User::where('email', $email)->first();
    }
}
