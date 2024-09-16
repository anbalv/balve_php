<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Unterscheide zwischen normalen und API-Anfragen
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 401); // Für API/AJAX-Anfragen
            }

            // Bei nicht authentifiziertem Benutzer zur Login-Seite umleiten und vorherige URL speichern
            return redirect()->route('auth.login')->with('error', 'You must be logged in to access this page.')
                ->with('url.intended', url()->current()); // Speichert die aktuelle URL
        }

        return $next($request);
    }
}
