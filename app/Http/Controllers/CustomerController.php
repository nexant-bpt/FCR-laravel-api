<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //\

    public function index()
    {


        $customers = DB::table('customers')->paginate(15);


        return response()->json(
            $customers
        , 200);
    }


    public function minimumData()
    {


        $customers = DB::table('customers')->select("CustomerId")->get();


        return response()->json(
            $customers
        , 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'CompressedName' => ['required', 'string', 'max:255'],
            'ClientID' => ['required', 'integer'],
            'AccountNumber' => ['required', 'string'],
            'Phone1' => ['required', 'string']

        ];
        Log::debug("THIS IS REQUEST");
        Log::debug($request);
        Log::debug("THIS IS REQUEST");

        $validator = Validator::make($request->all(), $rules);
        if ($validator && $validator->passes()) {
            // we check to see if there's already a user with that F9ClientID
            $existingCustomer = Customer::where([
            ['AccountNumber', $request->input('AccountNumber')],
            ['ClientID', $request->input('ClientID')]

            ]
            )->first();
            if ($existingCustomer) {
                return response()->json([
                    'ClientID' => 'there is already a customer for that client with that account number ' . $request->input('AccountNumber'),
                ], 409);
            } else {
                $customer = Customer::create($request->all());
                return response()->json([
                    "CustomerID" => $customer->id,
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


    public function update(Request $request, $CustomerID)
    {



        $customer = Customer::findOrFail($CustomerID);
        $customer->update($request->all());

        // query goes here
        return response()->json([
            $customer
        ], 200);
    }

    public function updateDetails(Request $request, $CustomerID)
    {



        $customer = Customer::findOrFail($CustomerID);
        $customer->update($request->all());

        // query goes here
        return response()->json([
            $customer
        ], 200);
    }

    public function show(Request $request, $CustomerID)
    {
    
        $existingClient = DB::table('customer')->where('CustomerID', '=', $CustomerID)->first();
        if ($existingClient) {
          

            return response()->json(
                $existingClient
            , 200);
            
        } else {
            return response()->json([
                'CustomerID' => 'there is no customer with the CustomerID of ' . $request->input('CustomerID'),
            ], 404); 
        }

    }

    public function destroy(Request $request)
    {

        $customer = Customer::findOrFail($request);
        $customer->delete();

        return response()->json([
            'success' => 'delete an item',
        ], 202);
        // query goes here
    }

}
