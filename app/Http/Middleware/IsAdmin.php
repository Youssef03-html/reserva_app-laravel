<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
   
    // Controla el acces, en cas que sigui el admin, pot passar, en canvi si no ho és, l'envia al inici amb un missatge d'error.
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') { // si el rol es de admin pot passar
            return $next($request);
        }
        return redirect('/')->with('error', 'No tens permisos per accedir a aquesta secció.'); // si no surt per l'if, surt per aqui, amb un missatge d'error 
    }
}
