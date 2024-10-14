<?php

namespace App\Http\Controllers;

use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Generate 2FA secret
        $google2fa = new Google2FA();
        $google2faSecret = $google2fa->generateSecretKey();
    
        // Store user with the secret key
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'google2fa_secret' => $google2faSecret,
        ]);
    
        
    
    $otp = $google2fa->getCurrentOtp($google2faSecret);

    // Generate the QR Code URL
    $otpAuthUrl = "otpauth://totp/YourAppName:{$user->email}?secret={$google2faSecret}&issuer=YourAppName&counter={$otp}";

    // Generate the QR code
    $qrCode = QrCode::size(200)->generate($otpAuthUrl);

    // Show the 2FA setup page with QR code
    return view('auth.2fa-setup', compact('qrCode', 'google2faSecret', 'otp'));
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

        
         if ($user->google2fa_secret) {
            return redirect()->route('verify2faPage');
        }

        session(['2fa_verified' => true]);

        return redirect('event');
       
    }

    public function verify2faPage()
    {
        return view('auth.verify-2fa');
    }

    public function verify2fa(Request $request)
    {
        $request->validate(['otp' => 'required|string']);

        $google2fa = app('pragmarx.google2fa');
        $user = Auth::user();

    
        if ($google2fa->verifyKey($user->google2fa_secret, $request->otp)) {
            session(['2fa_verified' => true]);  // Mark as verified
            return redirect('event');
        }

        return back()->withErrors(['error' => 'Invalid OTP.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->forget('2fa_verified');
        return redirect('login-page')->with('success', 'Logged out successfully.');
    }

    
}
