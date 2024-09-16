<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Benutzer basierend auf ihrer Rolle weiterleiten
                $user = Auth::guard($guard)->user();

                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard'); // Admin-Dashboard
                }

                return redirect()->route('user.dashboard'); // Benutzer-Dashboard
            }
        }

        return $next($request);
    }
}
