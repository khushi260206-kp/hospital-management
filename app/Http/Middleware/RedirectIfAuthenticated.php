<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                return match($user->role) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'doctor' => redirect()->route('doctor.dashboard'),
                    'receptionist' => redirect()->route('receptionist.dashboard'),
                    'patient' => redirect()->route('patient.dashboard'),
                    default => redirect('/'),
                };
            }
        }

        return $next($request);
    }
}

