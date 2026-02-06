<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // MAINTENANCE MODE: Bypass authentication temporarily
        // Cek apakah admin sudah authenticated
        // if (!session()->get('admin_authenticated')) {
        //     return redirect('/admin/login')->with('error', 'Silakan login terlebih dahulu');
        // }

        return $next($request);
    }
}
