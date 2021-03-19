<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;




class ClientController extends Controller
{

    public function index()
    {

        $clients = Client::all();

        return response()->json([
            $clients
        ]);
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 500);
        }

        $client = Client::create($request->all());

        return response()->json([
            $client,
        ], 201);
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
