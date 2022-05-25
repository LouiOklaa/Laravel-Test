<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//All Auth Routes
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'Profile']);
    Route::put('/me', [AuthController::class, 'Profile_Update']);
});

//All Products Routes
Route::group([
    'middleware' => ['jwt.verify']

], function() {
    Route::get('/products',[ProductsController::class,'index']);
    Route::post('/products/create',[ProductsController::class,'store']);
    Route::get('/products/{product}',[ProductsController::class,'show']);
    Route::post('/products/update/{product}',[ProductsController::class,'update']);
    Route::post('/products/destroy/{product}',[ProductsController::class,'destroy']);
});

