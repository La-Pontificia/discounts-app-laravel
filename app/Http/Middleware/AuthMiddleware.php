<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    public function handle(Request $req, Closure $next)
    {
        if (Auth::check()) {
            // Maximo 1hora de sesion
            return $next($req);
        }
        return redirect('/login');
    }
}
