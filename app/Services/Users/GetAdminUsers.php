<?php

namespace App\Services\Users;
use App\Models\User;

class GetAdminUsers
{
    /**
     * Get admin users
     *
     * @param [type] $param
     * @return void
     */
    public function execute()
    {
        return User::admin()->get();
    }
}
