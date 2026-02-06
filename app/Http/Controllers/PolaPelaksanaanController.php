<?php

namespace App\Http\Controllers;

use App\Models\PolaPelaksanaan;
use Illuminate\Http\Request;

class PolaPelaksanaanController extends Controller
{
    public function index()
    {
        $polaPelaksanaans = PolaPelaksanaan::all();
        $polaPelaksanaans = PolaPelaksanaan::paginate(10);
        return view('admin.pola-pelaksanaan.index', compact('polaPelaksanaans'));
    }

    public function create()
    {
        return view('admin.pola-pelaksanaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        PolaPelaksanaan::create($validated);
        return redirect()->route('pola-pelaksanaan.index')->with('success', 'Pola Pelaksanaan berhasil ditambahkan');
    }

    public function show($id)
    {
        $polaPelaksanaan = PolaPelaksanaan::findOrFail($id);
        return view('admin.pola-pelaksanaan.show', compact('polaPelaksanaan'));
    }

    public function edit($id)
    {
        $polaPelaksanaan = PolaPelaksanaan::findOrFail($id);
        return view('admin.pola-pelaksanaan.edit', compact('polaPelaksanaan'));
    }

    public function update(Request $request, $id)
    {
        $polaPelaksanaan = PolaPelaksanaan::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        $polaPelaksanaan->update($validated);
        return redirect()->route('pola-pelaksanaan.index')->with('success', 'Pola Pelaksanaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $polaPelaksanaan = PolaPelaksanaan::findOrFail($id);
        $polaPelaksanaan->delete();
        return redirect()->route('pola-pelaksanaan.index')->with('success', 'Pola Pelaksanaan berhasil dihapus');
    }
}
