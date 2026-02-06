<?php

namespace App\Http\Controllers;

use App\Models\SumberBiaya;
use Illuminate\Http\Request;

class SumberBiayaController extends Controller
{
    public function index()
    {
        $sumberBiayas = SumberBiaya::all();
        $sumberBiayas = SumberBiaya::paginate(10);
        return view('admin.sumber-biaya.index', compact('sumberBiayas'));
    }

    public function create()
    {
        return view('admin.sumber-biaya.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
        ]);

        SumberBiaya::create($validated);
        return redirect()->route('sumber-biaya.index')->with('success', 'Sumber Biaya berhasil ditambahkan');
    }

    public function show($id)
    {
        $sumberBiaya = SumberBiaya::findOrFail($id);
        return view('admin.sumber-biaya.show', compact('sumberBiaya'));
    }

    public function edit($id)
    {
        $sumberBiaya = SumberBiaya::findOrFail($id);
        return view('admin.sumber-biaya.edit', compact('sumberBiaya'));
    }

    public function update(Request $request, $id)
    {
        $sumberBiaya = SumberBiaya::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        $sumberBiaya->update($validated);
        return redirect()->route('sumber-biaya.index')->with('success', 'Sumber Biaya berhasil diperbarui');
    }

    public function destroy($id)
    {
        $sumberBiaya = SumberBiaya::findOrFail($id);
        $sumberBiaya->delete();
        return redirect()->route('sumber-biaya.index')->with('success', 'Sumber Biaya berhasil dihapus');
    }
}
