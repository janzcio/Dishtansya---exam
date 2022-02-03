<?php

namespace App\Services\Users;
use App\Models\User;

class CreateUser
{
    /**
     * Store user
     *
     * @param array $param
     * @return void
     */
    public function execute($param)
    {
        return User::create([
            'name' => $param['name'],
            'password' => bcrypt($param['password']),
            'email' => $param['email']
        ]);
    }
}
