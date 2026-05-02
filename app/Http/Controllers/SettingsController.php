<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Tampilkan halaman pengaturan
     */
    public function index()
    {
        // Ambil preferensi notifikasi dari session (default semua aktif)
        $notifPreferences = session('notif_preferences', [
            'rpjm'         => true,
            'usulan'       => true,
            'rkpdesa'      => true,
            'berita_acara' => true,
        ]);

        return view('admin.pengaturan.index', compact('notifPreferences'));
    }

    /**
     * Simpan preferensi notifikasi ke session
     */
    public function updateNotifikasi(Request $request)
    {
        $preferences = [
            'rpjm'         => $request->boolean('notif_rpjm'),
            'usulan'       => $request->boolean('notif_usulan'),
            'rkpdesa'      => $request->boolean('notif_rkpdesa'),
            'berita_acara' => $request->boolean('notif_berita_acara'),
        ];

        session(['notif_preferences' => $preferences]);

        return redirect()->route('pengaturan.index')
            ->with('success', 'Pengaturan notifikasi berhasil disimpan.');
    }
}
