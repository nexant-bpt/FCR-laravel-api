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


//Temp
Route::get('clients', 'ClientController@index');
Route::get('clients/{clientId}', 'ClientController@index');

Route::post('clients', 'ClientController@store');
Route::put('clients/{client}', 'ClientController@update');
Route::delete('clients/{clientId}', 'ClientController@delete');

Route::group(['middleware' => 'auth:api'], function() {

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
