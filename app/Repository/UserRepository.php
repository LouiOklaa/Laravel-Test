<?php

namespace App\Repository;


use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserRepositoryInterface{

    //User Register
    public function userRegister($request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user

        ], 201);

    }

    //User Login
    public function userLogin($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'The email or password you’ve entered is incorrect.'], 401);
        }
        return $this->createNewToken($token);
    }


    //User Logout
    public function userLogout()
    {

        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);

    }

    //Create New Token
    public function createNewToken($token)
    {

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);

    }

    //Refresh Token
    public function refreshToken()
    {

        return $this->createNewToken(auth()->refresh());

    }

    //Get User Profile
    public function getUserProfile()
    {

        return response()->json(auth()->user());

    }


    //Update Profile
    public function updateProfile($request)
    {

        $id = $request->user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users,email,'.$id,
            'password' => 'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::find($request->user()->id);
        $user->update([

            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);
        return response()->json(['message' => 'Profile successfully updated!']);

    }

}
