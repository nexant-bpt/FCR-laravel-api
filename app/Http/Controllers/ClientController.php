<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;




class ClientController extends Controller
{

    public function index()
    {

        $clients = Client::all();

        return response()->json([
            $clients
        ]);

        $clientStatus = 1;
        $clients = DB::table('clients')->where('ClientStatus', '=', $clientStatus)->select("ClientID", "created_at", 'updated_at', 'Name', 'GreetingInitial', 'Icon', 'Logo', 'Header', 'Website', 'CreateDate', 'ClientStatus', 'SourceScript', 'TopPrograms')->paginate(15);


        return response()->json(
            $clients
        , 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'Name' => ['required', 'string', 'max:255'],
            'F9ClientID' => ['required', 'integer'],
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator && $validator->passes()) {
            // we check to see if there's already a user with that F9ClientID
            $existingClient = Client::where('F9ClientID', $request->input('F9ClientID'))->first();
            if ($existingClient) {
                return response()->json([
                    'F9ClientID' => 'there is already a client with the F9ClientID ' . $request->input('F9ClientID'),
                ], 409);
            } else {
                $client = Client::create($request->all());
                return response()->json([
                    $client,
                ], 201);
            
            }
   
        }else {
              //TODO Handle your error
              return response()->json(
                $validator->errors(),
                500
            );
        }

      

        
    }

    public function update(Request $request, $clientId)
    {



        $client = Client::findOrFail($clientId);
        $client->update($request->all());

        // query goes here
        return response()->json([
            $client
        ], 200);
    }
    public function show(Request $request, $clientId)
    {
        $client = Client::find($clientId);

        return response()->json([
            $client
        ], 202);
    }

    public function destroy(Request $request)
    {

        $client = Client::findOrFail($request);
        $client->delete();

        return response()->json([
            'success' => 'delete an item',
        ], 202);
        // query goes here
    }
}
