<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;




class ClientController extends Controller
{

    public function index()
    {


        $clientStatus = 1;
        $clients = DB::table('clients')->where('ClientStatus', '=', $clientStatus)->select("ClientId", "created_at", 'updated_at', 'Name', 'GreetingInitial', 'Icon', 'Logo', 'Header', 'Website', 'CreateDate', 'ClientStatus', 'SourceScript', 'TopPrograms')->paginate(15);


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
        Log::debug("THIS IS REQUEST");
        Log::debug($request);
        Log::debug("THIS IS REQUEST");

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
                    "ClientId" => $client->id,
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

    public function updateClientLogo(Request $request)
    {
        $rules = [
            'Logo' => ['required', 'string', 'min:5'],
            'ClientId' => ['required', 'integer'],
        ];
        Log::debug("THIS IS REQUEST");
        Log::debug($request);
        Log::debug("THIS IS REQUEST");

        $validator = Validator::make($request->all(), $rules);
        if ($validator && $validator->passes()) {


        $existingClient = DB::table('clients')->where('ClientId', '=', $request->ClientId)->first();
        if ($existingClient) {
          

            $client = Client::where('ClientId', $request->ClientId);
            $client->update(["Logo"=> $request->Logo]);
    
            // 204 no content response since it's a patch
            return response()->json([
                $client
            ], 204);
            
        } else {
            return response()->json([
                'ClientId' => 'there is no client with the ClientId of ' . $request->input('ClientId'),
            ], 404); 
        }
    }else {
              //TODO Handle your error
              return response()->json(
                $validator->errors(),
                500
            );
        }
       
    }


    public function updateClientDetails(Request $request, $ClientId)
    {

       

        if(gettype($ClientId) === "String"){
            $ClientId = intval($ClientId);
        }

        if($request->WebSite){
            $parsedUrl = parse_url($request->WebSite);
            $schemeKeyExists = array_key_exists('scheme', $parsedUrl);
         

            if($schemeKeyExists && $parsedUrl['scheme'] === "https"){
                Log::debug("GOT SCHEME");
                Log::debug($parsedUrl);
                Log::debug("GOT SCHEME"); 
            // }}
            } else {
                return response()->json([
                    'WebSite' =>  'Please enter in a https ',
                ], 500); 
            }
         
        }


       
        Log::debug("THIS IS REQUEST");
        Log::debug($request);
        Log::debug("THIS IS REQUEST");
    

        $existingClient = DB::table('clients')->where('ClientId', '=', $request->ClientId)->first();
        if ($existingClient) {
          

            $client = Client::where('ClientId', $request->ClientId);
            $client->update($request->all());
    
            // 204 no content response since it's a patch
            return response()->json([
                $client
            ], 200);
            
        } else {
            return response()->json([
                'ClientId' => 'there is no client with the ClientId of ' . $request->input('ClientId'),
            ], 404); 
        }
    
       
    }
  
  

    public function show(Request $request, $ClientId)
    {
    
        $existingClient = DB::table('clients')->where('ClientId', '=', $ClientId)->first();
        if ($existingClient) {
          

            return response()->json(
                $existingClient
            , 200);
            
        } else {
            return response()->json([
                'ClientId' => 'there is no client with the ClientId of ' . $request->input('ClientId'),
            ], 404); 
        }

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
