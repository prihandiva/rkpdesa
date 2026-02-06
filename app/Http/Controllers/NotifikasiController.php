<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi::paginate(10);
        return view('admin.notifikasi.index', compact('notifikasis'));
    }

    public function create()
    {
        return view('admin.notifikasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_notif' => 'required|unique:notifikasi',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'id_kegiatan' => 'nullable|string',
            'judul_kegiatan' => 'nullable|string',
            'status' => 'required|in:baru,dibaca,diarsipkan',
            'id_penerima' => 'required|exists:users,id_user',
            'dibaca' => 'nullable|boolean',
        ]);

        Notifikasi::create($validated);
        return redirect()->route('notifikasi.index')->with('success', 'Notifikasi berhasil ditambahkan');
    }

    public function show($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        return view('admin.notifikasi.show', compact('notifikasi'));
    }

    public function edit($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        return view('admin.notifikasi.edit', compact('notifikasi'));
    }

    public function update(Request $request, $id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'id_kegiatan' => 'nullable|string',
            'judul_kegiatan' => 'nullable|string',
            'status' => 'required|in:baru,dibaca,diarsipkan',
            'id_penerima' => 'required|exists:users,id_user',
            'dibaca' => 'nullable|boolean',
        ]);
        $notifikasi->update($validated);
        return redirect()->route('notifikasi.index')->with('success', 'Notifikasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->delete();
        return redirect()->route('notifikasi.index')->with('success', 'Notifikasi berhasil dihapus');
    }
}
