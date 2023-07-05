<?php

use App\Http\Controllers\UserController;
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
//get all data
Route::get('usersData', [UserController::class, 'getData']);


//user registration
Route::post('register', [UserController::class, 'register']);

//user Login
Route::post('login', [UserController::class, 'login']);

//user authentication
Route::group(['middleware' => ['auth:sanctum']], function () {

    //get single data
    Route::get('getUser/{id}', [UserController::class, 'getUser']);

    //update user
    Route::put('update/{id}', [UserController::class, 'updateUser']);

    //delete user
    Route::delete('delete/{id}', [UserController::class, 'destroy']);

    //user logout
    Route::post('logout', [UserController::class, 'logout']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
