<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index(){
        return view('auth.register');
    }

    public function store(Request $request){
        // validation
        $this->validate($request, [
            'UserName' => 'required|max:255',
            'UserEmail' => 'required|email|max:255',
            'password' => 'required|confirmed',
        ]);

        // store user
        User::create([
            'UserName' => $request->UserName,
            'UserEmail' => $request->UserEmail,
            'password' => Hash::make($request->password),
        ]);

        // sign the user in
        auth()->attempt($request->only('UserEmail', 'password'));
        // redirect
        return redirect()->route('dashboard');

    }
}
