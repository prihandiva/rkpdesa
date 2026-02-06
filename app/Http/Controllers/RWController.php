<?php

namespace App\Http\Controllers;

use App\Models\RW;
use Illuminate\Http\Request;

class RWController extends Controller
{
    public function index()
    {
        $rws = RW::with('dusun')->paginate(10);
        return view('admin.rw.index', compact('rws'));
    }

    public function create()
    {
        return view('admin.rw.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_dusun' => 'required|exists:dusun,id_dusun',
            'nama_rw' => 'required|string|max:255',
        ]);

        RW::create($validated);
        return redirect()->route('rw.index')->with('success', 'RW berhasil ditambahkan');
    }

    public function show($id)
    {
        $rw = RW::findOrFail($id);
        return view('admin.rw.show', compact('rw'));
    }

    public function edit($id)
    {
        $rw = RW::findOrFail($id);
        return view('admin.rw.edit', compact('rw'));
    }

    public function update(Request $request, $id)
    {
        $rw = RW::findOrFail($id);
        $validated = $request->validate([
            'id_dusun' => 'required|exists:dusun,id_dusun',
            'nama_rw' => 'required|string|max:255',
        ]);
        $rw->update($validated);
        return redirect()->route('rw.index')->with('success', 'RW berhasil diperbarui');
    }

    public function destroy($id)
    {
        $rw = RW::findOrFail($id);
        $rw->delete();
        return redirect()->route('rw.index')->with('success', 'RW berhasil dihapus');
    }
}
