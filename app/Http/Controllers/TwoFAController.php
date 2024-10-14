<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFAController extends Controller
{

    public function show2FASetup()
    {
        $user = Auth::user();
        if (!$user->google2fa_secret) {
            $user->generateGoogle2FASecret();
        }

        $google2fa_url = (new \PragmaRX\Google2FAQRCode\Google2FA())->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        return view('auth.2fa_setup', compact('google2fa_url'));
    }


    public function show2FAVerification()
    {
        return view('auth.2fa_verify');
    }

    public function verify2FACode(Request $request)
    {
        $user = Auth::user();
        if ($user->verifyGoogle2FACode($request->input('2fa_code'))) {
            $user->google2fa_passed = true; 
            $user->save();
            return redirect()->route('home');
        }

        return back()->withErrors(['2fa_code' => 'The provided 2FA code is invalid']);
    }
}
