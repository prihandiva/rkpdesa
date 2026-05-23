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
        // Cek apakah user sudah login (session user_authenticated atau admin_authenticated)
        $isAuthenticated = session()->get('user_authenticated') || session()->get('admin_authenticated');

        if (!$isAuthenticated) {
            // Jika request AJAX/JSON, return 401
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'session_expired' => true,
                    'redirect'        => route('admin.login'),
                    'message'         => 'Sesi anda telah berakhir. Silakan login kembali.',
                ], 401);
            }

            // Simpan URL yang ingin diakses agar bisa di-redirect setelah login
            session()->put('intended_url', $request->url());

            return redirect()->route('admin.login')
                ->with('info', 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.');
        }

        // Teruskan request lalu tambahkan header no-cache.
        // Gunakan headers->set() (bukan ->header() chaining) agar kompatibel
        // dengan semua tipe response termasuk BinaryFileResponse (Excel/PDF download).
        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }
}
