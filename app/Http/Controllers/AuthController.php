<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $User;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $User) {

        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->User = $User;

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){

        return $this->User->userLogin($request);

    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {

        return $this->User->userRegister($request);

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {

        return $this->User->userLogout();

    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {

        return $this->User->refreshToken();

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Profile() {

        return $this->User->getUserProfile();

    }

    public function Profile_Update(Request $request){

        return $this->User->updateProfile($request);

    }

}
