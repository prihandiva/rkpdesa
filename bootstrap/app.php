<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.admin' => \App\Http\Middleware\AuthAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // ─── Database / Query Errors ─────────────────────────────────────
        $exceptions->render(function (QueryException $e, Request $request) {
            Log::error('Database error: ' . $e->getMessage());

            $userMessage = 'Terjadi kesalahan pada database. Silakan coba lagi.';

            // Beri pesan lebih spesifik untuk kasus yang umum
            if (str_contains($e->getMessage(), 'Out of range value')) {
                $userMessage = 'Nilai yang dimasukkan terlalu besar untuk kolom tersebut. Periksa kembali angka yang diinput.';
            } elseif (str_contains($e->getMessage(), 'Duplicate entry')) {
                $userMessage = 'Data duplikat terdeteksi. Data dengan nilai yang sama sudah ada.';
            } elseif (str_contains($e->getMessage(), 'Cannot add or update a child row')) {
                $userMessage = 'Data referensi tidak ditemukan. Pastikan pilihan yang dipilih masih tersedia.';
            } elseif (str_contains($e->getMessage(), 'Data too long')) {
                $userMessage = 'Teks yang dimasukkan terlalu panjang untuk kolom tersebut.';
            }

            if ($request->expectsJson()) {
                return response()->json(['error' => $userMessage], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $userMessage);
        });

        // ─── General / Unexpected Errors ─────────────────────────────────
        $exceptions->render(function (\Throwable $e, Request $request) {
            // Jangan override error validasi Laravel (sudah ditangani otomatis)
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return null; // biarkan Laravel menangani sendiri
            }
            // Jangan override 404 / model not found
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException
                || $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return null;
            }

            Log::error('Unhandled error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());

            if ($request->expectsJson()) {
                return response()->json(['error' => 'Terjadi kesalahan server. Silakan coba lagi.'], 500);
            }

            // Hanya tampilkan halaman error, bukan redirect back, untuk error tak terduga
            if (app()->environment('production')) {
                return response()->view('errors.500', ['message' => 'Terjadi kesalahan tidak terduga.'], 500);
            }

            return null; // Di local/development, tetap tampilkan debug page
        });

    })->create();

