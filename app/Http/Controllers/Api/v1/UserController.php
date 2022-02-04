<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Users\LoginUser;
use App\Services\Users\CreateUser;
use App\Http\Controllers\Controller;
use App\Services\Users\GetAdminUsers;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegisteredUserNotification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Register user
     *
     * @param RegisterUserRequest $registerUserRequest
     * @param CreateUser $createUser
     * @param GetAdminUsers $getAdminUsers
     * @return \Illuminate\Http\Response
     */
    public function register(
                            RegisterUserRequest $registerUserRequest, 
                            CreateUser $createUser,
                            GetAdminUsers $getAdminUsers
                            ){
                            
        $user = $createUser->execute($registerUserRequest->all());
        
        $admins = $getAdminUsers->execute();
        
        Notification::send($admins, new RegisteredUserNotification($user));
        
        return $this->generateCreatedResponse(["message" => "User successfully registered"]);
    }
}
