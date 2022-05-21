<?php

namespace App\Repository;


interface UserRepositoryInterface{

    //User Register
    public function userRegister($request);

    //User Login
    public function userLogin($request);

    //User Logout
    public function userLogout();

    //Create New Token
    public function createNewToken($token);

    //Refresh Token
    public function refreshToken();

    //Get User Profile
    public function getUserProfile();

    //Update Profile
    public function updateProfile($request);

}
