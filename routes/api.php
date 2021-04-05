<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

Route::get('/testing', function () {
    return ['message' => 'hello world'];
});


Route::post('/register', [RegisterController::class, 'store']);

//Temp
// START OF CLIENTS
Route::get('clients', [ClientController::class, 'index']);
Route::get('clients/{ClientId}', [ClientController::class, 'show']);
Route::post('clients/create', [ClientController::class, 'store']);
Route::post('clients/details/{ClientId}', [ClientController::class, 'updateClientDetails']);
Route::patch('clients/logo', [ClientController::class, 'updateClientLogo']);

Route::delete('clients/{clientId}', 'ClientController@delete');

// END OF CLIENTS

// START OF USERS
Route::get('users', [UserController::class, 'index']);
Route::get('users/{userId}', [UserController::class, 'show']);
Route::post('users/login', [UserController::class, 'login']);
Route::post('users/register', [UserController::class, 'register']);
Route::post('users/create', [UserController::class, 'create']);

Route::post('users/details', [UserController::class, 'updateUserDetails']);

Route::delete('users/{userId}', [UserController::class, 'destroy']);

// END OF USERS

Route::group(['middleware' => 'auth:api'], function() {

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
