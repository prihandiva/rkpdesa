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
        // Cek apakah admin sudah authenticated
        if (!session()->get('admin_authenticated')) {
            // Jika request dari AJAX, return JSON 401 agar bisa ditangani JS
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['session_expired' => true, 'redirect' => route('admin.login')], 401);
            }
            return redirect()->route('admin.login')->with('session_expired', true);
        }

        return $next($request);
    }
}
