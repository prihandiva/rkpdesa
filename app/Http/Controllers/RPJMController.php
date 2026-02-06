<?php

namespace App\Http\Controllers;

use App\Models\RPJM;
use Illuminate\Http\Request;

class RPJMController extends Controller
{
    /**
     * Display a listing of the resource (Index)
     * Menampilkan daftar semua RPJM
     */
    public function index()
    {
        $rpjms = RPJM::paginate(10);
        return view('admin.rpjm.index', compact('rpjms'));
    }

    /**
     * Show the form for creating a new resource (Create Form)
     * Menampilkan form untuk membuat RPJM baru
     */
    public function create()
    {
        return view('admin.rpjm.create');
    }

    /**
     * Store a newly created resource in storage (Store)
     * Menyimpan data RPJM baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            // Sesuaikan dengan fillable model RPJM
        ]);

        // Simpan RPJM baru
        RPJM::create($validated);

        return redirect()->route('rpjm.index')
            ->with('success', 'RPJM berhasil ditambahkan');
    }

    /**
     * Display the specified resource (Show/View)
     * Menampilkan detail RPJM tertentu
     */
    public function show($id)
    {
        $rpjm = RPJM::findOrFail($id);
        return view('admin.rpjm.show', compact('rpjm'));
    }

    /**
     * Show the form for editing the specified resource (Edit Form)
     * Menampilkan form untuk mengedit RPJM
     */
    public function edit($id)
    {
        $rpjm = RPJM::findOrFail($id);
        return view('admin.rpjm.edit', compact('rpjm'));
    }

    /**
     * Update the specified resource in storage (Update)
     * Mengupdate data RPJM di database
     */
    public function update(Request $request, $id)
    {
        $rpjm = RPJM::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            // Sesuaikan dengan fillable model RPJM
        ]);

        // Update RPJM
        $rpjm->update($validated);

        return redirect()->route('rpjm.index')
            ->with('success', 'RPJM berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage (Delete)
     * Menghapus RPJM dari database
     */
    public function destroy($id)
    {
        $rpjm = RPJM::findOrFail($id);
        $rpjm->delete();

        return redirect()->route('rpjm.index')
            ->with('success', 'RPJM berhasil dihapus');
    }
}
