<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


use Auth;

class UserController extends Controller
{

    public function index()
    {

        $users = User::all();

        return response()->json([
            $users
        ]);
    }

    // public function login(Request $request)
    // {



    //     $rules = [
    //         'UserEmail' => 'required|email|max:255',
    //         'password' => 'required|confirmed',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     // sign the user in
    //     if (!auth()->attempt($request->only('UserEmail', 'password'), $request->remember)) {
    //         // redirect
    //         return response()->json(['message' => 'failed login'], 500);
    //     }

    //     $user = User::where('UserEmail', '=', $request->UserEmail)->firstOrFail();
    //     return response()->json([$user], 200);

    // }

    public function login(Request $request)
    {



        //$data = $request->all();
        $rules = [
            'UserEmail' => 'required|email|max:255',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator && $validator->passes()) {

            $existingUser = User::where('UserEmail', $request->input('UserEmail'))->first();
            if ($existingUser) {
                if (!auth()->attempt($request->only('UserEmail', 'password'), $request->remember)) {
                    // redirect
                    return response()->json(['password' => 'Incorrect login information', 'email' => 'Incorrect login information'], 500);
                }

                $user = User::where('UserEmail', '=', $request->UserEmail)->firstOrFail();
                return response()->json([$user], 200);
            } else {
                return response()->json([
                    'email' => 'there is no user with this email address' . $request->input('UserEmail'),
                ], 409);
            }
        } else {
            //TODO Handle your error
            return response()->json(
                $validator->errors(),
                500
            );
        }
    }

    public function register(Request $request)
    {

        //$data = $request->all();
        $rules = [
            'UserName' => 'required|max:255',
            'UserEmail' => 'required|email|max:255',
            'password' => 'required|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator && $validator->passes()) {

            $existingUser = User::where('UserEmail', $request->input('UserEmail'))->first();

            if ($existingUser) {
                return response()->json([
                    'email' => 'there is already a user with the email ' . $request->input('UserEmail'),
                ], 409);
            } else {
                // store user
                $user = User::create([
                    'UserName' => $request->UserName,
                    'UserEmail' => $request->UserEmail,
                    'password' => Hash::make($request->password),
                ]);

                // sign the user in
                auth()->attempt($request->only('UserEmail', 'password'));

                return response()->json([
                    $user,
                    // $existingUserTwo,
                ], 201);
            }
        } else {
            //TODO Handle your error
            return response()->json(
                $validator->errors(),
                500
            );
        }
    }

    public function update(Request $request, $userId)
    {




        $user = User::findOrFail($userId);


        $user->update($request->all());

        // query goes here
        return response()->json([
            $user
        ], 200);
    }
    public function show(Request $request, $userId)
    {
        $user = User::find($userId);

        return response()->json([
            $user
        ], 202);
    }

    public function destroy(Request $request, $userId)
    {

        $rules = [
            'userId' => 'required',
        ];

        if($userId){
            $userId = intval($userId);
        }
       
        $validator = Validator::make(["userId" => $userId], $rules);
        if ($validator && $validator->passes()) {

            $existingUser = User::where('UserID', $userId)->first();

            // If there's an existing user for that id, we will continue
            if ($existingUser) {
                // Delete user item from database
                User::where('UserID', $userId)->delete();
                return response()->json([
                    'success' => 'successfully deleted the user with the UserID of ' . $userId,
                ], 202);
                
            } else {
                return response()->json([
                    'message'=>"There's no user with the UserId of " . $userId,
                ], 500);
            }
        } else {
            //TODO Handle your error
            return response()->json(
                $validator->errors(),
                500
            );
        }

   
        // query goes here
    }
}
