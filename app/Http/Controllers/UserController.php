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

    public function login(Request $request)
    {

        // validation
        $this->validate($request, [
            'UserEmail' => 'required|email|max:255',
            'password' => 'required',
        ]);


        // sign the user in
        if (!auth()->attempt($request->only('UserEmail', 'password'), $request->remember)) {
            // redirect
            return response()->json(['message' => 'failed login'], 500);
        }

        $user = User::where('UserEmail', '=', $request->UserEmail)->firstOrFail();
        return response()->json([$user], 200);
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

            $existingUser = User::where('UserEmail', '=', $request->UserEmail)->firstOrFail();
            if ($existingUser) {
                return response()->json([
                    'message' => 'there is already a user with this email address',
                ], 409);
            }

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
            ], 201);
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

    public function destroy(Request $request)
    {

        $user = User::findOrFail($request);
        $user->delete();

        return response()->json([
            'success' => 'delete an item',
        ], 202);
        // query goes here
    }
}
