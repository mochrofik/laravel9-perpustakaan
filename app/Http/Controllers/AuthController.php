<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller

{

    public function index(Request $request){



    
            return view('login.login');
        
    }
    public function login(Request $request){

        

        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

                $value = $request->cookie('keyLogin');

                $request->session()->regenerate();
                return redirect()->intended('/home');
            }
    
            return back()->withErrors([
                'password' => 'Wrong username or password',
            ])->with('error', "Login Error!");
        

    }

        public function logout(Request $request)
        {
            Auth::logout();
    
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect('/')->with('success', 'Logout success');
            }
}
