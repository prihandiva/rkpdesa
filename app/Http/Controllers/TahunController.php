<?php

namespace App\Http\Controllers;

use App\Models\Tahun;
use Illuminate\Http\Request;

class TahunController extends Controller
{
    /**
     * Display a listing of the resource (Index)
     * Menampilkan daftar semua tahun
     */
    public function index()
    {
        $tahuns = Tahun::paginate(10);
        return view('admin.tahun.index', compact('tahuns'));
    }

    /**
     * Show the form for creating a new resource (Create Form)
     * Menampilkan form untuk membuat tahun baru
     */
    public function create()
    {
        return view('admin.tahun.create');
    }

    /**
     * Store a newly created resource in storage (Store)
     * Menyimpan data tahun baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_tahun' => 'required|unique:tahun',
            'tahun' => 'required|numeric|digits:4',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Simpan tahun baru
        Tahun::create($validated);

        return redirect()->route('tahun.index')
            ->with('success', 'Tahun berhasil ditambahkan');
    }

    /**
     * Display the specified resource (Show/View)
     * Menampilkan detail tahun tertentu
     */
    public function show($id)
    {
        $tahun = Tahun::findOrFail($id);
        return view('admin.tahun.show', compact('tahun'));
    }

    /**
     * Show the form for editing the specified resource (Edit Form)
     * Menampilkan form untuk mengedit tahun
     */
    public function edit($id)
    {
        $tahun = Tahun::findOrFail($id);
        return view('admin.tahun.edit', compact('tahun'));
    }

    /**
     * Update the specified resource in storage (Update)
     * Mengupdate data tahun di database
     */
    public function update(Request $request, $id)
    {
        $tahun = Tahun::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'tahun' => 'required|numeric|digits:4',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Update tahun
        $tahun->update($validated);

        return redirect()->route('tahun.index')
            ->with('success', 'Tahun berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage (Delete)
     * Menghapus tahun dari database
     */
    public function destroy($id)
    {
        $tahun = Tahun::findOrFail($id);
        $tahun->delete();

        return redirect()->route('tahun.index')
            ->with('success', 'Tahun berhasil dihapus');
    }

    /**
     * Update the status of the specified resource
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $tahun = Tahun::findOrFail($id);
            $tahun->status = $request->status;
            $tahun->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status'
            ], 500);
        }
    }
}
