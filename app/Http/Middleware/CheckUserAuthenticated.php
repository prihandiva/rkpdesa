<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // MAINTENANCE MODE: Bypass authentication temporarily
        // if (!session()->get('user_authenticated')) {
        //     return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        // }

        return $next($request);
    }
}
