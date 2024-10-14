<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('unauthorized');
        }

        // if (Auth::user()->google2fa_secret && !session('2fa_verified')) {
        //     return redirect('verify-2fa')->withErrors(['error' => 'Please verify your 2FA.']);
        // }
        
        return $next($request);
    }
}
