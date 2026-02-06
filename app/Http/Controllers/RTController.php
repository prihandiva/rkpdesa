<?php

namespace App\Http\Controllers;

use App\Models\RT;
use Illuminate\Http\Request;

class RTController extends Controller
{
    public function index()
    {
        $rts = RT::with(['dusun', 'rw'])->paginate(10);
        return view('admin.rt.index', compact('rts'));
    }

    public function create()
    {
        return view('admin.rt.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_dusun' => 'required|exists:dusun,id_dusun',
            'id_rw' => 'required|exists:rw,id_rw',
            'nama_rt' => 'required|string|max:255',
        ]);

        RT::create($validated);
        return redirect()->route('rt.index')->with('success', 'RT berhasil ditambahkan');
    }

    public function show($id)
    {
        $rt = RT::findOrFail($id);
        return view('admin.rt.show', compact('rt'));
    }

    public function edit($id)
    {
        $rt = RT::findOrFail($id);
        return view('admin.rt.edit', compact('rt'));
    }

    public function update(Request $request, $id)
    {
        $rt = RT::findOrFail($id);
        $validated = $request->validate([
            'id_dusun' => 'required|exists:dusun,id_dusun',
            'id_rw' => 'required|exists:rw,id_rw',
            'nama_rt' => 'required|string|max:255',
        ]);
        $rt->update($validated);
        return redirect()->route('rt.index')->with('success', 'RT berhasil diperbarui');
    }

    public function destroy($id)
    {
        $rt = RT::findOrFail($id);
        $rt->delete();
        return redirect()->route('rt.index')->with('success', 'RT berhasil dihapus');
    }
}
