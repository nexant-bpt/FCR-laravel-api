<?php

namespace App\Http\Controllers;

use App\Models\CallLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CallLogController extends Controller
{
    //

    public function index()
    {
        $call_logs = DB::table('call_logs')->paginate(15);


        return response()->json(
            $call_logs
        , 200);
    }

 



    public function store(Request $request)
    {

        //$data = $request->all();
        $rules = [
            'UserName' => 'required|max:255',
            'UserEmail' => 'required|email|max:255',
            'password' => 'required|confirmed',
            'password_confirmation'=> 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator && $validator->passes()) {

            $existingUser = CallLog::where('UserEmail', $request->input('UserEmail'))->first();

            if ($existingUser) {
                return response()->json([
                    'UserEmail' => 'there is already a user with the email ' . $request->input('UserEmail'),
                ], 409);
            } else {
                // store user
                $call_log = CallLog::create([
                    'UserName' => $request->UserName,
                    'UserEmail' => $request->UserEmail,
                    'password' => Hash::make($request->password),
                ]);

                

                return response()->json([
                    'CallLogId'=> $call_log->id,
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

    public function update(Request $request, $callLogId)
    {




        $call_log = CallLog::findOrFail($callLogId);


        $call_log->update($request->all());

        // query goes here
        return response()->json([
            $call_log
        ], 200);
    }


    public function updateCallLogDetails(Request $request)
    {
      
        $rules = [
            'UserID' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator && $validator->passes()) {


          $existingUser = CallLog::where('UserID', $request->UserID)->first();
        

            // If there's an existing user for that id, we will continue
            if ($existingUser) {
                // We check to see if they are trying to change their email 
                if($existingUser->UserEmail !== $request->UserEmail){
                    $existingUserWithEmail = CallLog::where('UserEmail', $request->UserEmail)->first();
                    // if there's already a user with that email. 
                    // we send back a message
                    if($existingUserWithEmail){
                        return response()->json([
                            'UserEmail'=>"This email is already taken by another user",
                        ], 409);
                    } 
                }

                // We find the user and update it
                $user = CallLog::where('UserID', $request->UserID)->update([
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
    public function show(Request $request, $callLogId)
    {
        
        $call_log = DB::table('call_log')->where('UserID', '=', $callLogId)->select("UserID", "isBPC", 'F9AgentID', 'UserName', 'UserEmail', 'BPCUserID', 'Role', 'created_at')->first();


        return response()->json(
            $call_log
        , 200);
    }

    public function destroy(Request $request, $callLogId)
    {

        $rules = [
            'callLogId' => 'required',
        ];

        if($callLogId){
            $callLogId = intval($callLogId);
        }
       
        $validator = Validator::make(["callLogId" => $callLogId], $rules);
        if ($validator && $validator->passes()) {

            $existingUser = CallLog::where('callLogId', $callLogId)->first();

            // If there's an existing user for that id, we will continue
            if ($existingUser) {
                // Delete user item from database
                CallLog::where('callLogId', $callLogId)->delete();
                return response()->json([
                    'success' => 'successfully deleted the Call Log with the CallLogId of ' . $callLogId,
                ], 202);
                
            } else {
                return response()->json([
                    'message'=>"There's no Call Log with the CallLogId of " . $callLogId,
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
