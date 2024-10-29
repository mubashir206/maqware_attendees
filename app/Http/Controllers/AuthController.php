<?php

namespace App\Http\Controllers;

use App\Mail\OtpCodemail;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
    
    
        $google2fa = new Google2FA();
        $google2faSecret = $google2fa->generateSecretKey();
    
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'google2fa_secret' => $google2faSecret,
            'otp' => null, 
        ]);
    
       
        $otp = $google2fa->getCurrentOtp($google2faSecret);
        
       
        $user->otp = $otp;
        $user->save();
    
        
        $otpAuthUrl = "otpauth://totp/YourAppName:{$user->email}?secret={$google2faSecret}&issuer= Otp code = {$otp}";
    
        $qrCode = QrCode::size(200)->generate($otpAuthUrl);

        Mail::to($user->email)->send(new OtpCodemail($otp));
        
    
        // Show the 2FA setup page with QR code
        return view('auth.2fa-setup', compact('qrCode', 'google2faSecret', 'otp'));
    }
    
    
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
        'otp' => 'required|string|size:6',
    ]);

    // Check the user
    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Invalid login details'], 401);
    }

    // Check if the OTP is valid
    if ($user->otp === $credentials['otp']) {
        Auth::login($user);
        return redirect('event');
    }

    return response()->json(['message' => 'Invalid OTP'], 401);
}


    public function verify2faPage()
    {
        return view('auth.verify-2fa');
    }

    public function verify2fa(Request $request)
    {
        $request->validate(['otp' => 'required|string']);
    
        $user = Auth::user();
    
        if ($request->otp === $user->otp) {
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
