<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PatientAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user is a patient to denied him access the dashboard
        $user = Auth::user();
        if ((Auth::check() && $user->roles()->count() === 1 && $user->hasRole('patient'))) { // if user is admin
            Auth::logout();
            return redirect()->route('login');
        }
        return $next($request);
    }
}
