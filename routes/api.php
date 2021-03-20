<?php

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
Route::get('clients', 'ClientController@index');
Route::get('clients/{clientId}', 'ClientController@show');
Route::post('clients', 'ClientController@store');
Route::put('clients/{client}', 'ClientController@update');
Route::delete('clients/{clientId}', 'ClientController@delete');

// END OF CLIENTS

// START OF USERS
Route::get('users', 'UserController@index');
Route::get('users/{userId}', 'UserController@show');
Route::post('users/register', 'UserController@register');
Route::post('users/login', 'UserController@login');



// END OF USERS

Route::group(['middleware' => 'auth:api'], function() {

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
