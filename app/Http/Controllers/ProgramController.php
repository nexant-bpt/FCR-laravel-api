<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    //
    public function index()
    {


        $programStatus = 1;
        $programs = DB::table('programs')->select("ProgramID", "Name", "ContactName", "CreateDate")->paginate(15);


        return response()->json(
            $programs
        , 200);
    }

    public function minimumData()
    {


        $clientStatus = 1;
        $programs = DB::table('programs')->select("ProgramID", 'Name');


        return response()->json(
            $programs
        , 200);
    }


    public function store(Request $request)
    {
        $rules = [
            'Name' => ['required', 'string', 'max:255'],
            'ClientId' => ['required', 'integer'],
            'TransferInstruction' => ['required', 'string'],
            'Summary'=> ['required', 'string'],
            'KeyWords'=> ['required', 'string'],
            'AssociatedStates'=> ['required', 'string'],
            'ContactName'=> ['required', 'string'],
            'Links'=> ['required', 'string'],
            'TransferType'=> ['required', 'string'],
            'TransferPhone'=> ['required', 'string'],
            'Description'=> ['required', 'string'],
            'Type'=> ['required', 'string'],
            'Status'=> ['required', 'integer'],  
        ];
        Log::debug("THIS IS REQUEST");
        Log::debug($request);
        Log::debug("THIS IS REQUEST");

        $validator = Validator::make($request->all(), $rules);
        if ($validator && $validator->passes()) {
            // we check to see if there's already a user with that F9ClientID
           
                $program = Program::create($request->all());
                return response()->json([
                    "ProgramID" => $program->id,
                ], 201);
            
            
   
        }else {
              //TODO Handle your error
              return response()->json(
                $validator->errors(),
                500
            );
        }

      

        
    }


    public function updateProgramDetails(Request $request, $ProgramId)
    {

       

        if(gettype($ProgramId) === "String"){
            $ProgramId = intval($ProgramId);
        }



       
        Log::debug("THIS IS REQUEST");
        Log::debug($request);
        Log::debug("THIS IS REQUEST");
    

        $existingProgram = DB::table('programs')->where('ProgramID', '=', $request->ProgramID)->first();
        if ($existingProgram) {
          

            $program = Program::where('ProgramID', $request->ProgramID);
            $program->update($request->all());
    
            // 204 no content response since it's a patch
            return response()->json([
                $program
            ], 200);
            
        } else {
            return response()->json([
                'ProgramId' => 'there is no program with the ProgramID of ' . $request->input('ProgramID'),
            ], 404); 
        }
    
       
    }

    public function show(Request $request, $ProgramId)
    {
    
        $existingProgram = DB::table('programs')->where('ProgramID', '=', $ProgramId)->first();
        if ($existingProgram) {
          

            return response()->json(
                $existingProgram
            , 200);
            
        } else {
            return response()->json([
                'ProgramID' => 'there is no program with the ProgramID of ' . $request->input('ProgramId'),
            ], 404); 
        }

    }
}
