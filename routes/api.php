<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\RPJMController;
use App\Http\Controllers\Api\RKPDesaController;
use App\Http\Controllers\Api\UsulanController;
use App\Http\Controllers\Api\BeritaAcaraController;
use App\Http\Controllers\Api\NotifikasiController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    Route::get('/notifikasi', [NotifikasiController::class, 'index']);
    Route::post('/notifikasi/mark-all-read', [NotifikasiController::class, 'markAllAsRead']);
    
    Route::get('/rpjm', [RPJMController::class, 'index']);
    Route::get('/rpjm/bidang', [RPJMController::class, 'getBidang']);
    Route::get('/rpjm/{id}', [RPJMController::class, 'show']);
    
    Route::get('/rkpdesa', [RKPDesaController::class, 'index']);
    Route::get('/rkpdesa/tahun', [RKPDesaController::class, 'getTahun']);
    Route::get('/rkpdesa/{id}', [RKPDesaController::class, 'show']);
    
    Route::get('/usulan', [UsulanController::class, 'index']);
    Route::get('/usulan/dusun', [UsulanController::class, 'getDusun']);
    Route::get('/usulan/{id}', [UsulanController::class, 'show']);
    
    Route::get('/berita-acara', [BeritaAcaraController::class, 'index']);
    Route::get('/berita-acara/{id}', [BeritaAcaraController::class, 'show']);
});
