<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Überprüfen, ob der Benutzer eingeloggt ist und die Rolle 'admin' hat
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        // Unautorisierter Zugriff
        return redirect('/')->with('error', 'Unauthorized access. You do not have admin rights.');
    }
}
