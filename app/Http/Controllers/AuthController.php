<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerPage(){
        return view('auth.register');
    }

    public function loginPage(){
        return view('auth.login');
    }

    public function register(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);


        // $google2fa = app('pragmarx.google2fa');
        // $google2faSecret = $google2fa->generateSecretKey();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            // 'google2fa_secret' => $google2faSecret,
        ]);

        
        return redirect('login-page');

    }

    public function login(Request $request)
    {
        // dd($request);

        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = Auth::user();

        // $google2fa = app('pragmarx.google2fa');

       
        // $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp);

        // if (!$valid) {
        //     Auth::logout();
        //     return back()->withErrors(['error' => 'Invalid OTP']);
        // }

        return redirect('event');
       
    }

    public function logout(Request $request)
    {
        Auth::logout();
       
        return redirect('login-page');

    }

    
}
