<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
  
class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
          
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
    
            if($finduser){
                Auth::login($finduser);
                return redirect()->intended('event');
            } else {
                $newUser = User::updateOrCreate([
                    'email' => $user->email
                ], [
                    'name' => $user->name,
                    'google_id'=> $user->id,
                    'password' => encrypt('12345678')
                ]);
    
                Auth::login($newUser);
                return redirect()->intended('event');
            }
    
        } catch (Exception $e) {
            return redirect()->route('login-page')->with('error', $e->getMessage()); 
        }
    }
    
}
