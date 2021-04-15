<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProgramController;
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

// START OF CLIENTS
Route::get('clients', [ClientController::class, 'index']);
Route::get('minimum/clients', [ClientController::class, 'minimumData']);

Route::get('clients/{ClientId}', [ClientController::class, 'show']);
Route::post('clients/create', [ClientController::class, 'store']);
Route::post('clients/details/{ClientId}', [ClientController::class, 'updateClientDetails']);
Route::patch('clients/logo', [ClientController::class, 'updateClientLogo']);
Route::delete('clients/{clientId}', 'ClientController@delete');
// END OF CLIENTS


// START OF CUSTOMERS
Route::get('customers', [CustomerController::class, 'index']);
Route::get('minimum/customers', [CustomerController::class, 'minimumData']);

Route::get('customers/{CustomerID}', [CustomerController::class, 'show']);
Route::post('customers/create', [CustomerController::class, 'store']);
Route::post('customers/details/{CustomerID}', [CustomerController::class, 'updateCustomerDetails']);
Route::delete('customers/{CustomerID}', 'ClientController@delete');
// END OF CUSTOMERS


// START OF PROGRAMS
Route::get('programs', [ProgramController::class, 'index']);
Route::get('minimum/programs', [ProgramController::class, 'minimumData']);
Route::get('programs/{ProgramId}', [ProgramController::class, 'show']);
Route::post('programs/create', [ProgramController::class, 'store']);
Route::post('programs/details/{ProgramId}', [ProgramController::class, 'updateProgramDetails']);
// END OF PROGRAMS

// START OF CALL LOGS
Route::get('call-logs', [ClientController::class, 'index']);
Route::get('call-logs/{CallLogId}', [ClientController::class, 'show']);
Route::post('call-logs/create', [ClientController::class, 'store']);
Route::post('call-logs/details/{CallLogId}', [ClientController::class, 'updateCallLogDetails']);
Route::delete('call-logs/{CallLogId}', [ClientController::class, 'destroy']);
// END OF CALL LOGS

// START OF USERS
Route::get('users', [UserController::class, 'index']);
Route::get('minimum/users', [UserController::class, 'minimumData']);

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
