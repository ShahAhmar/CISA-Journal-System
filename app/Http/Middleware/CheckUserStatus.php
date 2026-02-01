<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     * Check if authenticated user is active, not suspended, and not terminated
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Check if user is terminated
            if ($user->terminated_at) {
                Auth::logout();
                $request->session()->invalidate();
                return redirect()->route('login')->withErrors([
                    'email' => 'Your account has been terminated. Please contact the administrator.',
                ]);
            }
            
            // Check if user is suspended
            if ($user->suspended_at) {
                Auth::logout();
                $request->session()->invalidate();
                return redirect()->route('login')->withErrors([
                    'email' => 'Your account has been suspended. Please contact the administrator.',
                ]);
            }
            
            // Check if user is disabled
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                return redirect()->route('login')->withErrors([
                    'email' => 'Your account has been disabled. Please contact the administrator.',
                ]);
            }
        }

        return $next($request);
    }
}

