<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use Illuminate\Http\Request;

class BeritaAcaraController extends Controller
{
    /**
     * Display a listing of the resource (Index)
     * Menampilkan daftar semua berita acara
     */
    public function index()
    {
        $beritaAcaras = BeritaAcara::paginate(10);
        return view('admin.berita-acara.index', compact('beritaAcaras'));
    }

    /**
     * Show the form for creating a new resource (Create Form)
     * Menampilkan form untuk membuat berita acara baru
     */
    public function create()
    {
        return view('admin.berita-acara.create');
    }

    /**
     * Store a newly created resource in storage (Store)
     * Menyimpan data berita acara baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_berita' => 'required|unique:berita_acara',
            'id_tahun' => 'required|exists:tahun,id_tahun',
            'id_dusun' => 'required|exists:dusun,id_dusun',
            'hari' => 'required|string',
            'tanggal' => 'required|date',
            'tempat' => 'required|string',
            'materi' => 'required|string',
            'pemimpin' => 'required|string',
            'notulis1' => 'nullable|string',
            'notulis2' => 'nullable|string',
        ]);

        // Simpan berita acara baru
        BeritaAcara::create($validated);

        return redirect()->route('berita-acara.index')
            ->with('success', 'Berita Acara berhasil ditambahkan');
    }

    /**
     * Display the specified resource (Show/View)
     * Menampilkan detail berita acara tertentu
     */
    public function show($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        return view('admin.berita-acara.show', compact('beritaAcara'));
    }

    /**
     * Show the form for editing the specified resource (Edit Form)
     * Menampilkan form untuk mengedit berita acara
     */
    public function edit($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        return view('admin.berita-acara.edit', compact('beritaAcara'));
    }

    /**
     * Update the specified resource in storage (Update)
     * Mengupdate data berita acara di database
     */
    public function update(Request $request, $id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'id_tahun' => 'required|exists:tahun,id_tahun',
            'id_dusun' => 'required|exists:dusun,id_dusun',
            'hari' => 'required|string',
            'tanggal' => 'required|date',
            'tempat' => 'required|string',
            'materi' => 'required|string',
            'pemimpin' => 'required|string',
            'notulis1' => 'nullable|string',
            'notulis2' => 'nullable|string',
        ]);

        // Update berita acara
        $beritaAcara->update($validated);

        return redirect()->route('berita-acara.index')
            ->with('success', 'Berita Acara berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage (Delete)
     * Menghapus berita acara dari database
     */
    public function destroy($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        $beritaAcara->delete();

        return redirect()->route('berita-acara.index')
            ->with('success', 'Berita Acara berhasil dihapus');
    }
}
