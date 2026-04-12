<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = auth()->user() ?? \App\Models\User::find(session('user_id'));
        
        $query = Notifikasi::orderBy('created_at', 'desc');
        
        // Uncomment below to restrict to only notifications for current user
        // if ($user) {
        //     $query->where(function($q) use ($user) {
        //         $q->whereRaw('FIND_IN_SET(?, id_penerima)', [$user->id_user])
        //           ->orWhereNull('id_penerima');
        //     });
        // }
        
        $notifikasis = $query->paginate(15);
        
        return view('admin.notifikasi.index', compact('notifikasis', 'user'));
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
