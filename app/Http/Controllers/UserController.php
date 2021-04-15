<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


use Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $userStatus = 1;
        $users = DB::table('users')->where('UserStatus', '=', $userStatus)->select("UserID", "isBPC", 'F9AgentID', 'UserName', 'UserEmail', 'BPCUserID', 'created_at')->paginate(15);


        return response()->json(
            $users
        , 200);
    }
    public function minimumData()
    {


        $userStatus = 1;
        $users = DB::table('users')->where('UserStatus', '=', $userStatus)->select("UserID", 'UserName', 'F9AgentID')->get();


        return response()->json(
            $users
        , 200);
    }

 

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
                    return response()->json(['password' => 'Incorrect login information'], 500);
                }
                $user = User::where('UserEmail', '=', $request->UserEmail)->get(["UserID", "UserEmail", "UserEmail", "isBPC", "F9AgentID", "Role", "BPCUserID", "created_at", "updated_at", "LastTimeActive"]);
 
                return response()->json([$user], 200);
            } else {
                return response()->json([
                    'UserEmail' => 'there is no user with this email address' . $request->input('UserEmail'),
                ], 409);
            }
        } else {

            $errors = $validator->messages();
            Log::debug($errors);

            //TODO Handle your error
            return response()->json($errors,
                500
            );
        }
    }

    public function register(Request $request)
    {

        $users = User::all();
        $UserID = strval($users->count() + 1 + time());

        //$data = $request->all();
        $rules = [
            'UserName' => 'required|max:255',
            'UserEmail' => 'required|email|max:255',
            'password' => 'required|confirmed',
            'password_confirmation'=> 'required'
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
                    'UserID' => $UserID
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

    public function create(Request $request)
    {
        $users = User::all();
        $UserID = strval($users->count() + 1 + time());

        //$data = $request->all();
        $rules = [
            'UserName' => 'required|max:255',
            'UserEmail' => 'required|email|max:255',
            'password' => 'required|confirmed',
            'password_confirmation'=> 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator && $validator->passes()) {

            $existingUser = User::where('UserEmail', $request->input('UserEmail'))->first();

            if ($existingUser) {
                return response()->json([
                    'UserEmail' => 'there is already a user with the email ' . $request->input('UserEmail'),
                ], 409);
            } else {
                // store user
                $user = User::create([
                    'UserName' => $request->UserName,
                    'UserEmail' => $request->UserEmail,
                    'password' => Hash::make($request->password),
                    'UserID' => $UserID

                ]);

                Log::debug("THIS IS CREATE USERS USER");

                Log::debug($user);

                Log::debug("THIS IS CREATE USERS USER");

                return response()->json([
                    'UserID'=> $user->UserID,
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


    public function updateUserDetails(Request $request)
    {
      
        $rules = [
            'UserID' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator && $validator->passes()) {


          $existingUser = User::where('UserID', $request->UserID)->first();
        

            // If there's an existing user for that id, we will continue
            if ($existingUser) {
                // We check to see if they are trying to change their email 
                if($existingUser->UserEmail !== $request->UserEmail){
                    $existingUserWithEmail = User::where('UserEmail', $request->UserEmail)->first();
                    // if there's already a user with that email. 
                    // we send back a message
                    if($existingUserWithEmail){
                        return response()->json([
                            'UserEmail'=>"This email is already taken by another user",
                        ], 409);
                    } 
                }

                // We find the user and update it
                $user = User::where('UserID', $request->UserID)->update([
                    'isBPC' => $request->isBPC,
                    'UserName' => $request->UserName,
                    'F9AgentID' => $request->F9AgentID,
                    'Role' => $request->Role,
                    'UserEmail' => $request->UserEmail
                ]);
                // send back the changes
                return response()->json([
                    $user
                ], 200);
                
                
            } else {
                // If there's no user with that id, we send a message back
                return response()->json([
                    'message'=>"There's no user with the UserId of " . $request->UserID,
                ], 500);
            }



      

    }else {
            //TODO Handle your error
            return response()->json(
                $validator->errors(),
                500
            );
        }
    }
    public function show(Request $request, $userId)
    {
 
        $user = DB::table('users')->where('UserID', '=', $userId)->select("UserID", "isBPC", 'F9AgentID', 'UserName', 'UserEmail', 'BPCUserID', 'Role', 'created_at')->first();


        return response()->json(
            $user
        , 200);
    }

    public function destroy(Request $request, $userId)
    {

        $rules = [
            'userId' => 'required',
        ];

        
       
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
