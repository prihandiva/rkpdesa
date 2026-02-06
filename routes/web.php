<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\RKPController;
use App\Http\Controllers\RPJMController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\UsulanController;
use App\Http\Controllers\DusunController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PolaPelaksanaanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RTController;
use App\Http\Controllers\RWController;
use App\Http\Controllers\SumberBiayaController;
use App\Http\Controllers\BidangController;

// Landing page for guests
Route::get('/', function () {
    // DEVELOPMENT MODE: Auto-set session
    if (!session()->get('user_authenticated')) {
        session()->put('user_authenticated', true);
        session()->put('user_id', 'dev-user');
        session()->put('user_name', 'Developer');
        session()->put('user_role', 'admin');
    }

    return view('landing');
});

// Login routes (Public)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard (protected route)
Route::get('/dashboard', function () {
    if (!session()->get('user_authenticated')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
    }
    return view('dashboard');
})->name('dashboard');

// Admin Auth Routes
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// Admin Dashboard Redirect
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

Route::get('/admin/dashboard', function () {
    if (!session()->get('admin_authenticated')) {
        return redirect()->route('admin.login');
    }
    return view('admin.dashboard');
})->name('admin.dashboard');

// Admin CRUD Routes (Resource Routes)
// DEVELOPMENT MODE: Bypass authentication
// Route::middleware(['auth.admin'])->prefix('admin')->group(function () {
Route::prefix('admin')->group(function () {
    Route::resource('user', UserController::class);
    
    // Role Management Routes via UserController
    Route::post('user/role', [UserController::class, 'storeRole'])->name('user.role.store');
    Route::put('user/role/{id}', [UserController::class, 'updateRole'])->name('user.role.update');
    Route::delete('user/role/{id}', [UserController::class, 'destroyRole'])->name('user.role.destroy');

    Route::resource('berita-acara', BeritaAcaraController::class);
    Route::post('rkpdesa/store-from-usulan', [RKPController::class, 'storeFromUsulan'])->name('rkp.store_from_usulan');
    Route::post('usulan/upload-berita-acara', [UsulanController::class, 'uploadBeritaAcara'])->name('usulan.upload_ba');
    Route::resource('usulan', UsulanController::class);
    Route::resource('rkpdesa', RKPController::class);
    Route::resource('rpjm', RPJMController::class);
    Route::resource('rpjm', RPJMController::class);
    Route::post('tahun/{id}/status', [TahunController::class, 'updateStatus'])->name('tahun.status.update');
    Route::resource('tahun', TahunController::class);
    Route::resource('usulan', UsulanController::class);
    Route::resource('dusun', DusunController::class);
    Route::resource('notifikasi', NotifikasiController::class);
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('pola-pelaksanaan', PolaPelaksanaanController::class);
    Route::resource('role', RoleController::class);
    Route::resource('rt', RTController::class);
    Route::resource('rw', RWController::class);
    Route::resource('sumber-biaya', SumberBiayaController::class);
    Route::resource('bidang', BidangController::class);
    // Monitoring
    Route::get('monitoring', [\App\Http\Controllers\MonitoringController::class, 'index'])->name('monitoring.index');
});
