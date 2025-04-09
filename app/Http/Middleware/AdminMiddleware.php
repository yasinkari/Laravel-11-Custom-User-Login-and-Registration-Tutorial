<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
<<<<<<< HEAD
        if (Auth::check() && Auth::user()->role === 'admin') {
=======
        if (Auth::check() && Auth::user()->user_role === 'admin') {
>>>>>>> master
            return $next($request);
        }

        return redirect('/login')->withErrors('Access denied. Admins only.');
    }
}
